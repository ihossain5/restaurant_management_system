<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller {
    public function index(Request $request) {
        $customers = Customer::all();
        foreach ($customers as $customer) {
            $customer->image         = $customer->photo == null ? 'default.png' : $customer->photo;
            $customer->banned_status = $customer->is_banned == 0 ? 'checked' : '';
        }

        if ($request->ajax()) {
            return DataTables::of($customers)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $actionBtn = "<button type='button' class='btn btn-outline-dark' onclick='viewCustomer($data->customer_id)'>
                                    <i class='fa fa-eye'></i>
                                </button>
                                <a href='customers/{$data->customer_id}/orders' class='btn btn-outline-info'>
                                <svg width='18' height='16' viewBox='0 0 18 16' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                    <path d='M15.6667 8V13C15.6667 13.221 15.5789 13.433 15.4226 13.5893C15.2663 13.7455 15.0544 13.8333 14.8334 13.8333C14.6123 13.8333 14.4004 13.7455 14.2441 13.5893C14.0878 13.433 14 13.221 14 13V1.33333C14 1.11232 13.9122 0.900358 13.7559 0.744078C13.5997 0.587797 13.3877 0.5 13.1667 0.5H1.50002C1.27901 0.5 1.06704 0.587797 0.910765 0.744078C0.754484 0.900358 0.666687 1.11232 0.666687 1.33333V13C0.666687 14.3783 1.78835 15.5 3.16669 15.5H14.8334C16.2117 15.5 17.3334 14.3783 17.3334 13V8H15.6667ZM10.6667 7.16667V8.83333H4.00002V7.16667H10.6667ZM4.00002 5.5V3.83333H10.6667V5.5H4.00002ZM10.6667 10.5V12.1667H8.16669V10.5H10.6667Z' fill='#469FE8'/>
                                </svg></a>";

                    return $actionBtn;
                })
                ->addColumn('status', function ($data) {
                    $is_bannedBtn = "
                    <label class='switch'>
                    <input class='is_banned status{$data->customer_id}' type='checkbox' onclick='bannedCustomer($data->customer_id)'
                    {$data->banned_status}  data-id='{$data->customer_id}'>
                          <span class='slider round'></span>
                   </label>";

                    return $is_bannedBtn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.customer.all_customer');
    }
    public function show(Request $request) {
        $customer = Customer::findOrFail($request->id);
        return success($customer);
    }
    public function banCustomer(Request $request) {
        $customer = Customer::findOrFail($request->id);
        $data     = [];
        if ($customer->is_banned == 0) {
            $customer->update([
                'is_banned' => 1,
            ]);
            $data['message'] = 'Customer has been banned';
        } else {
            $customer->update([
                'is_banned' => 0,
            ]);
            $data['message'] = 'Customer has been unbanned';
        }
        $data['id'] = $customer->customer_id;
        return success($data);
    }
    public function customerOrders(Request $request, $id) {
        $customer = Customer::findOrFail($id);
        $restaurant_id = Session::get('restaurant_id');
        $restaurant    = Restaurant::findOrFail($restaurant_id);
        $restaurants   = Restaurant::get();
        $orders        = Order::where('customer_id', $id)->where('restaurant_id', $restaurant_id)->latest()->get();
        if ($request->ajax()) {
           return $this->ordersData($orders);
        }
        return view('admin.customer.customer_orders', compact('customer', 'restaurant', 'restaurants'));
    }

    public function customerOrderByRestaurant(Request $request){
        $restaurant = Restaurant::findOrFail($request->id);
        $orders        = Order::where('customer_id', $request->customer_id)->where('restaurant_id', $request->id)->latest()->get();
        Session::put('customer_orders', $orders);
        setSession($request->id);
        $data                    = [];
        $data['restaurant_name'] = $restaurant->name;
        $data['session_id']      = Session::get('restaurant_id');
        return success($data);
    }

    public function getOrders(){
        $orders = Session::get('customer_orders');
        return $this->ordersData($orders);
    }




    public function ordersData($orders){
        foreach ($orders as $order) {
            $order->date             = formatDate($order->created_at);
            $order->customer_name    = $order->is_default_name == 0 ? $order->name : $order->customer->name; 
            $order->customer_contact = $order->is_default_contact == 0 ? $order->contact : $order->customer->contact;
            $order->customer_address = $order->is_default_address == 0 ? $order->address :  $order->customer->address;
        }
        return DataTables::of($orders)
        ->addIndexColumn()
        ->addColumn('action', function ($data) {
            $actionBtn = "<button type='button' class='btn btn-outline-dark' onclick='viewOrder($data->order_id)'>
                            <i class='fa fa-eye'></i>
                        </button>";

            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

}
