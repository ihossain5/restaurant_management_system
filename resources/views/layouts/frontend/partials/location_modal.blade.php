    <!-- onload location modal -->
    <div class="location-modal-box">
        <div class="modal show" tabindex="-1" id="location-modal" data-bs-backdrop="static" data-bs-keyboard="false"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    @if (session()->has('location_id'))
                        <button data-bs-dismiss="modal" class="lmbCloseBtn"><img
                                src="{{ asset('frontend/assets/images/My Orders/modal-close.svg') }}" alt=""></button>
                    @else
                        <button data-bs-dismiss="modal" class="lmbCloseBtn"><img
                                src="{{ asset('frontend/assets/images/My Orders/modal-close.svg') }}" alt="">
                        </button>
                    @endif

                    <div class="modal-body">
                        <div class="image-wrapper">
                            <img src="{{ asset('frontend/assets/images/Logos/Emerald Group.svg') }}" alt="logo">
                        </div>
                        <h1>choose your location</h1>
                        <div class="row align-items-center">
                            <div class="col-9">
                                <div class="select-box">
                                    <select class="w-100 deliveryLocation"  aria-label="Default select example" id="select_id">
                                        <option value="">Select Location</option>
                                        @if (!empty($locations))
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->delivery_location_id }}"
                                                    {{ $location->delivery_location_id == session()->get('location_id') ? 'selected' : '' }}>
                                                    {{ $location->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                @if (count(Cart::content())>0)
                                <button type="button" class="location-submitBtn" onclick="locationChange()">Submit</button>
                                @else
                                <button type="button" class="location-submitBtn" onclick="changeLocation()" >Submit</button>
                                @endif
                            </div>
                        </div>

                        {{-- <div class="select-box">
                            <select class="" id="select_id" aria-label="Default select example"
                                onchange="getRestaurants()">
                                <option value="">Select Location</option>
                                @if (!empty($locations))
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->delivery_location_id }}"
                                            {{ $location->delivery_location_id == session()->get('location_id') ? 'selected' : '' }}>
                                            {{ $location->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
