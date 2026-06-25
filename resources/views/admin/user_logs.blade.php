<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials._head') 
</head>
<body>
    <!-- Sidenav -->
    @include('partials._sidebar') 

    <!-- Main content -->
    <div class="main-content">
        <!-- Top navbar -->
        @include('partials._topnav') 

        <!-- Header -->
        <div style="background-image: url({{ asset('assets/img/theme/restro00.jpg') }}); background-size: cover;" class="header pb-8 pt-5 pt-md-8">
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

        <div class="container-fluid mt--7">
            <div class="row mt-5">
                <div class="col-xl-12 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">User Activity Logs</h3>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <!-- User logs table -->
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-success" scope="col"><b>ID</b></th>
                                        <th scope="col"><b>User ID</b></th>
                                        <th class="text-success" scope="col"><b>Operation</b></th>
                                        <th scope="col"><b>Changed Data</b></th>
                                        <th scope="col"><b>Performed At</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userLogs as $log)
                                        <tr>
                                            <th class="text-success" scope="row">{{ $log->id }}</th>
                                            <td>{{ $log->user_id }}</td>
                                            <td class="text-warning ">{{ $log->operation }}</td>
                                            <td>{{ $log->changed_data }}</td>
                                            <td>{{ $log->performed_at->format('d/M/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        <div class="card-footer py-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    Showing {{ $userLogs->count() }} entries
                                </div>
                                {{ $userLogs->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            @include('partials._footer') 
        </div>
    </div>

    @include('partials._scripts') 
</body>
</html>