<!doctype html>
<html lang="en-gb" class="no-js">
<head>
    <title>{{ $_web->title }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="author" content="{{ $_web->seo_author }}">
    <meta name="keywords" content="{{ $_web->seo_keyword }}" />
    <meta name="description" content="{{ $_web->seo_description }}" />
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" id="base-url" content="{{ config('app.url') }}">
    <meta name="base-router" content="{{ config('app.base_router') }}">
    <link rel="shortcut icon" href="{{ $_web->favicon }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if(config('app.env') != 'local')
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900' rel='stylesheet' type='text/css'>
    @endif
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/metro.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/metro-schemes.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/metro-colors.css')) }}">
    <link rel="stylesheet" href="{{ asset('metro/css/metro-responsive.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/summernote/dist/summernote-lite.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/admin.css')) }}">
    <style>
    .wira-footer {
        background-image: url('{{ url('images/footer.png') }}');
        z-index: 3;
        color: white;
        padding: 2.5rem;
    }
</style>
</head>
<body>
    <div id="admin-app">
        <admin-app></admin-app>
    </div>
    <script src="{{ asset('vendors/js/jquery.min.js') }}"></script>
    <script src="{{ asset('vendors/js/jquery.dataTables.min.js') }}"></script>
    @if(config('app.env') != 'local')
    <script src="{{ asset(mix('js/manifest.js')) }}"></script>
    <script src="{{ asset(mix('js/vendor.js')) }}"></script>
    <script src="http://cdn.jsdelivr.net/npm/lodash@4.17.4/lodash.min.js"></script>
    @else
    <script src="{{ asset('js/lodash.min.js') }}"></script>
    @endif
    <script src="{{ asset('vendors/summernote/dist/summernote-lite.js') }}"></script>
    <script src="{{ asset(mix('vendors/js/metro.js')) }}"></script>
    <script src="{{ asset('dist/select2/select2.min.js') }}"></script>
    <script src="{{ asset(mix('js/admin.js')) }}"></script>
</body>
</html>