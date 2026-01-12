@extends('layouts.app')

@section('title', 'Edit recipe')

@section('content')
    <div class="card">
        <h2>Edit recipe</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>There were some problems with your input:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title*</label>
                <input type="text" name="title" id="title"
                       value="{{ old('title', $recipe->title) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="4">{{ old('description', $recipe->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="category_id">Category*</label>
                <select name="category_id" id="category_id" required>
                    <option value="">-- Select category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            @selected(old('category_id', $recipe->category_id) == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="cooking_time">Cooking time (minutes)</label>
                <input type="number" name="cooking_time" id="cooking_time"
                       value="{{ old('cooking_time', $recipe->cooking_time) }}" min="0">
            </div>

            <div class="form-group">
                <label for="portions">Portions</label>
                <input type="number" name="portions" id="portions"
                       value="{{ old('portions', $recipe->portions) }}" min="1">
            </div>

            <div class="form-group">
                <label for="image">Image (optional)</label>
                @if($recipe->image_path)
                    <div style="margin-bottom: 8px;">
                        <img src="{{ asset('storage/' . $recipe->image_path) }}"
                             alt="{{ $recipe->title }}"
                             style="max-width: 200px; border-radius: 4px;">
                    </div>
                @endif
                <input type="file" name="image" id="image" accept="image/*">
            </div>

            <button type="submit" class="btn" style="margin-top: 8px;">
                Save changes
            </button>
        </form>
    </div>
@endsection
