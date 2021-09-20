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
{{-- <script src="{{ asset('backend/assets/plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables/buttons.colVis.min.js') }}"></script> --}}
<!-- Responsive examples -->
{{-- <script src="{{ asset('backend/assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script> --}}

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
<script>
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
        position: 'top-right',
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
    }
</script>
