<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderPerformanceController extends Controller {
    public function dailyReports($id) {
        $restaurant = Restaurant::with(['restaurant_orders' => function ($query) {
            $query->whereDate('orders.created_at', Carbon::today())->get();
        }])->find($id);
        $restaurants  = Restaurant::get();
        $current_date = formatDate(Carbon::today());
        return view('admin.performance-reports.daily_report', compact('restaurant', 'restaurants', 'current_date'));
    }
    public function dateWiseReportByRestaurant(Request $request) {
        // dd($request->all());
        $date       = Carbon::parse($request->date)->format('y-m-d');
        $restaurant = Restaurant::ordersbyDate($date, $request->id);
        setSession($request->id);
        if (!empty($restaurant->restaurant_orders)) {
            foreach ($restaurant->restaurant_orders as $order) {
                $order->date = formatDate($order->created_at);
            }
        }
        $data                    = [];
        $data['id']              = $request->id;
        $data['orders']          = $restaurant->restaurant_orders;
        $data['restaurant_name'] = $restaurant->name;
        $data['total_order']     = $restaurant->restaurant_orders ? $restaurant->restaurant_orders->count() : 0;
        $data['total_amount']    = $restaurant->restaurant_orders ? $restaurant->restaurant_orders->sum('amount') : 0;
        $data['current_date']    = formatDate($request->date);
        $data['session_id']      = Session::get('restaurant_id');
        return success($data);
    }

    //reports by time range start
    public function timeRangeReports(Request $request, $id) {
        // dd($request->all());
        // if($request->start_date != null && $request->end_date != null){
        $start_date = Carbon::parse($request->start_date)->format('y-m-d');
        $end_date   = Carbon::parse($request->end_date)->format('y-m-d');
        $restaurant = Restaurant::getOrdersByDateRange($start_date, $end_date, $id);
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
        setSession($request->id);
        if (!empty($restaurant->restaurant_orders)) {
            foreach ($restaurant->restaurant_orders as $order) {
                $order->date = formatDate($order->created_at);
            }
        }
        $data                    = [];
        $data['id']              = $request->id;
        $data['restaurant_name'] = $restaurant->name;
        $data['orders']          = $restaurant->restaurant_orders;
        $data['total_order']     = $restaurant->restaurant_orders ? $restaurant->restaurant_orders->count() : 0;
        $data['total_amount']    = $restaurant->restaurant_orders ? $restaurant->restaurant_orders->sum('amount') : 0;
        $data['start_date']      = formatDate($request->start_date);
        $data['end_date']        = formatDate($request->end_date);
        $data['session_id']      = Session::get('restaurant_id');
        return success($data);
    } // reports by time range end

//monthly reports start
    public function currentMonthReportsByRestaurant($id) {
        $month              = date('m');
        $year               = date('Y');
        $current_month_name = Carbon::now()->format('F');
        $restaurant         = Restaurant::getOrdersByMonth($month, $year, $id);
        $restaurants        = Restaurant::get();
        $total_order        = $restaurant->restaurant_orders ? $restaurant->restaurant_orders->count() : 0;
        $total_amount       = $restaurant->restaurant_orders ? $restaurant->restaurant_orders->sum('amount') : 0;
        return view('admin.performance-reports.monthly_report', compact('restaurant', 'restaurants', 'year', 'current_month_name', 'total_order', 'total_amount'));
    }

    public function monthlyOrdersReportByRestaurant(Request $request) {
        $date       = explode('-', $request->date);
        $month      = str_replace(' ', ' ', $date[0]);
        $year       = $date[1];
        $restaurant = Restaurant::getOrdersByMonth($month, $year, $request->id);
        setSession($request->id);
        $formated_date           = Carbon::createFromDate($year, $month, 1);
        $data                    = [];
        $data['id']              = $request->id;
        $data['restaurant_name'] = $restaurant->name;
        $data['orders']          = $restaurant->restaurant_orders;
        $data['total_order']     = $restaurant->restaurant_orders ? $restaurant->restaurant_orders->count() : 0;
        $data['total_amount']    = $restaurant->restaurant_orders ? $restaurant->restaurant_orders->sum('amount') : 0;
        $data['month']           = Carbon::parse($formated_date)->format('F');
        $data['year']            = Carbon::parse($formated_date)->format('y');
        $data['session_id']      = Session::get('restaurant_id');
        return success($data);
    }
    // monthly report end
    public function itemReportsByRestaurant($id){
        $restaurant = Restaurant::with('restaurant_categories','restaurant_orders','restaurant_orders.items','restaurant_orders.items.category')->findOrFail($id);
        $restaurants        = Restaurant::get();
        $total_order    = $restaurant->restaurant_orders ? $restaurant->restaurant_orders->count() : 0;
        $total_amount   = $restaurant->restaurant_orders ? $restaurant->restaurant_orders->sum('amount') : 0;
        return view('admin.performance-reports.item_performance_report',compact('restaurant','restaurants','total_order','total_amount'));
    }
    public function itemReportsByDate(Request $request){
        // dd($request->all());
        $start_date = Carbon::parse($request->start_date)->format('y-m-d');
        $end_date   = Carbon::parse($request->end_date)->format('y-m-d');
        $restaurant = Restaurant::getOrdersByDateRange($start_date, $end_date, $request->id);
        $data                    = [];
        $data['id']              = $request->id;
        $data['restaurant_name'] = $restaurant->name;
        $data['orders']          = $restaurant->restaurant_orders;
        $data['total_order']     = $restaurant->restaurant_orders ? $restaurant->restaurant_orders->count() : 0;
        $data['total_amount']    = $restaurant->restaurant_orders ? $restaurant->restaurant_orders->sum('amount') : 0;
        $data['start_date']      = formatDate($request->start_date);
        $data['end_date']        = formatDate($request->end_date);
        return success($data);
    }
}
