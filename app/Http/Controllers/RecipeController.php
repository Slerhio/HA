<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
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

        return redirect()
        ->route('recipes.show', $recipe->id)
        ->with('success','Recipe created successfully!');
    }
}