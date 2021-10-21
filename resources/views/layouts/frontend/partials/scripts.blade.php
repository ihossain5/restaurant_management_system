    <!-- Jquery CDNJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Bootstrap Js -->
    <script src="{{ asset('frontend/assets/bootstrap-5.1.0/bootstrap.min.js') }}"></script>


    <!-- Owl-Carousel -->
    <script src="{{ asset('frontend/assets/OwlCarousel2-2.3.4/owl.carousel.min.js') }}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('frontend/assets/js/style.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



    <script>
        var config = {
            routes: {
                addToCart: "{!! route('frontend.cart.add') !!}",
                updateCart: "{!! route('frontend.cart.update') !!}",
                decreaseCartQty: "{!! route('frontend.cart.decrease.quantity') !!}",
                deleteCart: "{!! route('frontend.cart.delete') !!}",
            }
        };
        // Deales Carousel
        $(document).ready(function() {
            $(".deals-carousel").owlCarousel({
                responsiveClass: true,
                margin: 15,
                nav: true,
                dotsContainer: '.dots-div',
                responsive: {
                    0: {
                        items: 2,
                        nav: false,
                        center: true,
                        loop: true,
                        autoWidth: true
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 4
                    }
                }
            });

            $(".popular-carousel").owlCarousel({
                responsiveClass: true,
                margin: 15,
                nav: true,
                dotsContainer: '.dots-div2',
                responsive: {
                    0: {
                        items: 2,
                        nav: false,
                        center: true,
                        loop: true,
                        autoWidth: true
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 4
                    }
                }
            });
            if ($('.dealsDot button').length > 1) {
                $('.dealsDot').removeClass('d-none');
            }
            if ($('.popularDot button').length > 1) {
                $('.popularDot').removeClass('d-none');
            }


        });

        //toaster
        toastr.options = {
            "closeButton": true,
            "debug": true,
            "tapToDismiss ": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
                // add to cart
    function addToCart(item_id, restaurant_id) {
            $.ajax({
                url: config.routes.addToCart,
                method: "POST",
                data: {
                    item_id: item_id,
                    restaurant_id: restaurant_id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        toastr["success"](response.data.message)
                        $('.cartItem').remove();
                        $('.grandTotal').html(response.data.grandTotal)
                       $.each(response.data.items,function(key,val){
                           console.log(val.name);
                           $('#cartName').after(
                               `<div class="cartItem d-flex justify-content-between cartRow${val.rowId}">
                                    <div>
                                        <p>${val.name}</p>
                                        <div class="incrDecBtn">
                                            <button onclick="minusBtn('${val.id}')"><img src="{{asset('frontend/assets/images/cart/minus-btn.svg')}}" alt="emerald minus icon"></button>
                                        
                                            <span class="cartQty${val.id}">${val.qty}</span>
                                            
                                            <button onclick="plusBtn('${val.id}')" data-id="">
                                                <img src="{{asset('frontend/assets/images/cart/plus-btn.svg')}}" alt="emerald plus icon">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="cartRightSide">
                                        <button onclick="deleteCart('${val.rowId}')"><img src="{{asset('frontend/assets/images/cart/delete.svg')}}" alt="emerald deleteIcon"></button>
                                        <h6 class="">Tk. <span class="itemTotal${val.id}">${val.subtotal}</span></h6>
                                    </div>
                                </div>`
                           )
                       })
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

     // increase cart quantity   
     function plusBtn(item_id){
         var oldQty =  $('.cartQty'+item_id).html();
         $('.cartQty'+item_id).html(++oldQty);
         var oldprice =  parseFloat($('.itemTotal'+item_id).html());
        // alert(oldprice);
         $.ajax({
                url: config.routes.updateCart,
                method: "POST",
                data: {
                    item_id: item_id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        // toastr["success"](response.data.message)
                       $('.grandTotal').html(response.data.grandTotal)
                       $('.itemTotal'+item_id).html(response.data.price + oldprice)
                    
                   
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
     
      // decrease cart quantity   
     function minusBtn(item_id){
         var oldQty =  $('.cartQty'+item_id).html();
         var oldprice =  parseFloat($('.itemTotal'+item_id).html());
         if(oldQty == 1){
            toastr["info"]('Quantity can not be less than 1')
         }else{
            // $('.cartQty'+item_id).html(--oldQty);
            $.ajax({
                url: config.routes.decreaseCartQty,
                method: "POST",
                data: {
                    item_id: item_id,
                    quantity: --oldQty,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        // toastr["success"](response.data.message)
                       $('.grandTotal').html(response.data.grandTotal)
                    //    $('.itemTotal'+item_id).html(response.data.price + oldprice)
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
         
     }  

    function deleteCart(rowId){
        $.ajax({
                url: config.routes.deleteCart,
                method: "POST",
                data: {
                    rowId: rowId,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        // toastr["success"](response.data.message)
                       $('.grandTotal').html(response.data.grandTotal)
                       $('.cartRow'+rowId).remove();
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
    </script>
