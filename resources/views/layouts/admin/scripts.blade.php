<!-- jQuery  -->
<script src="{{ asset('backend/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/modernizr.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('backend/assets/js/waves.js') }}"></script>
<script src="{{ asset('backend/assets/js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('backend/assets/js/jquery.scrollTo.min.js') }}"></script>

<!-- Required datatable js -->
<script src="{{ asset('backend/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Buttons examples -->
<script src="{{ asset('backend/assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables/buttons.colVis.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ asset('backend/assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

<!-- Datatable init js -->
<script src="{{ asset('backend/assets/pages/datatables.init.js') }}"></script>

<!--Morris Chart-->
{{-- <script src="{{ asset('backend/assets/plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/raphael/raphael-min.js') }}"></script> --}}

<script src="{{ asset('backend/assets/pages/dashboard.js') }}"></script>

<!-- App js -->
<script src="{{ asset('backend/assets/js/app.js') }}"></script>

<script src="{{ asset('backend/assets/js/autoNumeric.js') }}"></script>
<script src="{{ asset('backend/assets/js/bd_currency_format.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.15.5/sweetalert2.min.js"
integrity="sha512-+uGHdpCaEymD6EqvUR4H/PBuwqm3JTZmRh3gT0Lq52VGDAlywdXPBEiLiZUg6D1ViLonuNSUFdbL2tH9djAP8g=="
crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
crossorigin="anonymous"></script>

<script src="{{ asset('backend/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
</script>
<script src="{{ asset('backend/assets/js/restaurant_add_row.js') }}"></script>
<script src="{{ asset('backend/assets/js/style.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<script>

        var config = {
            routes: {
                updateStatus: "{!! route('manager.restaurant.status.update') !!}",
            }
        };
    $(document).ajaxStart(function() {
        $('.preloader').empty();
        $('.preloader').addClass('ajax_loader').append(
            `<div class='preloader'>
                <div id="status">
                    <div class="spinner"></div>
                </div>
            </div>`
        );
    });


    $(document).ajaxComplete(function() {
        $('.preloader').removeClass('ajax_loader').empty();
    });

    
    // for alert message
    var toastMixin = Swal.mixin({
        toast: true,
        title: 'General Title',
        animation: false,
        position: 'bottom-right',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });


    function setSessionId(session_id) {
        var item_url = '{{ route('item.index', ':id') }}';
        item_url = item_url.replace(':id', session_id);
        $('.item_link').attr("href", item_url);

        var item_combo_url = '{{ route('item.combo.index', ':id') }}';
        item_combo_url = item_combo_url.replace(':id', session_id);
        $('.item_combo_link').attr("href", item_combo_url);

        var category_url = '{{ route('item.category', ':id') }}';
        category_url = category_url.replace(':id', session_id);
        $('.category_link').attr("href", category_url);

        var order_url = '{{ route('orders.today', ':id') }}';
        order_url = order_url.replace(':id', session_id);
        $('.order_link').attr("href", order_url);

        var past_order_url = '{{ route('orders.past', ':id') }}';
        past_order_url = past_order_url.replace(':id', session_id);
        $('.past_order_link').attr("href", past_order_url);

        var restaurant_overview_url = '{{ route('restaurant.overview', ':id') }}';
        restaurant_overview_url = restaurant_overview_url.replace(':id', session_id);
        $('.restaurant_overview').attr("href", restaurant_overview_url);

        var daily_report_url = '{{ route('orders.daily.report', ':id') }}';
        daily_report_url = daily_report_url.replace(':id', session_id);
        $('.daily_report_route').attr("href", daily_report_url);

        var time_range_eport_url = '{{ route('orders.time.range.report', ':id') }}';
        time_range_eport_url = time_range_eport_url.replace(':id', session_id);
        $('.time_range_eport_route').attr("href", time_range_eport_url);

        var monthly_report_url = '{{ route('order.report.restaurant.current.month', ':id') }}';
        monthly_report_url = monthly_report_url.replace(':id', session_id);
        $('.monthly_report_route').attr("href", monthly_report_url);

        var item_performance_report_url = '{{ route('order.report.item', ':id') }}';
        item_performance_report_url = item_performance_report_url.replace(':id', session_id);
        $('.item_performance_report_route').attr("href", item_performance_report_url);
    }

    function setRestaurant(name, id) {
        $('.restaurantName').html(name);
        $('#restaurantId').val(id);
        $('.restaurant-dropdown-menu').find('.restaurant').removeClass('active');
        $('.restaurant-dropdown-menu').find('#restaurant_id' + id).addClass('active');
    }

    $('.dropify').dropify();

    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

    $('#datepicker').datepicker({
        autoclose: true,
        // format: "dd-mm-yyyy",
    });

  

    $(".yearDate").datepicker({
        // format: "yyyy",
        // viewMode: "years",
        // minViewMode: "years"

        format: " yyyy",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true,
        todayHighlight: true,

    });

    $("#monthYear").datepicker({
        format: "mm-yyyy",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true,
    });


    $('#monthYear input').val(`${date.getMonth() + 1}-${date.getFullYear()}`);
    $('#date-range').datepicker({
        toggleActive: true,
        autoclose: true,
    });

    // restaurant status change
    $(document).on('click', '.status_btn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '{{route('manager.restaurant.status.update')}}',
            method: "POST",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(response) {
                if (response.success == true) {
                   $('.btnOutlineOpen').html(response.data);
                   $('#restaurentStatusModal').modal('hide');
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
    });



// delivery location
$('.location-select-box').select2();
       
// Mulilevel Menu
$(".has_multi_sub").removeClass("active");
$(".has_multi_sub a").click(function () {
    $(this).siblings("ul").toggle().removeClass("d-none");
    if ($(this).parent("li").hasClass("sub-nav-active")) {
        $(this).parent("li").removeClass("active");
        $(this).parent("li").removeClass("sub-nav-active");
        $(this)
            .children("span")
            .children("span")
            .children(".mdi")
            .css("transform", "rotate(-90deg)");
    } else {
        $(this).parent("li").addClass("sub-nav-active");
        $(this)
            .children("span")
            .children("span")
            .children(".mdi")
            .css("transform", "rotate(0deg)");
    }
});



// $(document).load(function(){
//     $("#testId").trigger("click");
// });

window.onload = (event) => {
    $("body").trigger("click");
    // var context = new AudioContext();
};


var audio = new Audio("http://127.0.0.1:8000/backend/assets/notification.mp3");

// alert(audio);
// function playAudio() {
//     var x = new Audio("http://127.0.0.1:8000/backend/assets/notification.mp3");
//     // Show loading animation.
//     var playPromise = x.play();

//     if (playPromise !== undefined) {
//         playPromise
//             .then((_) => {
//                 x.play();
//             })
//             .catch((error) => {
//                 console.log(error);
//             });
//     }
// }


</script>
