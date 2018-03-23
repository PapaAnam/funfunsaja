<!doctype html>
<html lang="en-gb" class="no-js">
<head>
    <title>{{ $title }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="author" content="{{ $_web->seo_author }}">
    <meta name="keywords" content="{{ $_web->seo_keyword }}" />
    <meta name="description" content="{{ $_web->seo_description }}" />
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" id="base-url" content="{{ config('app.url') }}">
    <link rel="shortcut icon" href="{{ $_web->favicon }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @if(config('app.env') != 'local')
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900' rel='stylesheet' type='text/css'>
    @endif
    <link rel="stylesheet" href="{{ asset('vendors/css/font-awesome.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('vendors/css/animate.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('vendors/css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/metro-without-grid.css')) }}">
    {{-- <link rel="stylesheet" href="{{ asset('metro/css/metro.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/metro-schemes.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/metro-colors.css')) }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/bootstrap.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/my-bootstrap.css')) }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('vendors/css/select2.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('vendors/summernote/dist/summernote-bs4.css') }}"> --}}
    @stack('css')
    <link rel="stylesheet" href="{{ asset(mix('css/my-style.css')) }}">
    @stack('style')
</head>
<body>
    <div class="wrapper_boxed">
        @include('layouts.header')
        <div id="app" class="ctn">
            <div class="clearfix" id="pembatas"></div>
            @yield('content')
            <br>
            <br>
            @include('layouts.footer')
        </div>
    </div>
    <script src="{{ asset('vendors/js/jquery.min.js') }}"></script>
    <script src="{{ asset('vendors/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('vendors/js/jquery.easing.min.js') }}"></script>
    @if(config('app.env') == 'production')
    <script src="{{ asset(mix('js/manifest.js')) }}"></script>
    <script src="{{ asset(mix('js/vendor.js')) }}"></script>
    @endif
    <script src="{{ asset('vendors/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset(mix('vendors/js/metro.js')) }}"></script>
    {{-- <script src="{{ asset('metro/js/metro.min.js') }}"></script> --}}
    <script src="{{ asset('vendors/js/animations.js') }}"></script>
    {{-- <script src="{{ asset('vendors/js/notify.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('vendors/js/jquery.dataTables.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('vendors/js/my-inputmask.js') }}"></script> --}}
    {{-- <script src="{{ asset('vendors/js/jquery.flexslider.js') }}"></script> --}}
    {{-- <script src="{{ asset('vendors/summernote/dist/summernote-bs4.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('vendors/js/select2.min.js') }}"></script> --}}
    @stack('js')
    <script src="{{ asset(mix('js/wiranusa.js')) }}"></script>
    @stack('script')
    <script>
        // alert($(window).width())
    </script>
</body>
</html>