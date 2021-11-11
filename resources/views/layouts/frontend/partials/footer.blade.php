<footer class="footer">
    <div class="container-fluid foot-cont">
        <div class="row align-items-center">
            <div class="col-md-6 ">
                <div class="footer-logo">
                    <img src="{{asset('frontend/assets/images/Home/logo 2.svg')}}" alt="Emerald Restaurent logo">
                </div>
                {{-- <div class="foot-contact">
                    <p>{{$contactDetails->email}}</p>
                    <p>{{$contactDetails->contact}}</p>
                </div> --}}
            </div>
            <div class="col-md-6 align-self-end">
                <ul class="infoLink">
                    <li><a href="{{route('frontend.about.us')}}">About Us</a></li>
                    <li><a href="{{route('frontend.contact.us')}}">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </div>
    </div>
</footer>