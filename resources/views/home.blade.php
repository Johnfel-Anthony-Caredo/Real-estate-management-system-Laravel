@extends('layouts.app')

@section('content')
<div class="container">
<div class="site-section site-section-sm pb-0">
      <div class="container">
        <div class="row">
          <form action="{{ route('search.properties') }}" method="GET" class="form-search col-md-12" style="margin-top: -120px; border-radius: 10px 10px">
            <div class="row align-items-end">
              <div class="col-md-5">
                <label for="home_type" style="color: white;">Home Type</label>
                <div class="select-wrap">
                  <span class="icon icon-arrow_drop_down"></span>
                  <select name="home_type" id="home_type" class="form-control d-block rounded-0">
                    <option value="">All Types</option>
                    @foreach($homeTypes as $type)
                      <option value="{{ $type->hometypes }}">{{ $type->hometypes }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-5">
                <label for="location" style="color: white;">Location</label>
                <input type="text" name="location" id="location" class="form-control d-block rounded-0" placeholder="Enter city, area or address">
              </div>
              <div class="col-md-2">
                <input type="submit" class="btn btn-success text-white btn-block rounded-0" value="Search">
              </div>
            </div>
          </form>
        </div>  

        <div class="row">
          <div class="col-md-12">
            <div class="view-options bg-white py-3 px-3 d-md-flex align-items-center">
              <div class="mr-auto">
                <a href="#" class="icon-view view-module active"><span class="icon-view_module"></span></a>
              </div>
              <div class="ml-auto d-flex align-items-center">
              </div>
            </div>
          </div>
        </div>
       
      </div>
    </div>
</div>

<div class="site-section site-section-sm bg-light">
      <div class="container">
        <div class="row mb-5">
        @if(count($props) > 0)
          @foreach ($props as $prop)
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="property-entry h-100">
                <a href="{{ route('single.prop', $prop->id) }}" class="property-thumbnail">
                  <div class="offer-type-wrap">
                    <span class="offer-type bg-danger">For Sale</span>
                  </div>
                  <img src="{{ asset('assets1/images/'.$prop->image .'') }}" alt="Image" class="img-fluid">
                </a>
                <div class="p-4 property-body">
                  
                  <h2 class="property-title"><a href="{{ route('single.prop', $prop->id) }}">{{$prop->title}}</a></h2>
                  <span class="property-location d-block mb-3"><span class="property-icon icon-room"></span> {{$prop->location}}</span>
                  <strong class="property-price text-primary mb-3 d-block text-success">PHP {{ number_format((float) $prop->price) }}</strong>
                  <ul class="property-specs-wrap mb-3 mb-lg-0">
                    <li>
                      <span class="property-specs">Beds</span>
                      <span class="property-specs-number">{{$prop->beds}} <sup>+</sup></span>
                      
                    </li>
                    <li>
                      <span class="property-specs">Baths</span>
                      <span class="property-specs-number">{{$prop->baths}}</span>
                      
                    </li>
                    <li>
                      <span class="property-specs">SQ FT</span>
                      <span class="property-specs-number">{{$prop->sq_ft}}</span>
                      
                    </li>
                  </ul>

                </div>
              </div>
            </div>
          @endforeach
        @else
          <div class="col-12 text-center py-5">
            <h3 class="mb-4">No Properties Available</h3>
            <p>Try adjusting your search criteria to find more properties.</p>
          </div>
        @endif
        </div>
        @if(method_exists($props, 'links'))
          <div class="row">
            <div class="col-12 d-flex justify-content-center">
              {{ $props->links() }}
            </div>
          </div>
        @endif
      </div>
    </div>
@endsection
