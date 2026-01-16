@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <div class="card">
        <h2>Welcome to Recipe App</h2>
        <p>
            Here you can store your recipes, ingredients and cooking steps.
        </p>

        <div style="margin-top: 12px;">
            <a href="{{ route('recipes.index') }}" class="btn">View recipes</a>
            <a href="{{ route('recipes.create') }}" class="btn btn-outline">Create recipe</a>
        </div>
    </div>

    <div class="card">
        <h3>What you can do:</h3>
        <ul>
            <li>Save your favourite recipes</li>
            <li>Add ingredients and their quantities</li>
            <li>Write step-by-step instructions</li>
            <li>Group recipes by categories</li>
        </ul>
    </div>
@endsection