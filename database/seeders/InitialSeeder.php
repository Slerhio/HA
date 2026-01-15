<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class InitialSeeder extends Seeder
{
     public function run(): void
    {

        $userId = DB::table('users')->insertGetId([
            'name'         => 'John',
            'surname'      => 'Smith',
            'email'        => 'john@example.com',
            'phone_number' => '12345678',
            'password'     => Hash::make('password'),
            'role'         => 'user',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);


        $breakfastId = DB::table('categories')->insertGetId([
            'name'       => 'Breakfast',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $dinnerId = DB::table('categories')->insertGetId([
            'name'       => 'Dinner',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $recipe1Id = DB::table('recipes')->insertGetId([
            'user_id'      => $userId,
            'category_id'  => $breakfastId,
            'title'        => 'Cheese Omelette',
            'description'  => 'Simple cheese omelette for a quick breakfast.',
            'cooking_time' => 10,
            'portions'     => 1,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('ingredients')->insert([
            [
                'recipe_id'  => $recipe1Id,
                'name'       => 'Eggs',
                'quantity'   => '2 pcs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'recipe_id'  => $recipe1Id,
                'name'       => 'Grated cheese',
                'quantity'   => '50 g',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'recipe_id'  => $recipe1Id,
                'name'       => 'Salt',
                'quantity'   => 'to taste',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('steps')->insert([
            [
                'recipe_id'   => $recipe1Id,
                'step_number' => 1,
                'description' => 'Crack the eggs into a bowl and whisk them.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'recipe_id'   => $recipe1Id,
                'step_number' => 2,
                'description' => 'Add grated cheese and salt, then mix well.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'recipe_id'   => $recipe1Id,
                'step_number' => 3,
                'description' => 'Pour the mixture into a hot pan and cook until set.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);

        $recipe2Id = DB::table('recipes')->insertGetId([
            'user_id'      => $userId,
            'category_id'  => $dinnerId,
            'title'        => 'Pasta with Tomato Sauce',
            'description'  => 'Light pasta with tomato sauce and garlic.',
            'cooking_time' => 25,
            'portions'     => 2,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('ingredients')->insert([
            [
                'recipe_id'  => $recipe2Id,
                'name'       => 'Spaghetti',
                'quantity'   => '200 g',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'recipe_id'  => $recipe2Id,
                'name'       => 'Tomato sauce',
                'quantity'   => '150 ml',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'recipe_id'  => $recipe2Id,
                'name'       => 'Garlic',
                'quantity'   => '2 cloves',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'recipe_id'  => $recipe2Id,
                'name'       => 'Olive oil',
                'quantity'   => '1 tbsp',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('steps')->insert([
            [
                'recipe_id'   => $recipe2Id,
                'step_number' => 1,
                'description' => 'Cook the spaghetti until al dente according to the package instructions.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'recipe_id'   => $recipe2Id,
                'step_number' => 2,
                'description' => 'Sauté finely chopped garlic in olive oil.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'recipe_id'   => $recipe2Id,
                'step_number' => 3,
                'description' => 'Add the tomato sauce and let it simmer for a few minutes.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'recipe_id'   => $recipe2Id,
                'step_number' => 4,
                'description' => 'Mix the pasta with the sauce and serve hot.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
