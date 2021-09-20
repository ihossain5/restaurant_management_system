<select name="" class="form-control restaurant" id="restaurant_drop_down">
    @foreach ($restaurants as $data)
        <option value="{{ $data->restaurant_id }}"
            {{ $restaurant->restaurant_id == $data->restaurant_id ? 'selected' : '' }}>
            {{ $data->name }}
        </option>
    @endforeach
</select>