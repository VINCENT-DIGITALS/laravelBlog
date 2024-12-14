@extends('layouts.main')

@section('content')
    <style>
        .search-container {
            margin: 20px 0;
        }

        .filter-section {
            margin-bottom: 20px;
        }

        .blog-card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
        }

        .blog-card h3 {
            margin: 0;
        }

        .blog-card small {
            color: #777;
        }

        .post-card {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .post-card h2 {
            margin: 0 0 10px;
        }

        .post-card p {
            margin: 5px 0;
        }

        .post-card small {
            color: gray;
        }
    </style>

    <body>
        <section class="search-container">
            <input type="text" id="searchInput" placeholder="Search for a blog..." />
        </section>

        <div class="filter-section">
            <div class="category-filter">
                <select id="categoryFilter">
                    <option value="">All Categories</option>
                    <option value="Technology">Technology</option>
                    <option value="Education">Education</option>
                    <option value="Politics">Politics</option>
                    <option value="Economics">Economics</option>
                </select>
            </div>
            <button id="applyFilter">Apply Filter</button>
        </div>

        <main>
            <!-- The posts will be dynamically loaded here -->
        </main>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchInput');
                const categoryFilter = document.getElementById('categoryFilter');
                const applyFilterButton = document.getElementById('applyFilter');
                const mainContainer = document.querySelector('main');

                // Function to fetch and display posts
                async function fetchAndDisplayPosts() {
                    const search = searchInput.value;
                    const category = categoryFilter.value;

                    const response = await fetch(
                        `/posts?search=${encodeURIComponent(search)}&category=${encodeURIComponent(category)}`);
                    const posts = await response.json();

                    // Clear main container
                    mainContainer.innerHTML = '';

                    // Render posts as cards
                    posts.forEach(post => {
                        const card = document.createElement('div');
                        card.classList.add('post-card');
                        card.innerHTML = `
                            <h2>${post.title}</h2>
                            <p><strong>Category:</strong> ${post.category}</p>
                            <p>${post.content.substring(0, 150)}...</p>
                            <small><em>Posted on: ${new Date(post.createdAt).toLocaleDateString()}</em></small>
                        `;
                        mainContainer.appendChild(card);
                    });
                }

                // Event listeners for filters
                searchInput.addEventListener('input', fetchAndDisplayPosts);
                applyFilterButton.addEventListener('click', fetchAndDisplayPosts);

                // Initial fetch
                fetchAndDisplayPosts();
            });
        </script>
    </body>
@endsection
