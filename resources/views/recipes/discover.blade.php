@extends('layouts.app')

@section('title', 'Discover recipes')

@section('content')
    <div class="card">
        <h2>What do I want today?</h2>
        <p>
            Click the button below and I will show you a random recipe.
            Swipe with your heart: like or dislike 😋
        </p>

        <button id="startBtn" class="btn" type="button">
            Show me something
        </button>
    </div>

    <div id="discoverArea" style="display:none;">
        <div class="card">
            <h2 id="recipeTitle">Recipe title</h2>

            <div id="recipeImageWrapper" style="margin: 12px 0; display:none;">
                <img id="recipeImage"
                     src=""
                     alt=""
                     class="recipe-image-large discover-image">
            </div>

            <div id="recipeMeta" class="recipe-meta" style="margin-bottom: 8px;"></div>

            <p id="recipeDescription"></p>

            <div style="margin-top: 16px; display:flex; gap: 8px;">
                <button id="dislikeBtn" type="button" class="btn btn-outline">
                    👎 Dislike
                </button>
                <button id="likeBtn" type="button" class="btn">
                    👍 Like
                </button>
            </div>

            <p id="statusText" style="margin-top: 10px; font-size: 14px; color: #666;"></p>
        </div>
    </div>

    <script>
        const recipes = @json($recipes);
        let currentIndex = -1;
        const liked = [];
        const disliked = [];

        // Аккуратно берём CSRF-токен, чтобы не упасть, если мета-тег вдруг отсутствует
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

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
            if (!recipes || !recipes.length) {
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

            if (r.image_path) {
                recipeImageWrapper.style.display = 'block';
                recipeImage.src = '{{ asset('storage') }}/' + r.image_path;
                recipeImage.alt = r.title ?? '';
            } else {
                recipeImageWrapper.style.display = 'none';
                recipeImage.src = '';
                recipeImage.alt = '';
            }

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
            showRecipe(currentIndex);
        }

        // Кнопка "Show me something"
        startBtn?.addEventListener('click', function () {
            startBtn.style.display = 'none';
            discoverArea.style.display = 'block';
            currentIndex = 0;
            showRecipe(currentIndex);
        });

        // Like -> добавляем в избранное + следующй рецепт
        likeBtn?.addEventListener('click', function () {
            if (!recipes || !recipes.length || currentIndex < 0 || currentIndex >= recipes.length) {
                nextRecipe('like');
                return;
            }

            const r = recipes[currentIndex];

            fetch(`/recipes/${r.id}/favorite`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({}),
            }).then(response => {
                // даже если сервер вернул ошибку, в консоли это будет видно
                nextRecipe('like');
            }).catch(error => {
                console.error('Favorite error:', error);
                nextRecipe('like');
            });
        });

        // Dislike -> просто следующий рецепт
        dislikeBtn?.addEventListener('click', function () {
            nextRecipe('dislike');
        });
    </script>
@endsection
