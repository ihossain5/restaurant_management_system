@extends('layouts.admin.master')
@section('page-header')
    Item Combos
@endsection

@section('pageCss')
    <style>
        .view-modal-footer {
            display: initial !important;
        }

        .view-modal p {
            line-height: 2;
        }

        .modal-footer>:not(:first-child) {
            margin-left: 0;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #dc3545;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #198754;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #018346;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

    </style>
@endsection
@section('content')
<div class="preloader"></div>
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row pb-5">
                                <div class="col-lg-4">
                                    <h4 class="mt-0 header-title">All Items</h4>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="itemTable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Combo Name</th>
                                            <th>Item(s) Name</th>
                                            <th>Unit Price</th>
                                            <th>Available</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($allCombos))
                                            @foreach ($allCombos as $combo)
                                                <tr class="item{{ $combo->combo_id }}">
                                                    <td>{{ $combo->name ?? 'N/A' }}</td>
                                                    <td>
                                                        @foreach ($combo->items as $item)
                                                        {{ $item->name }},
                                                         @endforeach
                                                    </td>
                                                    <td><span class="bdt_symbol">৳</span> {{ $combo->price }}</td>
                                                  <td>
                                                        <label class="switch">
                                                            <input class="is_available status{{ $combo->combo_id }}"
                                                                type="checkbox"
                                                                {{ $combo->is_available == 1 ? 'checked' : '' }}
                                                                data-id="{{ $combo->combo_id }}">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <button type='button' class='btn btn-outline-dark'
                                                            onclick='viewCombo({{ $combo->combo_id }})'><i class='fa fa-eye'></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div><!-- container -->
    </div> <!-- Page content Wrapper -->
    <!-- view  Modal -->
    <div class="modal fade bs-example-modal-center" id="viewModal" tabindex="-1" role="dialog"
        aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-block">
                    <h5 class="modal-title mt-0 text-center">Combo Details</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-12 col-md-12">
                        <div class="ms-form-group">
                            <p>
                                <strong>Combo Name:</strong> <span id="view_name"></span>
                            </p>
                            <p>
                                <strong>Item(s) Name:</strong> <span id="view_item_name"></span>
                            </p>
                            <p>
                                <strong>Unit Price:</strong> <span id="view_price"></span>
                            </p>
                            <img class="mt-2" src="" id="view_image" style="width: 100%;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer view-modal-footer">
                    <button type="submit" data-dismiss="modal" class="btn btn-block btn-success waves-effect waves-light">
                        Done
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- view  Modal End -->
@endsection
@section('pageScripts')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="{{asset('backend/assets/js/pusher_notification.js')}}"></script>
    <script type='text/javascript'>
        var config = {
            routes: {
                view: "{!! route('item.combo.edit') !!}",
                updateAvailableStatus: "{!! route('item.combo.available.status.update') !!}",
            }
        };

        $(document).ready(function() {
            $('#itemTable').DataTable({
                "ordering": false,
            });

        });

        var imagesUrl = '{!! URL::asset('/images/') !!}/';

        // view single 
        function viewCombo(id) {
            $.ajax({
                url: config.routes.view,
                method: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        $('#view_name').text(response.data.name);
                        $('#view_item_name').empty();
                        $.each(response.data.items, function(i, val) {
                            $('#view_item_name').append(
                                `<span id="view_item_name">${val.name}, </span>`
                            )
                        });

                        $('#view_price').text(response.data.price);
                        if (response.data.photo != null) {
                            $('#view_image').attr('src', imagesUrl + response.data.photo);
                        }


                        $('#viewModal').modal('show');

                    } //success end

                },
                error: function(error) {
                    if (error.status == 404) {
                        toastMixin.fire({
                            icon: 'error',
                            animation: true,
                            title: "" + 'Data not found' + ""
                        });


                    }
                },
            }); //ajax end
        }


        // available status change function
        $(document.body).on('click', '.is_available', function() {
            var id = $(this).attr('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Change this status!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: config.routes.updateAvailableStatus,
                        method: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.success == true) {
                                toastMixin.fire({
                                    icon: 'success',
                                    animation: true,
                                    title: "" + response.data.message + ""
                                });
                            }
                        }, //success end
                        error: function(error) {
                            if (error.status == 404) {
                                toastMixin.fire({
                                    icon: 'error',
                                    animation: true,
                                    title: "" + 'Data not found' + ""
                                });


                            }
                        },

                    }); //ajax end
                } else {
                    if ($('.status' + id + "").prop("checked") == true) {
                        $('.status' + id + "").prop('checked', false);
                    } else {
                        $('.status' + id + "").prop('checked', true);
                    }
                }
            })
        });


    </script>
@endsection
