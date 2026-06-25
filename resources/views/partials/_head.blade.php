<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>EstateOS | Real Estate Management</title>

<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
<link href="{{ asset('assets/vendor/nucleo/css/nucleo.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
<link type="text/css" href="{{ asset('assets/css/argon.css?v=1.0.0') }}" rel="stylesheet">
<link type="text/css" href="{{ asset('assets/css/showcase.css') }}" rel="stylesheet">

<script src="{{ asset('assets/js/swal.js') }}"></script>
@if (session('success'))
    <script>
        setTimeout(function() {
            swal("Success", "{{ session('success') }}", "success");
        }, 100);
    </script>
@endif

@if (session('err') || session('error'))
    <script>
        setTimeout(function() {
            swal("Failed", "{{ session('err') ?? session('error') }}", "error");
        }, 100);
    </script>
@endif

@if (session('info'))
    <script>
        setTimeout(function() {
            swal("Info", "{{ session('info') }}", "info");
        }, 100);
    </script>
@endif
