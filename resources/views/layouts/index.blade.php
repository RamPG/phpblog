<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <!-- Custom styles for this template -->

</head>

<body>
@include('layouts.navbar')
<div class="container">
    <div class="row">
        @yield('posts')
        @include('layouts.sidebar')
    </div>
</div>
<script src="{{ asset('js/index.js') }}"></script>

</body>

</html>
