<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register | EstateOS</title>

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
                <section class="col-lg-6 auth-visual" style="background-image: url('{{ asset('assets1/images/about.jpg') }}');">
                    <div class="auth-visual-content">
                        <p class="text-uppercase font-weight-bold mb-2">Buyer workspace</p>
                        <h1 class="display-4 text-white font-weight-bold mb-3">Create a profile for saved homes and viewing requests.</h1>
                        <p class="lead mb-0">This demo shows both sides of the workflow: public property browsing and admin-side request management.</p>
                    </div>
                </section>

                <section class="col-lg-6 auth-panel">
                    <div class="auth-card">
                        <a href="{{ route('home') }}" class="text-decoration-none font-weight-bold text-muted">
                            <i class="fas fa-arrow-left mr-2"></i>Back to listings
                        </a>
                        <div class="mt-4 mb-4">
                            <p class="text-uppercase text-muted font-weight-bold mb-2">Get started</p>
                            <h1>Create your account</h1>
                            <p class="text-muted mb-0">Use this account to save properties and send viewing requests.</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="font-weight-bold">Full name</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="font-weight-bold">Email address</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" class="font-weight-bold">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="font-weight-bold">Confirm password</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <button type="submit" class="btn btn-success btn-block py-3 font-weight-bold">
                                <i class="fas fa-user-plus mr-2"></i>Create account
                            </button>
                        </form>

                        <p class="text-center text-muted mt-4 mb-0">
                            Already registered? <a href="{{ route('login') }}" class="font-weight-bold">Login instead</a>
                        </p>
                    </div>
                </section>
            </div>
        </div>
    </main>
</body>
</html>
