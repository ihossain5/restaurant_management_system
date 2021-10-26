<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerSignInRequest;
use App\Http\Requests\CustomerSignUpRequest;
use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller {
    public function customerSignIn() {
        return view('frontend.customer.sign_in');
    }
    public function signIn(CustomerSignInRequest $request) {
        // dd($request->all());
        $credentials = $request->only('email', 'password');
        if (Auth::guard('customer')->attempt($credentials)) {
            Session::flash('message','Successfully logged in');
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
        $customer = Customer::create($request->validated());
        $data     = Auth::guard('customer')->login($customer);
        Session::flash('message', 'Successfully logged in');
        return success($customer);
    }

    public function signOut(){
        Auth::guard('customer')->logout();
        return redirect()->back();
    }

    public function customerOrders(){
        $orders = Auth::guard('customer')->user()->orders;
        $orders->load('items','order_combos','customer','restaurant','status');
        return view('frontend.orders.my_orders',compact('orders'));
    }

    public function customerOrderDetails(Request $request){
        $order = Order::with('restaurant','items','order_combos')->findOrFail($request->id);
        $orderItems = [];
        foreach($order->order_combos as $combo){
            $orderItems[] = $combo;
        
        }
        foreach($order->items as $item){
            $orderItems[] = $item;
        
        }
        $order->date = Carbon::parse($order->created_at)->format('g:i A') . ' '. formatOrderDate($order->created_at);
        $order->grandTotal = formatAmount($order->amount) + formatAmount($order->delivery_fee);
        $order->orderItems = $orderItems;
        $order->orderID = $order->getOrderId($order->restaurant->name);
        return success($order);
    }
}
