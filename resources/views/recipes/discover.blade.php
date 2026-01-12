@extends('layouts.app')

@section('title', 'What do I want today?')

@section('content')
    <div class="card">
        <h2 style="margin-bottom: 10px;">What do I want today?</h2>
        <p style="margin-bottom: 10px;">
            Click the button and swipe through random recipes.  
            Left = dislike, right = like.
        </p>

        <button id="startBtn" class="btn" style="margin-bottom: 12px;">
            Show me something
        </button>
    </div>

    <div id="discoverArea" style="display:none;">
        <div class="card" id="recipeCard">
            <h2 id="recipeTitle"></h2>

            <div id="recipeImageWrapper" style="margin: 10px 0; display: none;">
                <img id="recipeImage"
                     src=""
                     alt=""
                     style="max-width: 100%; border-radius: 6px;">
            </div>

            <div class="recipe-meta" id="recipeMeta"></div>

            <p id="recipeDescription"></p>
        </div>

        <div class="card" style="text-align: center;">
            <p style="margin-bottom: 8px;">Do you like this one?</p>
            <div style="display: flex; justify-content: center; gap: 16px;">
                <button id="dislikeBtn" class="btn btn-outline">
                    👈 Dislike
                </button>
                <button id="likeBtn" class="btn">
                    👉 Like
                </button>
            </div>
            <p id="statusText" style="margin-top: 10px; font-size: 14px; color: #666;"></p>
        </div>
    </div>

    {{-- Передаём данные рецептов в JS --}}
    <script>
        const recipes = @json($recipes);
        let currentIndex = -1;
        const liked = [];
        const disliked = [];

        const startBtn = document.getElementById('startBtn');
        const discoverArea = document.getElementById('discoverArea');

        const recipeTitle = document.getElementById('recipeTitle');
        const recipeImageWrapper = document.getElementById('recipeImageWrapper');
        const recipeImage = document.getElementById('recipeImage');
        const recipeMeta = document.getElementById('recipeMeta');
        const recipeDescription = document.getElementById('recipeDescription');

        const likeBtn = document.getElementById('likeBtn');
        const dislikeBtn = document.getElementById('dislikeBtn');
        const statusText = document.getElementById('statusText');

        function showRecipe(index) {
            if (!recipes.length) {
                recipeTitle.textContent = 'No recipes available';
                recipeDescription.textContent = '';
                recipeImageWrapper.style.display = 'none';
                recipeMeta.textContent = '';
                return;
            }

            if (index < 0 || index >= recipes.length) {
                recipeTitle.textContent = 'You have seen all recipes!';
                recipeDescription.textContent = '';
                recipeImageWrapper.style.display = 'none';
                recipeMeta.textContent = '';
                statusText.textContent = `Liked: ${liked.length}, disliked: ${disliked.length}`;
                return;
            }

            const r = recipes[index];

            recipeTitle.textContent = r.title ?? 'Untitled';
            recipeDescription.textContent = r.description ?? '';

            // картинка
            if (r.image_path) {
                recipeImageWrapper.style.display = 'block';
                recipeImage.src = '{{ asset('storage') }}/' + '/' + r.image_path;
                recipeImage.alt = r.title ?? '';
            } else {
                recipeImageWrapper.style.display = 'none';
            }

            // meta: категория + время + порции
            let metaParts = [];
            if (r.category && r.category.name) {
                metaParts.push('Category: ' + r.category.name);
            }
            if (r.cooking_time) {
                metaParts.push('Time: ' + r.cooking_time + ' min');
            }
            if (r.portions) {
                metaParts.push('Portions: ' + r.portions);
            }
            recipeMeta.textContent = metaParts.join(' | ');

            statusText.textContent = '';
        }

        function nextRecipe(action) {
            if (currentIndex >= 0 && currentIndex < recipes.length) {
                const r = recipes[currentIndex];
                if (action === 'like') {
                    liked.push(r.id);
                    statusText.textContent = 'You liked this one 👍';
                } else if (action === 'dislike') {
                    disliked.push(r.id);
                    statusText.textContent = 'You disliked this one 👎';
                }
            }

            currentIndex++;
            if (currentIndex < recipes.length) {
                showRecipe(currentIndex);
            } else {
                showRecipe(currentIndex); // покажем сообщение "всё просмотрели"
            }
        }

        startBtn?.addEventListener('click', function () {
            startBtn.style.display = 'none';
            discoverArea.style.display = 'block';
            currentIndex = 0;
            showRecipe(currentIndex);
        });

        likeBtn?.addEventListener('click', function () {
            nextRecipe('like');
        });

        dislikeBtn?.addEventListener('click', function () {
            nextRecipe('dislike');
        });
    </script>
@endsection
