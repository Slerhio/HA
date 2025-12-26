<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create recipe</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
</head>
<body>

<header>
    <div class="container">
        <h1>Create new recipe</h1>
        <nav>
            <a href="{{ route('recipes.index') }}">← Back to recipes</a>
        </nav>
    </div>
</header>

<main>
    <div class="container">

        {{-- сообщения об успехе --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- ошибки валидации --}}
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

        <form action="{{ route('recipes.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="title">Title*</label><br>
                <input type="text" name="title" id="title"
                       value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label><br>
                <textarea name="description" id="description" rows="4">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="category_id">Category*</label><br>
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
                <label for="cooking_time">Cooking time (minutes)</label><br>
                <input type="number" name="cooking_time" id="cooking_time"
                       value="{{ old('cooking_time') }}" min="0">
            </div>

            <div class="form-group">
                <label for="portions">Portions</label><br>
                <input type="number" name="portions" id="portions"
                       value="{{ old('portions') }}" min="1">
            </div>

            <div class="form-group" style="margin-top: 15px;">
                <button type="submit">Save recipe</button>
            </div>
        </form>
    </div>
</main>

<footer>
    <div class="container">
        
    </div>
</footer>

</body>
</html>