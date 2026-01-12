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

            {{-- ===== INGREDIENTS ===== --}}
            @php
                // Берём либо старые значения (если была ошибка валидации), либо текущие
                $oldIngredients = old('ingredients', $recipe->ingredients->toArray());
                $maxIngredients = max(count($oldIngredients), 5);
            @endphp

            <div class="form-group">
                <h3>Ingredients</h3>
                <p style="font-size: 13px; color:#666;">Edit existing or leave extra rows empty.</p>

                @for ($i = 0; $i < $maxIngredients; $i++)
                    @php
                        $ingName = $oldIngredients[$i]['name'] ?? '';
                        $ingQty  = $oldIngredients[$i]['quantity'] ?? '';
                    @endphp
                    <div style="display: flex; gap: 8px; margin-bottom: 6px;">
                        <input
                            type="text"
                            name="ingredients[{{ $i }}][name]"
                            placeholder="Ingredient name"
                            style="flex: 2;"
                            value="{{ $ingName }}"
                        >
                        <input
                            type="text"
                            name="ingredients[{{ $i }}][quantity]"
                            placeholder="Quantity"
                            style="flex: 1;"
                            value="{{ $ingQty }}"
                        >
                    </div>
                @endfor
            </div>

            {{-- ===== STEPS ===== --}}
            @php
                $sortedSteps = $recipe->steps->sortBy('step_number')->values();
                $oldSteps = old('steps', $sortedSteps->toArray());
                $maxSteps = max(count($oldSteps), 5);
            @endphp

            <div class="form-group">
                <h3>Steps</h3>
                <p style="font-size: 13px; color:#666;">Edit steps or leave empty rows.</p>

                @for ($i = 0; $i < $maxSteps; $i++)
                    @php
                        $stepDesc = $oldSteps[$i]['description'] ?? '';
                    @endphp
                    <div style="margin-bottom: 6px;">
                        <label style="font-size: 13px;">Step {{ $i + 1 }}</label>
                        <textarea
                            name="steps[{{ $i }}][description]"
                            rows="2"
                            placeholder="Describe this step"
                        >{{ $stepDesc }}</textarea>
                    </div>
                @endfor
            </div>

            <button type="submit" class="btn" style="margin-top: 8px;">
                Save changes
            </button>
        </form>
    </div>
@endsection
