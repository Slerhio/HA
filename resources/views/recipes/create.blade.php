@extends('layouts.app')

@section('title', 'Create recipe')

@section('content')
    <div class="card">
        <h2>Create new recipe</h2>

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

        <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="title">Title*</label>
                <input type="text" name="title" id="title"
                       value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="4">{{ old('description') }}</textarea>
            </div>
            
            <div class="form-group">
                <label for="image">Image (optional)</label>
                <input type="file" name="image" id="image" accept="image/*">
            </div>

            <div class="form-group">
                <label for="category_id">Category*</label>
                <select name="category_id" id="category_id" required>
                    <option value="">-- Select category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            @selected(old('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="cooking_time">Cooking time (minutes)</label>
                <input type="number" name="cooking_time" id="cooking_time"
                       value="{{ old('cooking_time') }}" min="0">
            </div>

            <div class="form-group">
                <label for="portions">Portions</label>
                <input type="number" name="portions" id="portions"
                       value="{{ old('portions') }}" min="1">
            </div>

            <button type="submit" class="btn" style="margin-top: 8px;">
                Save recipe
            </button>
        </form>
    </div>
@endsection