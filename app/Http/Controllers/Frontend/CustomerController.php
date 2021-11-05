<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerSignInRequest;
use App\Http\Requests\CustomerSignUpRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller {
    public function customerSignIn() {
        return view('frontend.customer.sign_in');
    }
    public function signIn(CustomerSignInRequest $request) {
        // dd($request->all());
        $credentials = $request->only('email', 'password');
        if (Auth::guard('customer')->attempt($credentials)) {
            Session::flash('message', 'Successfully logged in');
            return success('ssdsd');
        } else {
            return response()->json([
                'success' => false,
                'message' => 'This credentials does not match with our record',
            ]);
        }
        // if ($customer) {
        //     Session::flash('message','sadsdsdsdsd');
        //     return success('ssdsd');
        // } else {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'This credentials does not match with our record',
        //     ]);
        // }
    }
    public function signUp(CustomerSignUpRequest $request) {
        // dd($request->all());
        $customer = Customer::create($request->validated());
        $data     = Auth::guard('customer')->login($customer);
        Session::flash('message', 'Successfully logged in');
        return success($customer);
    }

    public function signOut() {
        if (Auth::guard('customer')->check()) {
            Auth::guard('customer')->logout();
            return redirect()->route('frontend.index');
        } else {
            Session::flash('warning', 'Please sign in to continue');
            return view('frontend.customer.sign_in');
        }
    }

    public function customerOrders() {
        if (Auth::guard('customer')->check()) {
            $orders = Auth::guard('customer')->user()->orders;
            $orders->load('items', 'order_combos', 'customer', 'restaurant', 'status');
            return view('frontend.orders.my_orders', compact('orders'));
        } else {
            Session::flash('warning', 'Please sign in to continue');
            return view('frontend.customer.sign_in');
        }

    }

    public function customerOrderDetails(Request $request, OrderService $orderService) {
        $order              = Order::with('restaurant', 'items', 'order_combos')->findOrFail($request->id);
        $order->date        = Carbon::parse($order->created_at)->format('g:i A') . ' ' . formatOrderDate($order->created_at);
        $order->grandTotal  = currency_format($order->amount);
        $order->deliveryFee = currency_format($order->delivery_fee);
        $order->vatAmount   = currency_format($order->vat_amount);
        $order->orderItems  = $orderService->orderItems($order);
        $order->subtotal    = $orderService->getOrderSubTotal($request->id);
        // $order->orderID    = $order->getOrderId($order->restaurant->name);
        $order->orderID = $order->id;
        return success($order);
    }

    public function customerProfile() {
        if (Auth::guard('customer')->check()) {
            $customer = Auth::guard('customer')->user();
            return view('frontend.customer.profile', compact('customer'));
        } else {
            Session::flash('warning', 'Please sign in to continue');
            return view('frontend.customer.sign_in');
        }
    }

    public function customerProfilePhotoUpdate(Request $request) {
        if (Auth::guard('customer')->check()) {
            $customer = Auth::guard('customer')->user();
            if ($request->photo) {
                deleteImage($customer->photo);
                $photo     = $request->photo;
                $path      = 'customer/profile/';
                $photo_url = storeImage($photo, $path, 100, 100);
                $customer->update([
                    'photo' => $photo_url,
                ]);
                $data['message'] = 'Profile photo has been updated';
                // $data['photo'] = $customer->address;
                return success($data);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Please upload a photo',
                ]);
            }
        } else {
            Session::flash('warning', 'Please sign in to continue');
            return view('frontend.customer.sign_in');
        }
    }

    public function customerDeliveryInfoUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'address' => 'required|max:1000',
            'contact' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            $data          = array();
            $data['error'] = $validator->errors()->all();
            return response()->json([
                'success' => false,
                'data'    => $data,
            ]);
        } else {
            $customer = Auth::guard('customer')->user();
            $customer->update([
                'address' => $request->address,
                'contact' => $request->contact,
            ]);
            $data['message'] = 'Delivery information has been saved';
            $data['address'] = $customer->address;
            $data['contact'] = $customer->contact;
            return success($data);
        }

    }

    public function customerAccountInfoUpdate(Request $request) {
        $customer  = Auth::guard('customer')->user();
        $validator = Validator::make($request->all(), [
            'name'  => 'required|max:100',
            'email' => 'required|max:100|email|unique:customers,email,' . $customer->customer_id . ',customer_id',

        ]);
        if ($validator->fails()) {
            $data          = array();
            $data['error'] = $validator->errors()->all();
            return response()->json([
                'success' => false,
                'data'    => $data,
            ]);
        } else {
            $customer->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);
            $data['message'] = 'Account information has been saved';
            $data['name']    = $customer->name;
            $data['email']   = $customer->email;
            return success($data);
        }

    }

}
