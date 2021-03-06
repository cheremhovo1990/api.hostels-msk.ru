<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{mix('css/app.css', '/build')}}">

    <title>Hello, world!</title>
    <style>
        @section('style')
            div.required label:after {
            content: " *";
            color: red;
        }
        @show
    </style>
</head>
<body>
<div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Directory
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{route('cp.cities.index')}}">Cities</a>
                        <a class="dropdown-item" href="{{route('cp.organizations.index')}}">Organizations</a>
                        <a class="dropdown-item" href="{{route('cp.stations.index')}}">Metro</a>
                        <a class="dropdown-item" href="{{route('cp.lodges.index')}}">Lodges</a>
                        <a class="dropdown-item" href="{{route('cp.meta.index')}}">Meta</a>
                        <a class="dropdown-item" href="{{route('cp.details.index')}}">Detail</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="row">
        @yield('content')
    </div>
</div>
@section('script')
    <script src="{{mix('js/app.js', '/build')}}"></script>
@show

</body>
</html>
