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
                        <div class="card-header border-0">
                            <a href="#" class="btn btn-outline-success" data-toggle="modal" data-target="#addUserModal">
                                <i class="fas fa-user-plus"></i>
                                Add New User
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-success" scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="text-success">{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-user-edit"></i>
                                                    Update
                                                </a>
                                                <form action="{{ route('user.delete', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                        Delete
                                                    </button>
                                                </form>
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
                                    Showing {{ $users->count() }} entries
                                </div>
                                {{ $users->links() }}
                            </div>
                        </div>
</div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            @include('partials._footer') <!-- Include footer partial -->
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-gradient-light shadow-lg border-0">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title text-white" id="addUserModalLabel">
                        <i class="fas fa-user-plus mr-2"></i>Add New User
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('user.store') }}" method="POST" id="addUserForm">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-control-label text-dark">
                                <i class="fas fa-user mr-2"></i>Full Name:
                            </label>
                            <div class="input-group input-group-merge">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-control-label text-dark">
                                <i class="fas fa-envelope mr-2"></i>Email Address:
                            </label>
                            <div class="input-group input-group-merge">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
                            </div>
                            <small id="email-error" class="form-text text-danger" style="display: none;">This email is already registered.</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="password" class="form-control-label text-dark">
                                <i class="fas fa-lock mr-2"></i>Password:
                            </label>
                            <div class="input-group input-group-merge">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="password_confirmation" class="form-control-label text-dark">
                                <i class="fas fa-lock mr-2"></i>Confirm Password:
                            </label>
                            <div class="input-group input-group-merge">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm password" required>
                            </div>
                            <small id="password-error" class="form-text text-danger" style="display: none;">Passwords do not match.</small>
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

    <!-- Argon Scripts -->
    @include('partials._scripts') <!-- Include scripts partial -->
    
    <script>
        // Client-side validation for password matching
        document.getElementById('addUserForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const passwordError = document.getElementById('password-error');
            
            if (password !== confirmPassword) {
                e.preventDefault();
                passwordError.style.display = 'block';
            } else {
                passwordError.style.display = 'none';
            }
        });
        
        // Check for duplicate email
        document.getElementById('email').addEventListener('blur', async function() {
            const email = this.value;
            const emailError = document.getElementById('email-error');
            
            if (email) {
                try {
                    const response = await fetch("{{ route('user.check-email') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ email: email })
                    });
                    
                    const data = await response.json();
                    
                    if (data.exists) {
                        emailError.style.display = 'block';
                    } else {
                        emailError.style.display = 'none';
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }
        });
    </script>
</body>
</html>
