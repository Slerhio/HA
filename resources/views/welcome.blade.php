<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Recipe App</title>

    {{-- Подключишь свой CSS сюда --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
</head>
<body>

<header class="site-header">
    <div class="container">
        <h1 class="logo">
            <a href="{{ url('/') }}">Recipe App</a>
        </h1>

        <nav class="main-nav">
            <ul>
                @auth
                    <li><a href="{{ url('/recipes') }}">Мои рецепты</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit">Exit</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ url('/login') }}">Log in</a></li>
                    <li><a href="{{ url('/register') }}">Create account</a></li>
                @endauth
            </ul>
        </nav>
    </div>
</header>

<main class="page-content">
    <div class="container">

        <section class="hero">
            <h2>Welcome to recepie</h2>
            <p>
                Here you can create your recepies and edit it.
            </p>

            @auth
                <p>You login as <strong>{{ auth()->user()->name }}</strong>.</p>
                <a href="{{ url('/recipes') }}" class="btn">To recepies</a>
            @else
                <p>
                    To start, create your account
                </p>
                <div class="hero-actions">
                    <a href="{{ url('/login') }}" class="btn">Login</a>
                    <a href="{{ url('/register') }}" class="btn btn-outline">Create account</a>
                </div>
            @endauth
        </section>

        <section class="features">
            <h3>What you can do?</h3>
            <ul>
                <li>Create and edit yours recepies</li>
                <li>Указывать ингредиенты и их количество</li>
                <li>Добавлять пошаговые инструкции</li>
                <li>Группировать рецепты по категориям</li>
            </ul>
        </section>

    </div>
</main>

<footer class="site-footer">
    <div class="container">
        
    </div>
</footer>

</body>
</html>
