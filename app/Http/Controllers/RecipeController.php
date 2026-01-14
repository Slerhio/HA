<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Favorite;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Step;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ResponseEvent;


class RecipeController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $userId = 1;
        $query = Recipe::with(['user','category']);

        if ($request->filled('category_id'))
            {
                $query->where('category_id', $request->input('category_id'));
            }

        if ($request->filled('q'))
            {
                $search = $request->input('q');
                $query->where('title', 'like', '%'.$search.'%');
            }

        if($request->boolean('only_favorites'))
        {
        $favoriteId = Favorite::where('user_id', $userId)->pluck('recipe_id');
        $query->whereIn('id', $favoriteId);
        }
        $recipes = $query->get();
        $categories = Category::all();
        
        return view('recipes.index', 
        [
        'recipes'    => $recipes,
        'categories' => $categories,
        'filters'    => $request->only(['category_id', 'q', 'only_favorites']),
        ]);
    }

    public function show(Recipe $recipe)
    {
     $recipe->load(['user', 'category', 'ingredients', 'steps']);

    $userId = 1;

    $isFavorite = Favorite::where('user_id', $userId)
        ->where('recipe_id', $recipe->id)
        ->exists();

    return view('recipes.show', [
        'recipe'     => $recipe,
        'isFavorite' => $isFavorite,
    ]);
    //return view('recipes.show', compact('recipe'));
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
        $path = $request->file('image')->store('recipes', 'public');
        $validated['image_path'] = $path;
        }


        $recipe = Recipe::create($validated);


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

    $validated['user_id'] = $recipe->user_id ?? 1;

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('recipes', 'public');
        $validated['image_path'] = $path;
    }

    $recipe->update($validated);
    $recipe->ingredients()->delete();
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
        $recipes = Recipe::with('category')->get();

        return view('recipes.discover', compact('recipes'));
    }

    public function favorites()
    {
        $userId = 1;
        $favorites = Favorite::with('recipe.category')
        ->where('user_id', $userId)
        ->get()
        ->pluck('recipe')
        ->filter();
        return view('recipes.favorites',[
            'recipes' => $favorites,
        ]);
    }
    public function favorite(Request $request, Recipe $recipe)
    {
        $userId = 1; // временный пользователь

        Favorite::firstOrCreate([
            'user_id'   => $userId,
            'recipe_id' => $recipe->id,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['status' => 'ok']);
        }
        return back()->with('success', 'Recipe added to favorites!');
    }

    public function unfavorite(Request $request, Recipe $recipe)
    {
        $userId = 1;

        Favorite::where('user_id', $userId)
            ->where('recipe_id', $recipe->id)
            ->delete();

        if ($request->expectsJson()) {
            return response()->json(['status' => 'ok']);
        }

        return back()->with('success', 'Recipe removed from favorites!');
    }
}