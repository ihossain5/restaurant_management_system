<aside class="cart" id="cart">
    <h1 id="cartName">my cart</h1>
@foreach (Cart::content() as $cart)
<div class="cartItem d-flex justify-content-between cartRow{{$cart->rowId}}">
    <div>
        <p>{{$cart->name}}</p>
        <div class="incrDecBtn">
            <button onclick="minusBtn('{{$cart->id}}')"><img src="{{asset('frontend/assets/images/cart/minus-btn.svg')}}" alt="emerald minus icon"></button>
           
            <span class="cartQty{{$cart->id}}">{{$cart->qty}}</span>
            
            <button onclick="plusBtn('{{$cart->id}}')" data-id="">
                <img src="{{asset('frontend/assets/images/cart/plus-btn.svg')}}" alt="emerald plus icon">
            </button>
        </div>
    </div>
    <div class="cartRightSide">
        <button onclick="deleteCart('{{$cart->rowId}}')"><img src="{{asset('frontend/assets/images/cart/delete.svg')}}" alt="emerald deleteIcon"></button>
        <h6 class="">Tk. <span class="itemTotal{{$cart->id}}">{{$cart->subtotal}}</span></h6>
    </div>
</div>
@endforeach





    <div class="calculation d-flex justify-content-between">
        <div>
            <h6>Sub Total</h6>
        </div>
        <div>
            <h6>Tk. 1895</h6>
        </div>
    </div>
    <div class="calculation d-flex justify-content-between">
        <div>
            <h6>VAT</h6>
        </div>
        <div>
            <h6>Tk. 85</h6>
        </div>
    </div>
    <div class="calculation grand-total d-flex justify-content-between py-4">
        <div>
            <h6>Grand Total</h6>
        </div>
        <div>
            <h6>Tk. <span class="grandTotal">{{Cart::subtotal()}}</span></h6>
        </div>
    </div>


    <a href="checkout.html"><button class="brand-btn rounded-pill">Checkout</button></a>
    <p class="info-text">One of our representatives will personally call you to confirm your order upon checkout</p>
</aside>
<div class="trasnparentBg" id="trasnparentBg" onclick="closeCart()"></div>