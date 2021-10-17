<aside class="cart" id="cart">
    <h1>my cart</h1>

    <div class="cartItem d-flex justify-content-between">
        <div>
            <p>Cream of Mushroom</p>
            <div class="incrDecBtn">
                <button><img src="{{asset('frontend/assets/images/cart/minus-btn.svg')}}" alt="emerald minus icon"></button>
                <span>1</span>
                <button><img src="{{asset('frontend/assets/images/cart/plus-btn.svg')}}" alt="emerald plus icon"></button>
            </div>
        </div>
        <div class="cartRightSide">
            <button><img src="{{asset('frontend/assets/images/cart/delete.svg')}}" alt="emerald deleteIcon"></button>
            <h6>Tk. 1200</h6>
        </div>
    </div>
    <div class="cartItem d-flex justify-content-between">
        <div>
            <p>Seafood Soup with Coconut Milk</p>
            <div class="incrDecBtn">
                <button><img src="{{asset('frontend/assets/images/cart/minus-btn.svg')}}" alt="emerald minus icon"></button>
                <span>1</span>
                <button><img src="{{asset('frontend/assets/images/cart/plus-btn.svg')}}" alt="emerald plus icon"></button>
            </div>
        </div>
        <div class="cartRightSide">
            <button><img src="{{asset('frontend/assets/images/cart/delete.svg')}}" alt="emerald deleteIcon"></button>
            <h6>Tk. 695</h6>
        </div>
    </div>


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
            <h6>Tk. 2070</h6>
        </div>
    </div>


    <a href="checkout.html"><button class="brand-btn rounded-pill">Checkout</button></a>
    <p class="info-text">One of our representatives will personally call you to confirm your order upon checkout</p>
</aside>
<div class="trasnparentBg" id="trasnparentBg" onclick="closeCart()"></div>