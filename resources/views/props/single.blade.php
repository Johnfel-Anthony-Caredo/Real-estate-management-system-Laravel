@extends('layouts.app1')

@section('content')

<div class="site-blocks-cover inner-page-cover overlay" style="background-image: url({{ asset('assets1/images/'.$singleProp->image.'')}});" data-aos="fade">
    <div class="container">
      <div class="row align-items-center justify-content-center text-center">
        <div class="col-md-10">
          <span class="d-inline-block text-white px-3 mb-3 property-offer-type rounded">Property Details of</span>
          <h1 class="mb-2">{{ $singleProp->title }}</h1>
          <p class="mb-5"><strong class="h2 font-weight-bold">PHP {{ number_format((float) $singleProp->price) }}</strong></p>
        </div>
      </div>
    </div>
  </div>
  <div class="container">



  <div class="container">



  <div class="site-section site-section-sm">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div>
            <div class="slide-one-item home-slider owl-carousel">
                @foreach ($propImages as $propImage)
                 <div><img src="{{ asset('assets1/images/'.$propImage->image.'') }}" alt="Image" class="img-fluid"></div>

                @endforeach
             
            </div>
          </div>
          <div class="bg-white property-body border-bottom border-left border-right">
            <div class="row mb-5">
              <div class="col-md-6">
                <strong class="text-success h1 mb-3">PHP {{ number_format((float) $singleProp->price) }}</strong>
              </div>
              <div class="col-md-6">
                <ul class="property-specs-wrap mb-3 mb-lg-0  float-lg-right">
                <li>
                  <span class="property-specs">Beds</span>
                  <span class="property-specs-number">{{ $singleProp->beds }} <sup>+</sup></span>
                  
                </li>
                <li>
                  <span class="property-specs">Baths</span>
                  <span class="property-specs-number">{{ $singleProp->baths }}</span>
                  
                </li>
                <li>
                  <span class="property-specs">SQ FT</span>
                  <span class="property-specs-number">{{ $singleProp->sq_ft }}</span>
                  
                </li>
              </ul>
              </div>
            </div>
            <div class="row mb-5">
              <div class="col-md-6 col-lg-4 text-center border-bottom border-top py-3">
                <span class="d-inline-block text-black mb-0 caption-text">Home Type</span>
                <strong class="d-block">{{ $singleProp->home_type }}</strong>
              </div>
              <div class="col-md-6 col-lg-4 text-center border-bottom border-top py-3">
                <span class="d-inline-block text-black mb-0 caption-text">Year Built</span>
                <strong class="d-block">{{ $singleProp->year_built }}</strong>
              </div>
              <div class="col-md-6 col-lg-4 text-center border-bottom border-top py-3">
                <span class="d-inline-block text-black mb-0 caption-text">Price/Sqft</span>
                <strong class="d-block">PHP {{ number_format((float) $singleProp->price_sqft) }}</strong>
              </div>
            </div>
            <h2 class="h4 text-black">More Info</h2>
            <p>
                {{ $singleProp->more_info	 }}
            </p>
            
            <div class="row no-gutters mt-5">
              <div class="col-12">
                <h2 class="h4 text-black mb-3">Gallery</h2>
              </div>
              @foreach ($propImages as $propImage)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <a href="{{ asset('assets1/images/'.$propImage->image.'') }}" class="image-popup gal-item"><img src="{{ asset('assets1/images/'.$propImage->image.'') }}" alt="Image" class="img-fluid"></a>
                </div>
              @endforeach
             
             
            </div>
          </div>
        </div>
        <div class="col-lg-4">

          <div class="bg-white widget border rounded">

            <h3 class="h4 text-black widget-title mb-3">Contact Agent</h3>
            @if(isset(Auth::user()->id))
              @if($validateFormCount > 0)
                <p class="alert alert-success">Request Already Sent</p>
              @else
                <form method="POST" action="{{ route('insert.request', $singleProp->id) }}" class="form-contact-agent">
                  @csrf
                  <div class="form-group">
                    <input name="prop_id" value="{{ $singleProp->id }}" type="hidden" id="name" class="form-control">
                  </div>
                  <div class="form-group">
                    <input name="agent_name" value="Admins" type="hidden" id="name" class="form-control">
                  </div>

                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                  </div>
                  @error('name')
                      <span class="text-danger" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                  </div>
                  @error('email')
                      <span class="text-danger" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                  <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control" minlength="11" required>
                  </div>

                  @error('phone')
                      <span class="text-danger" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror


                  <div class="form-group">
                    <input type="submit" name="submit" id="phone" class="btn btn-primary" value="Send Request">
                  </div>
                </form>

              @endif
            @else 
             <p class="alert alert-success">Login to send a Request</p> 
            @endif  
          </div>

          <div class="bg-white widget border rounded">

            <h3 class="h4 text-black widget-title mb-3">Save this Property</h3>
            @if(isset(Auth::user()->id))
              @if($validateSavingPropsCount > 0)
                <input type="submit" name="submit" id="phone" class="btn btn-primary" disabled value="Property Saved">
              @else
                <form method="POST" action="{{ route('save.prop', $singleProp->id) }}" class="form-contact-agent">
                  @csrf
                  <div class="form-group">
                    <input name="prop_id" value="{{ $singleProp->id }}" type="hidden" id="name" class="form-control">
                  </div>
                  <div class="form-group">
                    <input name="title" value="{{ $singleProp->title }}" type="hidden" id="name" class="form-control">
                  </div>

                  <div class="form-group">
                    <input type="hidden" value="{{ $singleProp->image }}" name="image" id="name" class="form-control">
                  </div>
                
                  <div class="form-group">
                    <input type="hidden"  value="{{ $singleProp->location }}" name="location" id="email" class="form-control">
                  </div>
                
                  <div class="form-group">
                    <input type="hidden" value="{{ $singleProp->price }}" name="price" id="phone" class="form-control">
                  </div>

    


                  <div class="form-group">
                    <input type="submit" name="submit" id="phone" class="btn btn-primary" value="Save property">
                  </div>
                </form>

              @endif
            @else 
              <p class="alert alert-success">login to Save</p> 
            @endif  
         
          </div>

          <div class="bg-white widget border rounded">
            <h3 class="h4 text-black widget-title mb-3 ml-0">Share</h3>
                <div class="px-3" style="margin-left: -15px;">
                  <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('single.prop', $singleProp->id) }}&quote={{ $singleProp->title }}" class="text-decoration-none pt-3 pb-3 pr-3 pl-0"><span class="icon-facebook"></span></a>
                  <a  href="https://twitter.com/intent/tweet?text={{ $singleProp->title }}&url={{ route('single.prop', $singleProp->id) }}" class="text-decoration-none pt-3 pb-3 pr-3 pl-0"><span class="icon-twitter"></span></a>
                  <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ route('single.prop', $singleProp->id) }}" class="text-decoration-none pt-3 pb-3 pr-3 pl-0"><span class="icon-linkedin"></span></a>    
                </div>            
          </div>

        </div>
        
      </div>
    </div>
  </div>

  <div class="site-section site-section-sm bg-light">
    <div class="container">

      <div class="row">
        <div class="col-12">
          <div class="site-section-title mb-5">
            <h2>Related Properties</h2>
          </div>
        </div>
      </div>
    
      <div class="row mb-5">
        @if ($relatedProps->count() > 0)
            @foreach ($relatedProps as $relatedProp)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="property-entry h-100">
                <a href="{{ route('single.prop', $relatedProp->id) }}" class="property-thumbnail">
                    <div class="offer-type-wrap">
                    <span class="offer-type bg-danger">For Sale</span>
                    </div>
                    <img src="{{ asset('assets1/images/'.$relatedProp->image.'') }}" alt="Image" class="img-fluid">
                </a>
                <div class="p-4 property-body">
                    <h2 class="property-title"><a class="text-decoration-none" href="{{ route('single.prop', $relatedProp->id) }}">{{ $relatedProp->title }}</a></h2>
                    <span class="property-location d-block mb-3"><span class="property-icon icon-room"></span> {{ $relatedProp->location }}</span>
                    <strong class="property-price text-primary mb-3 d-block text-success">PHP {{ number_format((float) $relatedProp->price) }}</strong>
                    <ul class="property-specs-wrap mb-3 mb-lg-0">
                    <li>
                        <span class="property-specs">Beds</span>
                        <span class="property-specs-number">{{ $relatedProp->beds }} <sup>+</sup></span>
                        
                    </li>
                    <li>
                        <span class="property-specs">Baths</span>
                        <span class="property-specs-number">{{ $relatedProp->baths }}</span>
                        
                    </li>
                    <li>
                        <span class="property-specs">SQ FT</span>
                        <span class="property-specs-number">{{ $relatedProp->sq_ft }}</span>
                        
                    </li>
                    </ul>
    
                </div>
                </div>
            </div> 
            @endforeach
        @else
            <h3 class="alert alert-success">No Related Properties Available</h3>
        @endif
     
        

       
      </div>
    </div>
    @endsection
