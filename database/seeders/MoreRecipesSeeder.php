<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Step;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MoreRecipesSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            $user = User::create([
                'name'         => 'John',
                'surname'      => 'Smith',
                'email'        => 'john@example.com',
                'phone_number' => '12345678',
                'password'     => Hash::make('password'),
                'role'         => 'user',
            ]);
        }

        $categories = [
            'Breakfast',
            'Lunch',
            'Dinner',
            'Dessert',
            'Salad',
        ];

        $categoryIds = [];

        foreach ($categories as $catName) {
            $cat = Category::firstOrCreate(['name' => $catName]);
            $categoryIds[$catName] = $cat->id;
        }

        $recipesData = [
            [
                'title'        => 'Classic Pancakes',
                'category'     => 'Breakfast',
                'description'  => 'Fluffy classic pancakes for a perfect morning.',
                'cooking_time' => 20,
                'portions'     => 2,
                'ingredients'  => [
                    ['name' => 'Flour',        'quantity' => '150 g'],
                    ['name' => 'Milk',         'quantity' => '200 ml'],
                    ['name' => 'Eggs',         'quantity' => '2 pcs'],
                    ['name' => 'Baking powder','quantity' => '1 tsp'],
                    ['name' => 'Sugar',        'quantity' => '1 tbsp'],
                ],
                'steps' => [
                    'Mix flour, baking powder and sugar in a bowl.',
                    'Add eggs and milk, then whisk until smooth.',
                    'Heat a pan and cook small portions of batter on both sides until golden.',
                ],
            ],
            [
                'title'        => 'Chicken Caesar Salad',
                'category'     => 'Salad',
                'description'  => 'Crispy lettuce with grilled chicken, croutons and Caesar dressing.',
                'cooking_time' => 25,
                'portions'     => 2,
                'ingredients'  => [
                    ['name' => 'Romaine lettuce', 'quantity' => '1 head'],
                    ['name' => 'Chicken breast',  'quantity' => '200 g'],
                    ['name' => 'Croutons',        'quantity' => '50 g'],
                    ['name' => 'Parmesan',        'quantity' => '30 g'],
                    ['name' => 'Caesar dressing', 'quantity' => '3 tbsp'],
                ],
                'steps' => [
                    'Grill or pan-fry the chicken breast and slice it.',
                    'Wash and chop the romaine lettuce.',
                    'Combine lettuce, chicken, croutons and parmesan in a bowl.',
                    'Add Caesar dressing, toss gently and serve.',
                ],
            ],
            [
                'title'        => 'Spaghetti Bolognese',
                'category'     => 'Dinner',
                'description'  => 'Classic spaghetti with rich meat tomato sauce.',
                'cooking_time' => 40,
                'portions'     => 3,
                'ingredients'  => [
                    ['name' => 'Spaghetti',      'quantity' => '250 g'],
                    ['name' => 'Ground beef',    'quantity' => '250 g'],
                    ['name' => 'Tomato sauce',   'quantity' => '300 ml'],
                    ['name' => 'Onion',          'quantity' => '1 pc'],
                    ['name' => 'Garlic',         'quantity' => '2 cloves'],
                ],
                'steps' => [
                    'Cook spaghetti according to package instructions.',
                    'Sauté chopped onion and garlic, then add ground beef and cook until browned.',
                    'Pour in tomato sauce, simmer for 15–20 minutes.',
                    'Serve the sauce over spaghetti.',
                ],
            ],
            [
                'title'        => 'Tomato Cream Soup',
                'category'     => 'Lunch',
                'description'  => 'Smooth and creamy tomato soup, perfect for a light lunch.',
                'cooking_time' => 30,
                'portions'     => 2,
                'ingredients'  => [
                    ['name' => 'Tomato puree', 'quantity' => '400 g'],
                    ['name' => 'Vegetable broth','quantity' => '300 ml'],
                    ['name' => 'Cream',         'quantity' => '100 ml'],
                    ['name' => 'Onion',         'quantity' => '1 pc'],
                    ['name' => 'Olive oil',     'quantity' => '1 tbsp'],
                ],
                'steps' => [
                    'Sauté chopped onion in olive oil until soft.',
                    'Add tomato puree and vegetable broth, bring to a boil.',
                    'Lower the heat and simmer for 10–15 minutes.',
                    'Stir in the cream, blend until smooth and serve.',
                ],
            ],
            [
                'title'        => 'Chocolate Brownies',
                'category'     => 'Dessert',
                'description'  => 'Rich and fudgy chocolate brownies.',
                'cooking_time' => 35,
                'portions'     => 4,
                'ingredients'  => [
                    ['name' => 'Dark chocolate', 'quantity' => '150 g'],
                    ['name' => 'Butter',         'quantity' => '100 g'],
                    ['name' => 'Sugar',          'quantity' => '150 g'],
                    ['name' => 'Eggs',           'quantity' => '2 pcs'],
                    ['name' => 'Flour',          'quantity' => '80 g'],
                ],
                'steps' => [
                    'Melt chocolate and butter together.',
                    'Whisk in sugar and eggs.',
                    'Fold in flour and mix until combined.',
                    'Pour into a baking tin and bake at 180°C for about 20–25 minutes.',
                ],
            ],
            [
                'title'        => 'Greek Salad',
                'category'     => 'Salad',
                'description'  => 'Fresh salad with tomatoes, cucumbers, olives and feta.',
                'cooking_time' => 15,
                'portions'     => 2,
                'ingredients'  => [
                    ['name' => 'Tomatoes',     'quantity' => '2 pcs'],
                    ['name' => 'Cucumber',     'quantity' => '1 pc'],
                    ['name' => 'Red onion',    'quantity' => '1/2 pc'],
                    ['name' => 'Feta cheese',  'quantity' => '80 g'],
                    ['name' => 'Olives',       'quantity' => '10 pcs'],
                ],
                'steps' => [
                    'Chop tomatoes, cucumber and red onion.',
                    'Cut feta cheese into cubes.',
                    'Mix all vegetables and olives in a bowl.',
                    'Top with feta and drizzle with olive oil if desired.',
                ],
            ],
        ];

        foreach ($recipesData as $data) {
            $recipe = Recipe::create([
                'user_id'      => $user->id,
                'category_id'  => $categoryIds[$data['category']] ?? $categoryIds['Dinner'],
                'title'        => $data['title'],
                'description'  => $data['description'],
                'cooking_time' => $data['cooking_time'],
                'portions'     => $data['portions'],
                'image_path'   => null,
            ]);

            foreach ($data['ingredients'] as $ing) {
                Ingredient::create([
                    'recipe_id' => $recipe->id,
                    'name'      => $ing['name'],
                    'quantity'  => $ing['quantity'],
                ]);
            }

            $stepNumber = 1;
            foreach ($data['steps'] as $desc) {
                Step::create([
                    'recipe_id'   => $recipe->id,
                    'step_number' => $stepNumber++,
                    'description' => $desc,
                ]);
            }
        }
    }
}
