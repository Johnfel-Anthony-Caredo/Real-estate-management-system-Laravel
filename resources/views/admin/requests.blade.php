<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials._head') <!-- Include head partial -->
    <style>
        .property-card {
            display: flex;
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background-color: white;
            height: 240px;
        }
        .property-image {
            width: 300px;
            height: 100%;
            object-fit: cover;
        }
        .property-details {
            padding: 15px;
            flex: 1;
            position: relative;
        }
        .property-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .property-price {
            font-size: 20px;
            color: #5e72e4;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .property-info {
            display: flex;
            margin-bottom: 10px;
        }
        .property-info div {
            margin-right: 15px;
        }
        .property-location {
            color: #525f7f;
            margin-bottom: 10px;
        }
        .property-actions {
            position: absolute;
            bottom: 15px;
            right: 15px;
        }
        .request-info {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 10px;
        }
        .request-info p {
            margin-bottom: 5px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-pending {
            background-color: #ffeeba;
            color: #856404;
        }
        .status-completed {
            background-color: #c3e6cb;
            color: #155724;
        }
    </style>
</head>
<body>
    <!-- Sidenav -->
    @include('partials._sidebar') <!-- Include sidebar partial -->

    <!-- Main content -->
    <div class="main-content">
        <!-- Top navbar -->
        @include('partials._topnav') <!-- Include top navbar partial -->

        <!-- Header -->
        <div style="background-image: url('{{ asset('assets/img/theme/restro00.jpg') }}'); background-size: cover;" class="header pb-8 pt-5 pt-md-8">
            <span class="mask bg-gradient-dark opacity-4"></span>
            <div class="container-fluid">
                <div class="header-body">
                    <!-- Flash Messages -->
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
                </div>
            </div>
        </div>
<br><br><br>
        <!-- Page content -->
        <div class="container-fluid mt--8">
            <!-- Properties -->
     
            <!-- Requests -->
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">Property Requests</h3>
                        </div>
                        <div class="card-body">
                            @if(isset($requests) && count($requests) > 0)
                                @foreach ($requests as $request)
                                <div class="property-card">
                                    <img src="{{ asset('assets1/images/' . $request->property_image) }}" alt="{{ $request->property_title }}" class="property-image">
                                    <div class="property-details">
                                        <div class="property-title">{{ $request->property_title }}</div>
                                        <div class="property-price">PHP {{ number_format((float) $request->property_price) }}</div>
                                        <div class="property-location"><i class="fas fa-map-marker-alt mr-1"></i> {{ $request->property_location }}</div>
                                        
                                        <div class="request-info">
                                            <p><strong>Request ID:</strong> #{{ $request->id }}</p>
                                            <p><strong>Client:</strong> {{ $request->name }} (ID: {{ $request->user_id }})</p>
                                            <p><strong>Contact:</strong> {{ $request->email }} | {{ $request->phone }}</p>
                                            <p><strong>Requested on:</strong> {{ $request->created_at->format('M d, Y h:i A') }}</p>
                                            <p><strong>Status:</strong> 
                                                <span class="status-badge {{ $request->status == 'pending' ? 'status-pending' : 'status-completed' }}">
                                                    {{ ucfirst($request->status) }}
                                                </span>
                                            </p>
                                        </div>
                                        
                                        <div class="property-actions">
                                            <form action="{{ route('admin.request.update-status', $request->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Update this request status?');">
                                                @csrf
                                                <input type="hidden" name="status" value="{{ $request->status == 'pending' ? 'completed' : 'pending' }}">
                                                <button type="submit" class="btn btn-sm {{ $request->status == 'pending' ? 'btn-success' : 'btn-warning' }}">
                                                    <i class="fas {{ $request->status == 'pending' ? 'fa-check' : 'fa-undo' }}"></i>
                                                    {{ $request->status == 'pending' ? 'Mark as Completed' : 'Mark as Pending' }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-5">
                                    <h4 class="text-muted">No property requests found</h4>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Pagination -->
                        @if(isset($requests) && $requests->count() > 0)
                        <div class="card-footer py-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    Showing {{ $requests->count() }} entries
                                </div>
                                {{ $requests->links() }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Footer -->
            @include('partials._footer') <!-- Include footer partial -->
        </div>
    </div>

    <!-- Argon Scripts -->
    @include('partials._scripts') <!-- Include scripts partial -->
</body>
</html>
