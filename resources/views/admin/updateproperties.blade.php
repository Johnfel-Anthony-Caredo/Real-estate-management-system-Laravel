<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials._head') <!-- Include head partial -->
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
                    @if(session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            {{ session('info') }}
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
            <!-- Table -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 style="font-size: 20px;" class="mb-0">Update Property</h6>
                                <a href="{{ route('admin.properties') }}" class="btn btn-primary btn-sm">Back to Properties</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('property.update', $property->id) }}" method="POST" enctype="multipart/form-data" id="propertyForm">
                                @csrf
                                <p class="text-uppercase text-sm">Property Information</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title" class="form-control-label">Title</label>
                                            <input class="form-control @error('title') is-invalid @enderror" type="text" id="title" name="title" value="{{ old('title', $property->title) }}">
                                            @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price" class="form-control-label">Price (PHP)</label>
                                            <input class="form-control @error('price') is-invalid @enderror" type="number" id="price" name="price" value="{{ old('price', $property->price) }}">
                                            @error('price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="beds" class="form-control-label">Beds</label>
                                            <input class="form-control @error('beds') is-invalid @enderror" type="number" id="beds" name="beds" value="{{ old('beds', $property->beds) }}">
                                            @error('beds')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="baths" class="form-control-label">Baths</label>
                                            <input class="form-control @error('baths') is-invalid @enderror" type="number" id="baths" name="baths" value="{{ old('baths', $property->baths) }}">
                                            @error('baths')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="sq_ft" class="form-control-label">Square Feet</label>
                                            <input class="form-control @error('sq_ft') is-invalid @enderror" type="number" id="sq_ft" name="sq_ft" value="{{ old('sq_ft', $property->sq_ft) }}">
                                            @error('sq_ft')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="home_type" class="form-control-label">Home Type</label>
                                            <select class="form-control @error('home_type') is-invalid @enderror" id="home_type" name="home_type">
                                                <option value="">Select Home Type</option>
                                                @foreach($homeTypes as $type)
                                                    <option value="{{ $type->hometypes }}" {{ old('home_type', $property->home_type) == $type->hometypes ? 'selected' : '' }}>{{ $type->hometypes }}</option>
                                                @endforeach
                                            </select>
                                            @error('home_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="year_built" class="form-control-label">Year Built</label>
                                            <input class="form-control @error('year_built') is-invalid @enderror" type="number" id="year_built" name="year_built" value="{{ old('year_built', $property->year_built) }}">
                                            @error('year_built')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price_sqft" class="form-control-label">Price per Sq Ft</label>
                                            <input class="form-control @error('price_sqft') is-invalid @enderror" type="number" step="0.01" id="price_sqft" name="price_sqft" value="{{ old('price_sqft', $property->price_sqft) }}">
                                            @error('price_sqft')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="location" class="form-control-label">Location</label>
                                            <input class="form-control @error('location') is-invalid @enderror" type="text" id="location" name="location" value="{{ old('location', $property->location) }}">
                                            @error('location')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="agent_name" class="form-control-label">Agent Name</label>
                                            <input class="form-control @error('agent_name') is-invalid @enderror" type="text" id="agent_name" name="agent_name" value="{{ old('agent_name', $property->agent_name) }}">
                                            @error('agent_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="more_info" class="form-control-label">More Information</label>
                                            <textarea class="form-control @error('more_info') is-invalid @enderror" id="more_info" name="more_info" rows="4">{{ old('more_info', $property->more_info) }}</textarea>
                                            @error('more_info')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary">Update Property</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6 style="font-size: 20px;" class="mb-0">Property Images</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="image" class="form-control-label">Main Property Image</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" form="propertyForm">
                                    <label class="custom-file-label" for="image">Choose file</label>
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">Leave empty to keep current image.</small>
                                @if($property->image)
                                <div id="currentImage" class="mt-3 text-center">
                                    <p>Current Image:</p>
                                    <img src="{{ asset('assets1/images/' . $property->image) }}" alt="Current Property Image" class="img-fluid" style="max-height: 200px;">
                                </div>
                                @endif
                                <div id="imagePreview" class="mt-3 text-center d-none">
                                    <p>New Image Preview:</p>
                                    <img src="" alt="Image Preview" class="img-fluid" style="max-height: 200px;">
                                </div>
                            </div>
                            
                            <div class="form-group mt-4">
                                <label for="gallery" class="form-control-label">Add More Gallery Images</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="gallery" name="gallery[]" multiple form="propertyForm">
                                    <label class="custom-file-label" for="gallery">Choose files</label>
                                </div>
                                <small class="form-text text-muted">You can select multiple images to add to the gallery.</small>
                                <div id="galleryPreview" class="mt-3 row">
                                    <!-- Gallery previews will be displayed here -->
                                </div>
                                <div class="mt-2">
                                    <button type="button" id="clearGallery" class="btn btn-sm btn-outline-danger">Clear Selected Images</button>
                                </div>
                            </div>
                            
                            <!-- Display existing gallery images -->
                            @if($galleryImages && $galleryImages->count() > 0)
                            <div class="mt-4">
                                <h6 class="mb-3">Current Gallery Images</h6>
                                <div class="row">
                                    @foreach($galleryImages as $image)
                                    <div class="col-6 mb-3">
                                        <div class="position-relative">
                                            <img src="{{ asset('assets1/images/' . $image->image) }}" alt="Gallery Image" class="img-fluid rounded" style="height: 120px; width: 100%; object-fit: cover;">
                                            <form action="{{ route('gallery.delete', $image->id) }}" method="POST" class="position-absolute" style="top: 5px; right: 5px;" onsubmit="return confirm('Are you sure you want to delete this image?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" style="padding: 0.2rem 0.4rem;">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            @include('partials._footer') <!-- Include footer partial -->
        </div>
    </div>

    <!-- Argon Scripts -->
    @include('partials._scripts') <!-- Include scripts partial -->
    
    <script>
        // Image preview functionality
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const preview = document.getElementById('imagePreview');
                    preview.classList.remove('d-none');
                    document.getElementById('currentImage').classList.add('d-none');
                    preview.querySelector('img').src = event.target.result;
                }
                reader.readAsDataURL(file);
                document.querySelector('label[for="image"]').textContent = file.name;
            }
        });
        
        // Gallery preview functionality with remove buttons
        let selectedFiles = []; // Array to store selected files
        
        document.getElementById('gallery').addEventListener('change', function(e) {
            const newFiles = Array.from(e.target.files);
            selectedFiles = selectedFiles.concat(newFiles);
            updateGalleryPreview();
        });
        
        // Clear all gallery images
        document.getElementById('clearGallery').addEventListener('click', function() {
            selectedFiles = [];
            updateGalleryPreview();
            document.getElementById('gallery').value = '';
            document.querySelector('label[for="gallery"]').textContent = 'Choose files';
        });
        
        function updateGalleryPreview() {
            const galleryPreview = document.getElementById('galleryPreview');
            galleryPreview.innerHTML = '';
            
            if (selectedFiles.length > 0) {
                document.querySelector('label[for="gallery"]').textContent = selectedFiles.length + ' files selected';
                
                selectedFiles.forEach((file, index) => {
                    const col = document.createElement('div');
                    col.className = 'col-6 mb-3 position-relative';
                    col.dataset.index = index;
                    
                    // Create image container
                    const imgContainer = document.createElement('div');
                    imgContainer.className = 'position-relative';
                    imgContainer.style.height = '120px';
                    
                    // Create image element
                    const img = document.createElement('img');
                    img.className = 'img-fluid rounded';
                    img.style.height = '100%';
                    img.style.width = '100%';
                    img.style.objectFit = 'cover';
                    
                    // Create remove button
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn btn-danger btn-sm position-absolute';
                    removeBtn.style.top = '5px';
                    removeBtn.style.right = '5px';
                    removeBtn.style.padding = '0.2rem 0.4rem';
                    removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                    removeBtn.addEventListener('click', function() {
                        removeImage(index);
                    });
                    
                    // Create file name display
                    const fileName = document.createElement('small');
                    fileName.className = 'text-muted d-block mt-1 text-truncate';
                    fileName.textContent = file.name;
                    
                    // Read file and set image source
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        img.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                    
                    // Append elements
                    imgContainer.appendChild(img);
                    imgContainer.appendChild(removeBtn);
                    col.appendChild(imgContainer);
                    col.appendChild(fileName);
                    galleryPreview.appendChild(col);
                });
                
                // Create a new FormData and append the selected files
                updateFormData();
            } else {
                galleryPreview.innerHTML = '<div class="col-12 text-center text-muted"><p>No new images selected</p></div>';
            }
        }
        
        function removeImage(index) {
            selectedFiles.splice(index, 1);
            updateGalleryPreview();
        }
        
        function updateFormData() {
            // This function will be called before form submission
            // to ensure all selected files are included
            const galleryInput = document.getElementById('gallery');
            
            // Create a new DataTransfer object
            const dataTransfer = new DataTransfer();
            
            // Add all selected files to the DataTransfer object
            selectedFiles.forEach(file => {
                dataTransfer.items.add(file);
            });
            
            // Set the gallery input files to the DataTransfer files
            galleryInput.files = dataTransfer.files;
        }
        
        // Add form submission event listener to ensure files are properly attached
        document.getElementById('propertyForm').addEventListener('submit', function(e) {
            updateFormData();
        });
    </script>
</body>
</html>
