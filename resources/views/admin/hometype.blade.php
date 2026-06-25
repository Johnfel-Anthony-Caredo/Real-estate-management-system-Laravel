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
                </div>
            </div>
        </div>
<br><br><br>
        <!-- Page content -->
        <div class="container-fluid mt--8">
            <!-- Table -->
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center">
                            <a href="#" class="btn btn-outline-success" data-toggle="modal" data-target="#addHomeTypeModal">
                                <i class="fas fa-plus"></i>
                                Add New Home Type
                            </a>
                            <div class="btn-group">
                                <a href="{{ route('admin.hometypes') }}" class="btn btn-outline-primary">Active</a>
                                <a href="{{ route('admin.hometypes.trashed') }}" class="btn btn-outline-danger">Deleted</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-success" scope="col">ID</th>
                                        <th scope="col">Home Type</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($homeTypes as $type)
                                        <tr>
                                            <td class="text-success">{{ $type->id }}</td>
                                            <td>{{ $type->hometypes }}</td>
                                            <td>{{ $type->created_at->format('M d, Y') }}</td>
                                            <td>
                                                @if($type->deleted_at)
                                                    <span class="badge badge-danger">Deleted</span>
                                                @else
                                                    <span class="badge badge-success">Active</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($type->deleted_at)
                                                    <form action="{{ route('hometype.restore', $type->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="fas fa-trash-restore"></i>
                                                            Restore
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('hometype.force-delete', $type->id) }}" method="POST" class="d-inline" onsubmit="return confirm('This will permanently delete this home type. Are you sure?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                            Delete Permanently
                                                        </button>
                                                    </form>
                                                @else
                                                    <button type="button"
                                                       class="btn btn-sm btn-primary edit-btn"
                                                       data-id="{{ $type->id }}"
                                                       data-name="{{ $type->hometypes }}">
                                                        <i class="fas fa-edit"></i>
                                                        Update
                                                    </button>
                                                    <form action="{{ route('hometype.delete', $type->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this home type?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="card-footer py-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    Showing {{ $homeTypes->count() }} entries
                                </div>
                                {{ $homeTypes->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            @include('partials._footer') <!-- Include footer partial -->
        </div>
    </div>

    <!-- Add Home Type Modal -->
    <div class="modal fade" id="addHomeTypeModal" tabindex="-1" role="dialog" aria-labelledby="addHomeTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-gradient-light shadow-lg border-0">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title text-white" id="addHomeTypeModalLabel">
                        <i class="fas fa-home mr-2"></i>Add New Home Type
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('hometype.store') }}" method="POST" id="addHomeTypeForm">
                        @csrf
                        <div class="form-group">
                            <label for="hometypes" class="form-control-label text-dark">
                                <i class="fas fa-tag mr-2"></i>Home Type Name:
                            </label>
                            <div class="input-group input-group-merge">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                </div>
                                <input type="text" class="form-control" id="hometypes" name="hometypes" placeholder="Enter home type name" required>
                            </div>
                            <small class="form-text text-muted"></small>
                        </div>
                        <div class="text-center mt-4">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save mr-2"></i>Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this modal after the Add Home Type Modal -->
    <!-- Edit Home Type Modal -->
    <div class="modal fade" id="editHomeTypeModal" tabindex="-1" role="dialog" aria-labelledby="editHomeTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-gradient-light shadow-lg border-0">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title text-white" id="editHomeTypeModalLabel">
                        <i class="fas fa-edit mr-2"></i>Update Home Type
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="" method="POST" id="editHomeTypeForm">
                        @csrf
                        <div class="form-group">
                            <label for="edit_hometypes" class="form-control-label text-dark">
                                <i class="fas fa-tag mr-2"></i>Home Type Name:
                            </label>
                            <div class="input-group input-group-merge">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                </div>
                                <input type="text" class="form-control" id="edit_hometypes" name="hometypes" placeholder="Enter home type name" required>
                            </div>
                            <small class="form-text text-muted"></small>
                        </div>
                        <div class="text-center mt-4">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save mr-2"></i>Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this script at the end of the file, before the @include('partials._scripts') -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.edit-btn').forEach(function(element) {
                element.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.getElementById('editHomeTypeForm').action = "{{ url('admin/hometypes') }}/" + this.dataset.id;
                    document.getElementById('edit_hometypes').value = this.dataset.name;
                    
                    $('#editHomeTypeModal').modal('show');
                });
            });
        });
    </script>

    <!-- Argon Scripts -->
    @include('partials._scripts') <!-- Include scripts partial -->
</body>
</html>
