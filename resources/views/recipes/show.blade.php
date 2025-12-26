<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>{{ $recipe->title }} – Recipe App</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
</head>
<body>

<header>
    <div class="container">
        <h1>{{ $recipe->title }}</h1>
        <nav>
            <a href="{{ route('recipes.index') }}">← Назад к списку</a>
            |
            <a href="{{ url('/') }}">На главную</a>
        </nav>
    </div>
</header>

<main>
    <div class="container">

        <section class="recipe-info">
            @if($recipe->category)
                <p>Категория: <strong>{{ $recipe->category->name }}</strong></p>
            @endif

            @if($recipe->user)
                <p>Автор: <strong>{{ $recipe->user->name }}</strong></p>
            @endif

            @if($recipe->cooking_time)
                <p>Время приготовления: {{ $recipe->cooking_time }} мин</p>
            @endif

            @if($recipe->portions)
                <p>Порций: {{ $recipe->portions }}</p>
            @endif

            @if($recipe->description)
                <h3>Описание</h3>
                <p>{{ $recipe->description }}</p>
            @endif
        </section>

        <section class="recipe-ingredients">
            <h3>Ингредиенты</h3>

            @if($recipe->ingredients->isEmpty())
                <p>Ингредиенты не указаны.</p>
            @else
                <ul>
                    @foreach($recipe->ingredients as $ingredient)
                        <li>
                            {{ $ingredient->name }}
                            @if($ingredient->quantity)
                                – {{ $ingredient->quantity }}
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <section class="recipe-steps">
            <h3>Шаги приготовления</h3>

            @if($recipe->steps->isEmpty())
                <p>Шаги ещё не добавлены.</p>
            @else
                <ol>
                    @foreach($recipe->steps->sortBy('step_number') as $step)
                        <li>
                            {{ $step->description }}
                        </li>
                    @endforeach
                </ol>
            @endif
        </section>

    </div>
</main>

<footer>
    <div class="container">
        
    </div>
</footer>

</body>
</html>