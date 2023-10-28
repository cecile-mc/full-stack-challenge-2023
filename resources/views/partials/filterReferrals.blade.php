@if($country_filter == true)
<h4>{{ head($countries) }} @if(count($cities) == 1) - {{ head($cities) }} @endif</h4>
<a class="btn btn-danger" href="{{ url('referrals/') }}">Remove filters</a>
@endif
@if(count($cities) > 1)
<label for="city">Cities</label>
<select id="city">
	<option value="">All</option>
	@foreach ($cities as $city)
	<option value="{{ $city }}">{{ $city  }}</p>
		@endforeach
</select>
<button class="btn btn-primary" id="filter">Filter</button>
@elseif(count($countries) > 1)
<label for="country">Countries</label>
<select id="country">
	<option value="">All</option>
	@foreach ($countries as $country)
	<option value="{{ $country }}">{{ $country  }}</p>
		@endforeach
</select>
<button class="btn btn-primary" id="filter">Filter</button>
@endif