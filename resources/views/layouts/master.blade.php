<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title')
    </title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.htgstatic.com">
    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="{{url('/assets/css/toastr.min.css')}}" rel="stylesheet">

</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                Data Team Tool
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <a class="nav-link" href="{{route('post.edit', ['id' => 1])}}">Sửa câu hỏi đáp</a>
                    <a class="nav-link" href="{{route('post.edit_label', ['id' => 1])}}">Gán nhãn câu hỏi đáp</a>
                    <a class="nav-link" href="{{route('post.create')}}">Tạo câu hỏi đáp</a>
                </ul>

            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>

</body>
<script src="{{url('/assets/js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
<script src="{{url('/assets/js/jquery-ui-1.12.1.custom.min.js')}}" type="text/javascript"></script>
<script src="{{url('/assets/js/tether.min.js')}}" type="text/javascript"></script>
<script src="{{url('/assets/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{url('/assets/js/axios.min.js')}}"></script>
<script src="{{url('/assets/js/toastr.min.js')}}"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-MML-AM_CHTML' async></script>

@stack('scripts')
</html>
