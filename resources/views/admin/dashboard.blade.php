@extends('layouts.admin.master')
@section('page-header')
 {{Auth::user()->is_super_admin == 1 ?  'Business Overview' : 'Dashboard'}}
@endsection
@section('pageCss')
    <style>

    </style>
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <h1 class="section-title">Restaurants at a Glance</h1>
            </div>
            <div class="col-6 text-right">
                <h1 class="section-title">{{currency_format($total_amount)}}</h1>
            </div>
        </div>

        <!-- Dashboard Card -->
        <div class="row pt-5">
            @if (!empty($restaurants))
                @foreach ($restaurants as $restaurant)
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card m-b-30 card-body dashboardCard">
                        <div class="card-content">
                            <h4>{{$restaurant->name}}</h4>
                            <h6>{{$restaurant->address}}</h6>
                            <h2>{{currency_format($restaurant->revenue)}}</h2>
                            <div class="row">
                                <div class="col-6">
                                    <p><img src="{{asset('backend/assets/icons/tick.svg')}}" alt="">{{$restaurant->completed_orders}}</p>
                                </div>
                                <div class="col-6 text-right">
                                    <p><img src="{{asset('backend/assets/icons/cross.svg')}}" alt="">{{$restaurant->cancelled_orders}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
           

        </div>


        <!-- Performance Table -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card m-b-30 card-body tableCard">
                    <h4>Best Performing Restaurants</h4>

                    <div class="table-responsive scrollTable b-0 pt-4 pl-4 pr-5">

                        <table class="table performTable">

                            <tbody>
                                <tr>
                                    <th class="srNo text-left" scope="row">1</th>
                                    <td class="shopInfo">
                                        <h5>Kiyoshi</h5>
                                        <h6>Gulshan 1</h6>
                                    </td>
                                    <td class="sellPrice">30,005</td>
                                    <td class="sellQty">1020</td>
                                </tr>
                                <tr>
                                    <th class="srNo text-left" scope="row">2</th>
                                    <td class="shopInfo">
                                        <h5>Gusto</h5>
                                        <h6>Gulshan 1</h6>
                                    </td>
                                    <td class="sellPrice">30,005</td>
                                    <td class="sellQty">1020</td>
                                </tr>
                                <tr>
                                    <th class="srNo text-left" scope="row">3</th>
                                    <td class="shopInfo">
                                        <h5>Thai Emerald</h5>
                                        <h6>Gulshan 1</h6>
                                    </td>
                                    <td class="sellPrice">30,005</td>
                                    <td class="sellQty">1020</td>
                                </tr>
                                <tr>
                                    <th class="srNo text-left" scope="row">4</th>
                                    <td class="shopInfo">
                                        <h5>Thai Emerald</h5>
                                        <h6>Gulshan 1</h6>
                                    </td>
                                    <td class="sellPrice">30,005</td>
                                    <td class="sellQty">1020</td>
                                </tr>
                                <tr>
                                    <th class="srNo text-left" scope="row">5</th>
                                    <td class="shopInfo">
                                        <h5>Thai Emerald</h5>
                                        <h6>Gulshan 1</h6>
                                    </td>
                                    <td class="sellPrice">30,005</td>
                                    <td class="sellQty">1020</td>
                                </tr>
                                <tr>
                                    <th class="srNo text-left" scope="row">6</th>
                                    <td class="shopInfo">
                                        <h5>Thai Emerald</h5>
                                        <h6>Gulshan 1</h6>
                                    </td>
                                    <td class="sellPrice">30,005</td>
                                    <td class="sellQty">1020</td>
                                </tr>

                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
            <div class="col-lg-6">
                <div class="card m-b-30 card-body tableCard">
                    <h4>Best Performing Items</h4>

                    <div class="table-responsive b-0 pt-4 pl-4 pr-5">

                        <table class="table performTable">

                            <tbody>
                                <tr>
                                    <th class="srNo text-left" scope="row">1</th>
                                    <td class="shopInfo">
                                        <h5>Item Name</h5>
                                        <h6>Restaurant Name</h6>
                                    </td>
                                    <td class="shopInfo text-right">
                                        <h5>100</h5>
                                        <h6>1020</h6>
                                    </td>

                                </tr>
                                <tr>
                                    <th class="srNo text-left" scope="row">2</th>
                                    <td class="shopInfo">
                                        <h5>Item Name</h5>
                                        <h6>Restaurant Name</h6>
                                    </td>
                                    <td class="shopInfo text-right">
                                        <h5>100</h5>
                                        <h6>1020</h6>
                                    </td>

                                </tr>
                                <tr>
                                    <th class="srNo text-left" scope="row">3</th>
                                    <td class="shopInfo">
                                        <h5>Item Name</h5>
                                        <h6>Restaurant Name</h6>
                                    </td>
                                    <td class="shopInfo text-right">
                                        <h5>100</h5>
                                        <h6>1020</h6>
                                    </td>

                                </tr>
                                <tr>
                                    <th class="srNo text-left" scope="row">4</th>
                                    <td class="shopInfo">
                                        <h5>Item Name</h5>
                                        <h6>Restaurant Name</h6>
                                    </td>
                                    <td class="shopInfo text-right">
                                        <h5>100</h5>
                                        <h6>1020</h6>
                                    </td>

                                </tr>
                                <tr>
                                    <th class="srNo text-left" scope="row">5</th>
                                    <td class="shopInfo">
                                        <h5>Item Name</h5>
                                        <h6>Restaurant Name</h6>
                                    </td>
                                    <td class="shopInfo text-right">
                                        <h5>100</h5>
                                        <h6>1020</h6>
                                    </td>

                                </tr>

                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>

    </div><!-- container -->

</div> <!-- Page content Wrapper -->

@endsection
