@extends('layouts.app')

@section('title', 'My favorite recipes')

@section('content')
    <div class="card">
        <h2>My favorite recipes</h2>
    </div>

    @if($recipes->isEmpty())
        <div class="card">
            <p>You have no favorite recipes yet.</p>
        </div>
    @else
        <ul class="recipe-list">
            @foreach($recipes as $recipe)
                <li>
                    <div class="card">
                        <div style="display: flex; gap: 16px; align-items: flex-start;">
                            @if($recipe->image_path)
                                <div style="flex: 0 0 140px;">
                                    <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="{{ $recipe->title }}"
                                        class="recipe-thumb">
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