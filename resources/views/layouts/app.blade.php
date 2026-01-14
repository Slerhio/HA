<!DOCTYPE html>
<html lang="en">
<head>
    <head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Recipe App')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<header class="site-header">
    <div class="container header-inner">
        <h1 class="logo">
            <a href="{{ url('/') }}">Recipe App</a>
        </h1>

        <nav class="main-nav">
            <a href="{{ route('recipes.index') }}">Recipes</a>
            <a href="{{ route('recipes.create') }}">Create</a>
            <a href="{{ route('recipes.favorites') }}">Favorites</a>
            <a href="{{ route('recipes.discover') }}" class="btn btn-outline">What do I want today?</a>
        </nav>
    </div>
</header>

<main class="page-content">
    <div class="container">
        @yield('content')
    </div>
</main>

<footer class="site-footer">
    <div class="container">
        <p>&copy; {{ date('Y') }} Recipe App</p>
    </div>
</footer>

</body>
</html>