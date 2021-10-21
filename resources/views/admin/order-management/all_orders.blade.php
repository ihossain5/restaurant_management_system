@extends('layouts.admin.master')
@section('page-header')
    Past Orders
@endsection
@section('restaurant_list')
{{-- @include('layouts.admin.restaurant_drop-down') --}}
@endsection
@section('pageCss')

    <style>
        .txt-preparing {
            color: rgb(38, 38, 160);
            font-weight: 600;
        }

        .txt-cancelled {
            color: rgb(255, 0, 0);
            font-weight: 600;
        }

        .txt-delivering {
            color: rgb(189, 179, 45);
            font-weight: 600;
        }

        .txt-completed {
            color: rgb(6, 78, 4);
            font-weight: 600;
        }

        .view-modal p {
            line-height: 2;
        }

    </style>
@endsection
@section('content')
    <div class="preloader">

    </div>
   
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-4">
                                <div class="ms-header-text">
                                    <h4 class="mt-0 header-title">All Past Orders</h4>
                                </div>
                                <h1 id="message"></h1>
                            </div>
                            <p id="new_call"></p>
                            <span class="showError"></span>
                            <div class="table-responsive">
                                <table id="orderTable" class="table table-bordered dt-responsive nowrap data-table"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->




        </div><!-- container -->

    </div> <!-- Page content Wrapper -->



    @include('layouts.admin.restaurant_add_modal')
@endsection
@section('pageScripts')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script type='text/javascript'>
     CKEDITOR.replace('restaurant_description');
    $(function () {
    // var table = $('.data-table').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     ajax: "{{ route('order.test') }}",
    //     columns: [
    //         {data: 'DT_RowIndex'},
    //         {data: 'name'},
    //         {data: 'email'},
    //         {
    //             data: 'action', 
    //             name: 'action', 
    //             orderable: true, 
    //             searchable: true
    //         },
    //     ]
    // });
    
  });
     // Enable pusher logging - don't include this in production
     Pusher.logToConsole = true;
    var pusher = new Pusher('1efc814744bed7686f5e', {
      cluster: 'ap2'
    });

    var channel = pusher.subscribe('my-channel');
    
    channel.bind('my-event', function(data) {
        toastMixin.fire({
            icon: 'success',
            animation: true,
            title: data.message,
         });

        alert(data.message);
    });
  
    </script>
@endsection
