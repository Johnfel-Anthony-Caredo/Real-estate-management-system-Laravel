<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials._head')
</head>
<body>
    @include('partials._sidebar')

    <div class="main-content">
        @include('partials._topnav')

        <div class="header admin-hero pb-8 pt-5 pt-md-8">
            <span class="mask bg-gradient-dark opacity-5"></span>
            <div class="container-fluid">
                <div class="header-body">
                    @includeWhen(session('success') || session('error') || session('info'), 'partials._flash')
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="text-white-50 mb-1">Portfolio inventory</p>
                            <h1 class="text-white mb-0">Properties</h1>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('property.add') }}" class="btn btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Property
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mt--7">
            <div class="card shadow admin-card">
                <div class="card-header border-0 d-flex flex-wrap align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-0">Active Listings</h3>
                        <p class="text-muted mb-0">Manage listing content, imagery, and availability.</p>
                    </div>
                    <span class="badge badge-pill badge-primary">{{ $properties->count() }} shown</span>
                </div>
                <div class="card-body">
                    @forelse ($properties as $property)
                        <div class="admin-property-row">
                            <img src="{{ asset('assets1/images/' . $property->image) }}" alt="{{ $property->title }}" class="admin-property-image">
                            <div class="admin-property-content">
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div>
                                        <span class="badge badge-light">{{ $property->home_type }}</span>
                                        <h3 class="h4 mt-2 mb-1">{{ $property->title }}</h3>
                                        <p class="text-muted mb-2"><i class="fas fa-map-marker-alt mr-1"></i>{{ $property->location }}</p>
                                    </div>
                                    <strong class="admin-price">PHP {{ number_format((float) $property->price) }}</strong>
                                </div>
                                <div class="admin-spec-grid">
                                    <span><i class="fas fa-bed"></i>{{ $property->beds }} beds</span>
                                    <span><i class="fas fa-bath"></i>{{ $property->baths }} baths</span>
                                    <span><i class="fas fa-ruler-combined"></i>{{ number_format((float) $property->sq_ft) }} sq ft</span>
                                    <span><i class="fas fa-user-tie"></i>{{ $property->agent_name }}</span>
                                </div>
                                <div class="admin-row-actions">
                                    <a href="{{ route('single.prop', $property->id) }}" class="btn btn-sm btn-outline-secondary" target="_blank">
                                        <i class="fas fa-eye mr-1"></i>Preview
                                    </a>
                                    <a href="{{ route('property.edit', $property->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <form action="{{ route('property.delete', $property->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this property and its gallery images?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash mr-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-building"></i>
                            <h3>No properties yet</h3>
                            <p>Add a polished demo listing to make the public site come alive.</p>
                            <a href="{{ route('property.add') }}" class="btn btn-primary">Add the first property</a>
                        </div>
                    @endforelse
                </div>
                @if($properties->count() > 0)
                    <div class="card-footer py-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Showing {{ $properties->count() }} entries</span>
                            {{ $properties->links() }}
                        </div>
                    </div>
                @endif
            </div>

            @include('partials._footer')
        </div>
    </div>

    @include('partials._scripts')
</body>
</html>
