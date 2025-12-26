<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мои рецепты</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
</head>
<body>

<header>
    <div class="container">
        <h1>Мои рецепты</h1>
        <nav>
            <a href="{{ url('/') }}">На главную</a>
        </nav>
    </div>
</header>
<header>
    <div class="container">
        <h1>My recipes</h1>
        <nav>
            <a href="{{ url('/') }}">Home</a> |
            <a href="{{ route('recipes.create') }}">Create new recipe</a>
        </nav>
    </div>
</header>

<main>
    <div class="container">
        @if($recipes->isEmpty())
            <p>Пока нет ни одного рецепта.</p>
        @else
            <ul>
                @foreach($recipes as $recipe)
                    <li style="margin-bottom: 20px;">

                        <h2>
                        <a href="{{ route('recipes.show', $recipe->id) }}">
                            {{ $recipe->title }}
                        </a>
                        </h2>

                        @if(!empty($recipe->description))
                            <p>{{ $recipe->description }}</p>
                        @endif

                        <p>
                            @if($recipe->category ?? false)
                                Категория: <strong>{{ $recipe->category->name }}</strong><br>
                            @endif

                            @if($recipe->user ?? false)
                                Автор: <strong>{{ $recipe->user->name }}</strong><br>
                            @endif

                            @if($recipe->cooking_time)
                                Время приготовления: {{ $recipe->cooking_time }} мин<br>
                            @endif

                            @if($recipe->portions)
                                Порций: {{ $recipe->portions }}
                            @endif
                        </p>

                        {{-- Здесь потом можно сделать ссылку "Подробнее" --}}
                        {{-- <a href="{{ route('recipes.show', $recipe->id) }}">Подробнее</a> --}}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</main>

<footer>
    <div class="container">

    </div>
</footer>

</body>
</html>