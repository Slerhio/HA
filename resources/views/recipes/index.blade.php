@extends('layouts.app')

@section('title', 'Recipes')

@section('content')
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2>My recipes</h2>
            <a href="{{ route('recipes.create') }}" class="btn">Create new recipe</a>
        </div>
    </div>

    @if($recipes->isEmpty())
        <div class="card">
            <p>No recipes yet.</p>
        </div>
    @else
        <ul class="recipe-list">
            @foreach($recipes as $recipe)
                <li>
                    <div class="card">
    <div style="display: flex; gap: 16px; align-items: flex-start;">
        @if($recipe->image_path)
            <div style="flex: 0 0 120px;">
                <img src="{{ asset('storage/' . $recipe->image_path) }}"
                     alt="{{ $recipe->title }}"
                     style="width: 120px; height: 80px; object-fit: cover; border-radius: 4px;">
            </div>
        @endif

        <div style="flex: 1;">
            <h2>
                <a href="{{ route('recipes.show', $recipe->id) }}">
                    {{ $recipe->title }}
                </a>
            </h2>

            @if($recipe->category)
                <div class="recipe-meta">
                    Category: {{ $recipe->category->name }}
                </div>
            @endif

            @if($recipe->description)
                <p>{{ $recipe->description }}</p>
            @endif
        </div>
    </div>
</div>
                </li>
            @endforeach
        </ul>
    @endif
@endsection