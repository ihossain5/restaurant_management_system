<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderPerformanceController extends Controller {
    public function dailyReports($id) {
        $restaurant = Restaurant::with(['restaurant_items.orders' => function ($query) {
            $query->whereDate('orders.created_at', DB::raw('CURDATE()'))->get();
        }])->find($id);
        $all_orders   = ordersByRestaurant($restaurant);
        $restaurants  = Restaurant::get();
        $current_date = formatDate(Carbon::today());
        return view('admin.performance-reports.daily_report', compact('restaurant', 'restaurants', 'current_date'));
    }

    public function dailyReportByRestaurant(Request $request) {
        $restaurant = Restaurant::with(['restaurant_items.orders' => function ($query) {
            $query->whereDate('orders.created_at', DB::raw('CURDATE()'))->get();
        }])->find($request->id);
        $all_orders = ordersByRestaurant($restaurant);
        setSession($request->id);

        if (!empty($restaurant->all_orders)) {
            foreach ($restaurant->all_orders as $order) {
                $order->date = formatDate($order->created_at);
            }
        }
        $data                 = [];
        $data['id']           = $request->id;
        $data['orders']       = $all_orders;
        $data['current_date'] = formatDate(Carbon::today());
        $data['session_id']   = Session::get('restaurant_id');
        return success($data);
    }
    public function dateWiseReportByRestaurant(Request $request) {
        $date       = Carbon::parse($request->date)->format('y-m-d');
        $restaurant = Restaurant::ordersbyDate($date, $request->id);
        $all_orders = ordersByRestaurant($restaurant);
        setSession($request->id);
        if (!empty($restaurant->all_orders)) {
            foreach ($restaurant->all_orders as $order) {
                $order->date = formatDate($order->created_at);
            }
        }
        $data                 = [];
        $data['id']           = $request->id;
        $data['orders']       = $all_orders;
        $data['current_date'] = formatDate($request->date);
        $data['session_id']   = Session::get('restaurant_id');
        return success($data);
    }

    public function timeRangeReports(Request $request, $id) {
        // dd($request->all());
        // if($request->start_date != null && $request->end_date != null){
        $start_date = Carbon::parse($request->start_date)->format('y-m-d');
        $end_date   = Carbon::parse($request->end_date)->format('y-m-d');
        $restaurant = Restaurant::getOrdersByDateRange($start_date, $end_date, $id);
        $all_orders = ordersByRestaurant($restaurant);
        // }else{
        //     $restaurant = Restaurant::find($id);
        // }
        $restaurants = Restaurant::get();

        return view('admin.performance-reports.time_range_report', compact('restaurant', 'restaurants'));

        // dd($restaurant);
    }
    public function timeRangeReportsByRestaurant(Request $request) {
        // if($request->start_date != null && $request->end_date != null){
        $start_date = Carbon::parse($request->start_date)->format('y-m-d');
        $end_date   = Carbon::parse($request->end_date)->format('y-m-d');
        $restaurant = Restaurant::getOrdersByDateRange($start_date, $end_date, $request->id);
        $all_orders = ordersByRestaurant($restaurant);
        setSession($request->id);
        if (!empty($restaurant->all_orders)) {
            foreach ($restaurant->all_orders as $order) {
                $order->date = formatDate($order->created_at);
            }
        }
        $data                 = [];
        $data['id']           = $request->id;
        $data['orders']       = $all_orders;
        $data['total_order']  = $restaurant->all_orders ? $restaurant->all_orders ->count() : 0;
        $data['total_amount'] = $restaurant->all_orders ? $restaurant->all_orders->sum('amount') : 0;
        $data['start_date']   = formatDate($request->start_date);
        $data['end_date']     = formatDate($request->end_date);
        $data['session_id']   = Session::get('restaurant_id');
        return success($data);
        // }
    }
}
