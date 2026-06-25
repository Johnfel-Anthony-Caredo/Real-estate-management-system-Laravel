<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white admin-shell-sidebar" id="sidenav-main">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand py-3 d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
            <span class="brand-mark"><i class="fas fa-home"></i></span>
            <span class="brand-copy ml-2">EstateOS</span>
        </a>

        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-8 collapse-brand">
                        <a href="{{ route('admin.dashboard') }}">EstateOS</a>
                    </div>
                    <div class="col-4 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>

            <h6 class="navbar-heading text-muted">Workspace</h6>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="ni ni-tv-2 text-primary"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.admins') ? 'active' : '' }}" href="{{ route('admin.admins') }}">
                        <i class="fas fa-user-cog text-primary"></i> Admins
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                        <i class="fas fa-users text-primary"></i> Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.properties') ? 'active' : '' }}" href="{{ route('admin.properties') }}">
                        <i class="fas fa-building text-primary"></i> Properties
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.hometypes*') ? 'active' : '' }}" href="{{ route('admin.hometypes') }}">
                        <i class="fas fa-home text-primary"></i> Home Types
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.requests') ? 'active' : '' }}" href="{{ route('admin.requests') }}">
                        <i class="ni ni-send text-primary"></i> Requests
                    </a>
                </li>
            </ul>

            <hr class="my-3">
            <h6 class="navbar-heading text-muted">Database Audit</h6>
            <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.logs') ? 'active' : '' }}" href="{{ route('user.logs') }}">
                        <i class="fas fa-clipboard-list"></i> User Logs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.logs') ? 'active' : '' }}" href="{{ route('admin.logs') }}">
                        <i class="fas fa-clipboard"></i> Admin Logs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('prop.logs') ? 'active' : '' }}" href="{{ route('prop.logs') }}">
                        <i class="fas fa-file-alt"></i> Property Logs
                    </a>
                </li>
            </ul>

            <hr class="my-3">
            <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="fas fa-external-link-alt text-muted"></i> Public Site
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                        <i class="fas fa-sign-out-alt text-danger"></i> Log Out
                    </a>
                    <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
