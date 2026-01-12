@extends('layouts.app')

@section('title', $recipe->title)

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>{{ $recipe->title }}</h2>

        <div>
            <a href="{{ route('recipes.edit', $recipe->id) }}" class="btn btn-outline" style="margin-right: 8px;">
                Edit
            </a>

            <form action="{{ route('recipes.delete', $recipe->id) }}"
                  method="POST"
                  style="display:inline"
                  onsubmit="return confirm('Are you sure you want to delete this recipe?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn">
                    Delete
                </button>
            </form>
        </div>
    </div>
    <div class="card">
        <h2>{{ $recipe->title }}</h2>

        @if($recipe->image_path)
            <div style="margin: 10px 0;">
                <img src="{{ asset('storage/' . $recipe->image_path) }}"
                    alt="{{ $recipe->title }}"
                    style="max-width: 100%; border-radius: 6px;">
            </div>
        @endif


        <div class="recipe-meta">
            @if($recipe->category)
                Category: <strong>{{ $recipe->category->name }}</strong><br>
            @endif

            @if($recipe->user)
                Author: <strong>{{ $recipe->user->name }}</strong><br>
            @endif

            @if($recipe->cooking_time)
                Cooking time: {{ $recipe->cooking_time }} min<br>
            @endif

            @if($recipe->portions)
                Portions: {{ $recipe->portions }}
            @endif
        </div>

        @if($recipe->description)
            <p>{{ $recipe->description }}</p>
        @endif
    </div>

    <div class="card recipe-section">
        <h3>Ingredients</h3>

        @if($recipe->ingredients->isEmpty())
            <p>No ingredients.</p>
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

    <div class="card recipe-section">
        <h3>Steps</h3>

        @if($recipe->steps->isEmpty())
            <p>No steps yet.</p>
        @else
            <ol>
                @foreach($recipe->steps->sortBy('step_number') as $step)
                    <li>{{ $step->description }}</li>
                @endforeach
            </ol>
        @endif
    </div>
@endsection