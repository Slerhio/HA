@extends('layouts.app')

@section('title', $recipe->title)

@section('content')
@if(session('api_warning'))
    <div class="api-warning">
        <strong>Note:</strong><br>
        {{ session('api_warning') }}
    </div>
@endif
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2>{{ $recipe->title }}</h2>


            <div style="display: flex; gap: 8px; align-items: center;">
                @if($isFavorite)
                    <form action="{{ route('recipes.unfavorite', $recipe->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline">
                            ★ In favorites
                        </button>
                    </form>
                @else
                    <form action="{{ route('recipes.favorite', $recipe->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline">
                            ☆ Add to favorites
                        </button>
                    </form>
                @endif

                <a href="{{ route('recipes.edit', $recipe->id) }}" class="btn btn-outline">
                    Edit
                </a>

                <form action="{{ route('recipes.delete', $recipe->id) }}" method="POST" style="display:inline"
                    onsubmit="return confirm('Are you sure you want to delete this recipe?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn">
                        Delete
                    </button>
                </form>
            </div>
        </div>
        <div class="recipe-meta" style="margin-top: 8px;">
            @if($recipe->category)
                Category: {{ $recipe->category->name }}
            @endif

            @if($recipe->user)
                @if($recipe->category) | @endif
                Author: {{ $recipe->user->name }} {{ $recipe->user->surname }}
            @endif
        </div>

        @if($recipe->image_path)
            <div style="margin: 16px 0;">
                <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="{{ $recipe->title }}" class="recipe-image-large">
            </div>
        @endif

        @if($recipe->description)
            <p>{{ $recipe->description }}</p>
        @endif

        <div class="recipe-meta" style="margin-top: 8px;">
            @if($recipe->cooking_time)
                Cooking time: {{ $recipe->cooking_time }} min
            @endif

            @if($recipe->portions)
                @if($recipe->cooking_time) | @endif
                Portions: {{ $recipe->portions }}
            @endif
        </div>
    </div>

    <div class="card">
        <h3>Ingredients</h3>
        @if($recipe->ingredients->isEmpty())
            <p>No ingredients specified.</p>
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
    </div>

    <div class="card">
        <h3>Steps</h3>
        @if($recipe->steps->isEmpty())
            <p>No steps specified.</p>
        @else
            <ol>
                @foreach($recipe->steps->sortBy('step_number') as $step)
                    <li>{{ $step->description }}</li>
                @endforeach
            </ol>
        @endif
    </div>
@endsection