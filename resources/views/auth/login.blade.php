<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | EstateOS</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets1/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/showcase.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <main class="auth-shell">
        <div class="container-fluid">
            <div class="row min-vh-100">
                <section class="col-lg-6 auth-visual" style="background-image: url('{{ asset('assets1/images/final.jpg') }}');">
                    <div class="auth-visual-content">
                        <p class="text-uppercase font-weight-bold mb-2">Real Estate Management System</p>
                        <h1 class="display-4 text-white font-weight-bold mb-3">Find, save, and request properties with confidence.</h1>
                        <p class="lead mb-0">A Laravel portfolio project with admin analytics, database audit logs, property galleries, and user request tracking.</p>
                    </div>
                </section>

                <section class="col-lg-6 auth-panel">
                    <div class="auth-card">
                        <a href="{{ route('home') }}" class="text-decoration-none font-weight-bold text-muted">
                            <i class="fas fa-arrow-left mr-2"></i>Back to listings
                        </a>
                        <div class="mt-4 mb-4">
                            <p class="text-uppercase text-muted font-weight-bold mb-2">Welcome back</p>
                            <h1>Login to your account</h1>
                            <p class="text-muted mb-0">Save homes, monitor requests, and continue your property search.</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
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
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="remember">Remember me</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">Forgot password?</a>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-success btn-block py-3 font-weight-bold">
                                <i class="fas fa-sign-in-alt mr-2"></i>Login
                            </button>
                        </form>

                        <p class="text-center text-muted mt-4 mb-0">
                            New here? <a href="{{ route('register') }}" class="font-weight-bold">Create an account</a>
                        </p>
                    </div>
                </section>
            </div>
        </div>
    </main>
</body>
</html>
