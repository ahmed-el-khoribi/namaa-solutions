<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home | Namaa</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Nama Solutions Portal
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                            <li><a class="nav-link" href="{{ route('dashboard.home') }}">Dashboard</a></li>
                            @can('users_view')
                                <li><a class="nav-link" href="{{ route('portal.users.index') }}">Manage Users</a></li>
                            @endcan
                            @can('roles_view')
                                <li><a class="nav-link" href="{{ route('portal.roles.index') }}">Manage Role</a></li>
                            @endcan
                            @can('articles_view')
                                <li><a class="nav-link" href="{{ route('portal.articles.index') }}">Manage Articles</a></li>
                            @endcan
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">Latest Articles</h1>
                </div>
            </div>
        </section>
        <div class="album py-5 bg-light">
            <div class="container">

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    @foreach($data as $article)
                    <div class="col">
                        <div class="card shadow-sm">
                            <img src="{{ $article->image_thumb }}" class="img-thumbnail">

                            <div class="card-body">
                                <h3>{{ $article->title }}
                                <p class="card-text">
                                    {{$article->brief}}
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="{{ route('public.articles.show', [ 'id' => $article->id ]) }}">
                                            <button type="button" class="btn btn-sm btn-outline-secondary">Read More</button>
                                        </a>
                                    </div>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($article->published_at)->format('d M Y') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    {!! $data->render() !!}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
