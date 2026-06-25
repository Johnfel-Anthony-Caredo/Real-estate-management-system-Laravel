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
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 style="font-size: 20px;" class="mb-0">Edit User</h6>
                                <a href="{{ route('admin.users') }}" class="btn btn-primary btn-sm">Back to Users</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user.update', $user->id) }}" method="POST">
                                @csrf
                                <p class="text-uppercase text-sm">User Information</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="form-control-label">Name</label>
                                            <input class="form-control" type="text" id="name" name="name" value="{{ $user->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-control-label">Email address</label>
                                            <input class="form-control" type="email" id="email" name="email" value="{{ $user->email }}">
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">Change Password</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password" class="form-control-label">New Password</label>
                                            <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <small class="text-muted">Leave blank to keep current password</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation" class="form-control-label">Confirm Password</label>
                                            <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" id="password_confirmation" name="password_confirmation">
                                            @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary">Update User</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-profile shadow">
                        <div class="card-header position-relative" style="background-image: url('{{ asset('assets1/images/hero_bg_2.jpg') }}'); background-size: cover; height: 180px;">
                            <img src="{{ asset('assets/img/theme/user-a-min.png') }}" class="position-absolute rounded-circle" style="width: 150px; height: 150px; bottom: -60px; left: 50%; transform: translateX(-50%); z-index: 1; border: 3px solid white;">
                        </div>
                        <div class="card-body pt-4"> <!-- Changed padding-top from pt-5 to pt-4 -->
                            <div class="row">
                                <div class="col">
                                    <div class="card-profile-stats d-flex justify-content-center">
                                        <div class="text-center">
                                            <h3 class="mt-3">{{ $user->name }}</h3>
                                            <div style="font-size: 20px;" class="h5 font-weight-300">
                                                <i class="ni location_pin mr-2"></i>{{ $user->email }}
                                            </div>
                                            <div class="h5 mt-5">
                                                <i class="ni business_briefcase-24 mr-2"></i>User ID: {{ $user->id }}
                                            </div>
                                            <div>
                                                <i class="ni education_hat mr-2"></i>Joined: {{ \Carbon\Carbon::parse($user->created_at)->format('M d, Y') }}
                                            </div>
                                        </div>
                                    </div>
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

    <!-- Argon Scripts -->
    @include('partials._scripts') <!-- Include scripts partial -->
</body>
</html>
