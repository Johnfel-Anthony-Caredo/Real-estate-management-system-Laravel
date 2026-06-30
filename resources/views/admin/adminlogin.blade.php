<!doctype html>
<html lang="en">
<head>
    @include('partials._head')
</head>
<body>
    <main class="auth-shell">
        <div class="container-fluid">
            <div class="row min-vh-100">
                <section class="col-lg-6 auth-visual" style="background-image: url('{{ asset('assets1/images/final1.jpg') }}');">
                    <div class="auth-visual-content">
                        <p class="text-uppercase font-weight-bold mb-2">EstateOS Admin</p>
                        <h1 class="display-4 text-white font-weight-bold mb-3">Control listings, requests, people, and audit logs.</h1>
                        <p class="lead mb-0">Built as a Laravel database showcase with protected management workflows and reporting views.</p>
                    </div>
                </section>

                <section class="col-lg-6 auth-panel">
                    <div class="auth-card">
                        <a href="{{ route('home') }}" class="text-decoration-none font-weight-bold text-muted">
                            <i class="fas fa-arrow-left mr-2"></i>Back to public site
                        </a>
                        <div class="mt-4 mb-4">
                            <p class="text-uppercase text-muted font-weight-bold mb-2">Admin portal</p>
                            <h1>Sign in to manage</h1>
                            <p class="text-muted mb-0">Use the local admin account configured in your environment file.</p>
                        </div>

                        <form method="POST" action="{{ route('admin.login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="font-weight-bold">Email address</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" class="font-weight-bold">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success btn-block py-3 font-weight-bold">
                                <i class="fas fa-lock mr-2"></i>Login as admin
                            </button>
                        </form>

                        <div class="alert alert-light border mt-4 mb-0">
                            <strong>Local demo:</strong> set <code>SEED_DEMO_ADMIN=true</code> and your own <code>DEMO_ADMIN_PASSWORD</code> before seeding.
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

    @include('partials._scripts')
</body>
</html>
