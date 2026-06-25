@extends('layouts.app1')

@section('content')
<div class="site-blocks-cover inner-page-cover overlay" style="background-image: url({{ asset('assets1/images/1234.jpg')}});" data-aos="fade">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-10">
                <h1 class="mb-2">Revolutionizing Your Real Estate Journey</h1>
                <p class="text-white">Discover a Smarter Way to Manage, Buy, and Sell Properties.</p>
            </div>
        </div>
    </div>
</div>

<div class="site-section site-section-sm bg-light">
    <div class="container">
        <!-- About Section -->
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
                <img src="{{ asset('assets1/images/img_5.jpg') }}" alt="Modern Real Estate Platform" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-6 pl-lg-5" data-aos="fade-up" data-aos-delay="200">
                <h2 class="font-weight-bold text-primary mb-4">The Future of Property Management, Today.</h2>
                <p class="lead">Our platform is meticulously designed to empower every stakeholder in the real estate ecosystem – from discerning buyers and motivated sellers to dynamic agents and meticulous administrators.</p>
                <p>We offer a comprehensive, intuitive, and technologically advanced Real Estate Management System. This isn't just a listing service; it's an integrated solution that streamlines complex processes, enhances user experience, and drives successful property transactions. We connect aspirations with opportunities through a seamless digital interface, backed by powerful tools for unparalleled efficiency.</p>
                <div class="row mt-4">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary p-2 rounded-circle mr-3">
                                <i class="icon-shield text-white"></i>
                            </div>
                            <h5 class="mb-0">Secure Transactions</h5>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary p-2 rounded-circle mr-3">
                                <i class="icon-refresh text-white"></i>
                            </div>
                            <h5 class="mb-0">Real-time Updates</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Core Features Section -->
        <div class="row mb-5" data-aos="fade-up">
            <div class="col-12 text-center mb-5">
                <h2 class="font-weight-bold text-primary">Unlock a World of Real Estate Possibilities</h2>
                <p class="lead">Explore the core functionalities that set our platform apart.</p>
            </div>
            
            <div class="col-md-4 mb-4">
    <div class="card h-100 border-0 shadow-sm">
        <div class="card-body text-center p-4">
            <div class="rounded-circle bg-primary d-inline-flex p-3 mb-3">
                <i class="icon-magnifier text-white h3 mb-0"></i>
            </div>
            <h4>Easy Property Search</h4>
            <p>Quickly find properties based on style, amenities, location, and more. Find the right place faster.</p>
        </div>
    </div>
</div>

<div class="col-md-4 mb-4">
    <div class="card h-100 border-0 shadow-sm">
        <div class="card-body text-center p-4">
            <div class="rounded-circle bg-primary d-inline-flex p-3 mb-3">
                <i class="icon-user text-white h3 mb-0"></i>
            </div>
            <h4>Easy User & Admin Management</h4>
            <p>Manage clients, and admins with simple tools, clear roles, and efficient workflows.</p>
        </div>
    </div>
</div>

<div class="col-md-4 mb-4">
    <div class="card h-100 border-0 shadow-sm">
        <div class="card-body text-center p-4">
            <div class="rounded-circle bg-primary d-inline-flex p-3 mb-3">
                <i class="icon-graph text-white h3 mb-0"></i>
            </div>
            <h4>Market Insights</h4>
            <p>Access data on market trends, property performance, and user activity to make smarter decisions.</p>
        </div>
    </div>
</div>

        </div>

      
    
    </div>
</div>
@endsection