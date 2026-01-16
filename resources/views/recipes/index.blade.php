@extends('layouts.app')

@section('title', 'Recipes')

@section('content')
    <div class="card">
        <h2>Recipes</h2>

        <form action="{{ route('recipes.index') }}" method="GET"
            style="display:flex; flex-wrap:wrap; gap: 10px; align-items:flex-end;">

            <div class="form-group">
                <label for="q">Search</label>
                <input type="text" name="q" id="q" value="{{ $filters['q'] ?? '' }}" placeholder="Enter recipe name">
            </div>

            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id">
                    <option value="">All</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if(($filters['category_id'] ?? '') == $category->id) selected @endif>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="display:flex; gap:6px; align-items:center; margin-top: 18px;">
                <input type="checkbox" name="only_favorites" id="only_favorites" value="1"
                    @if(!empty($filters['only_favorites'])) checked @endif>
                <label for="only_favorites">Only favorites</label>
            </div>

            <div class="form-group">
                <button type="submit" class="btn">
                    Apply filters
                </button>
            </div>

            @if(!empty($filters['q']) || !empty($filters['category_id']) || !empty($filters['only_favorites']))
                <div class="form-group">
                    <a href="{{ route('recipes.index') }}" class="btn btn-outline">
                        Reset
                    </a>
                </div>
            @endif
        </form>
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