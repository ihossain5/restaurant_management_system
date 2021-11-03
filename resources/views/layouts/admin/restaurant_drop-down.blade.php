<li class="list-inline-item dropdown notification-list">
    <a class="nav-link custom-drp dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
        aria-haspopup="false" aria-expanded="false">
        <input type="hidden" id="restaurantId" value="{{$restaurant->restaurant_id}}">
        <span class="restaurantName">{{ $restaurant->name }}</span> <img src="{{ asset('backend/assets/icons/arrow-down.svg') }}" alt="">
    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg restaurant-dropdown-menu">
        <!-- item-->
        @foreach ($restaurants as $data)
            <a href="javascript:void(0);" data-id="{{$data->restaurant_id}}" id="restaurant_id{{$data->restaurant_id}}"
                class="dropdown-item notify-item restaurant_list  restaurant {{ $restaurant->restaurant_id == $data->restaurant_id ? 'active' : '' }}">
                {{ $data->name }} </a>
        @endforeach
        <!-- All-->
        <a href="javascript:void(0);" class="dropdown-item notify-item text-right addRestaurent" data-toggle="modal" data-target="#RestaurantAdd">
            +add a new restaurant
        </a>
    </div>
</li>
