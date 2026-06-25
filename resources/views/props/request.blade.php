@extends('layouts.app1')

@section('content')
<div class="site-blocks-cover inner-page-cover overlay" style="background-image: url({{ asset('assets1/images/1234.jpg')}});" data-aos="fade">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-10">
                <h1 class="mb-2">My Property Requests</h1>
            </div>
        </div>
    </div>
</div>

<div class="site-section site-section-sm bg-light">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="site-section-title mb-5">
                    <h2>My Property Requests</h2>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            @if ($requests->count() > 0)
                @foreach ($requests as $request)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="property-entry h-100">
                            <a href="{{ route('single.prop', $request->property->id) }}" class="property-thumbnail">
                                <div class="offer-type-wrap">
                                    <span class="offer-type bg-info">Requested</span>
                                </div>
                                <img src="{{ asset('assets1/images/'.$request->property->image.'') }}" alt="Image" class="img-fluid">
                            </a>
                            <div class="p-4 property-body">
                                <h2 class="property-title">
                                    <a href="{{ route('single.prop', $request->property->id) }}">{{ $request->property->title }}</a>
                                </h2>
                                <span class="property-location d-block mb-3">
                                    <span class="property-icon icon-room"></span> {{ $request->property->location }}
                                </span>
                                <strong class="property-price text-primary mb-3 d-block text-success">PHP {{ number_format((float) $request->property->price) }}</strong>
                                <ul class="property-specs-wrap mb-3 mb-lg-0">
                    
                                    <li>
                                        <span class="property-specs">Requested On</span>
                                        <span class="property-specs-number">{{ $request->created_at->format('M d, Y') }}</span>
                                    </li>
                                </ul>
                                <form action="{{ route('cancel.request', $request->id) }}" method="POST" class="text-center mt-3" onsubmit="return confirm('Are you sure you want to cancel this request?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center gap-2 w-100">
                                        <i class="fas fa-times mr-2"></i> Cancel Request
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <h3 class="text-center">No property requests found.</h3>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
