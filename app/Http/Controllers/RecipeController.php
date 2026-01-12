<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Step;
use Illuminate\Http\Request;


class RecipeController extends Controller
{
    public function index()
    {
        // Получаем все рецепты с пользователем и категорией (если связь есть)
        $recipes = Recipe::with(['user', 'category'])->get();

        return view('recipes.index', compact('recipes'));
        // то же самое, что: ['recipes' => $recipes]
    }

    public function show(Recipe $recipe)
    {
    $recipe->load(['user', 'category','ingredients', 'steps']);
    return view('recipes.show', compact('recipe'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('recipes.create', compact('categories'));
    }
    public function edit(Recipe $recipe)
    {
        $categories = Category::all();
        $recipe->load(['ingredients','steps']);
        return view('recipes.edit', compact('recipe','categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'cooking_time' => 'nullable|integer|min:0',
            'portions'     => 'nullable|integer|min:1',
            'category_id'  => 'required|exists:categories,id',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);   
        $validated['user_id'] = 1;

        if ($request->hasFile('image')) {
        // сохранит в storage/app/public/recipes
        $path = $request->file('image')->store('recipes', 'public');
        $validated['image_path'] = $path;
        }


        $recipe = Recipe::create($validated);

        // --- ИНГРЕДИЕНТЫ ---
    $ingredients = $request->input('ingredients', []);
    foreach ($ingredients as $item) {
        $name = trim($item['name'] ?? '');
        $quantity = trim($item['quantity'] ?? '');

        if ($name === '') {
            continue; // пропускаем пустые строки
        }

        Ingredient::create([
            'recipe_id'  => $recipe->id,
            'name'       => $name,
            'quantity'   => $quantity,
        ]);
    }

    // --- ШАГИ ---
    $steps = $request->input('steps', []);
    $stepNumber = 1;

    foreach ($steps as $item) {
        $description = trim($item['description'] ?? '');

        if ($description === '') {
            continue;
        }

        Step::create([
            'recipe_id'   => $recipe->id,
            'step_number' => $stepNumber++,
            'description' => $description,
        ]);
    }

        return redirect()
        ->route('recipes.show', $recipe->id)
        ->with('success','Recipe created successfully!');
    }


        public function update(Request $request, Recipe $recipe)
{
    $validated = $request->validate([
        'title'        => 'required|string|max:255',
        'description'  => 'nullable|string',
        'cooking_time' => 'nullable|integer|min:0',
        'portions'     => 'nullable|integer|min:1',
        'category_id'  => 'required|exists:categories,id',
        'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    // user_id не меняем (оставляем того же автора)
    $validated['user_id'] = $recipe->user_id ?? 1;

    // обработка картинки
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('recipes', 'public');
        $validated['image_path'] = $path;
    }

    // обновляем сам рецепт
    $recipe->update($validated);

    // ---------- ИНГРЕДИЕНТЫ ----------
    // сначала удаляем старые
    $recipe->ingredients()->delete();

    // потом создаём новые из формы
    $ingredients = $request->input('ingredients', []);

    foreach ($ingredients as $item) {
        $name = trim($item['name'] ?? '');
        $quantity = trim($item['quantity'] ?? '');

        if ($name === '') {
            continue;
        }

        Ingredient::create([
            'recipe_id'  => $recipe->id,
            'name'       => $name,
            'quantity'   => $quantity,
        ]);
    }

    // ---------- ШАГИ ----------
    $recipe->steps()->delete();

    $steps = $request->input('steps', []);
    $stepNumber = 1;

    foreach ($steps as $item) {
        $description = trim($item['description'] ?? '');

        if ($description === '') {
            continue;
        }

        Step::create([
            'recipe_id'   => $recipe->id,
            'step_number' => $stepNumber++,
            'description' => $description,
        ]);
    }

    return redirect()
        ->route('recipes.show', $recipe->id)
        ->with('success', 'Recipe updated successfully!');
}
    public function delete(Recipe $recipe)
    {
        $recipe->delete();
        return redirect()
        ->route('recipes.index')
        ->with('success', 'Recipe deleted successfully!');
    }
    public function discover()
    {
    $recipes = Recipe::with('category')->inRandomOrder()->take(20)->get();
    return view('recipes.discover', [
        'recipes' => $recipes,
    ]);
    }
}