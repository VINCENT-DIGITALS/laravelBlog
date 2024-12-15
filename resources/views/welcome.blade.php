@extends('layouts.main')

@section('content')
    <style>
        /* Body and General Styles */
        body {
            background-color: #f9f9f9;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            color: black;
        }

        .add_btn {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .add_btn:hover,
        .add_btn:focus {
            background-color: #0056b3;
            outline: none;
        }

        /* Search Section */
        .search-container {
            display: flex;
            justify-content: center;
            margin: 20px auto;
            width: 90%;
        }

        .search-container input {
            flex: 1;
            max-width: 500px;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
        }

        /* Filter Section */
        .filter-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 15px;
            padding: 10px;

            max-width: 400px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .filter-section select,
        .filter-section button {
            font-size: 1rem;
            padding: 10px 15px;
            border-radius: 6px;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .filter-section select {
            flex: 1;
            max-width: 200px;
            background-color: #f9f9f9;
        }

        .filter-section button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        .filter-section button:hover,
        .filter-section button:focus {
            background-color: #0056b3;
            outline: none;
        }

        @media (max-width: 600px) {

            .filter-section select,
            .filter-section button {
                width: 100%;
                max-width: none;
                text-align: center;
            }
        }

        /* Blog Grid */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        /* Blog Card */
        .blog-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .blog-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            transition: opacity 0.3s ease-in-out;
        }

        .blog-card img[onerror] {
            opacity: 0.5;
        }

        .blog-card-content {
            padding: 15px;
        }

        .blog-card-content h3 {
            font-size: 1.5rem;
            margin: 0 0 10px;
            color: #007bff;
        }

        .blog-card-content p {
            font-size: 0.9rem;
            color: #555;
            margin: 0 0 10px;
        }

        .blog-card-content .category {
            display: inline-block;
            font-size: 0.85rem;
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            background-color: #007bff;
        }

        .no-blogs {
            text-align: center;
            font-size: 1.2rem;
            color: #777;
            padding: 20px;
        }

        /* Container for the toast */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Toast style */
        .toast {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            min-width: 250px;
            max-width: 300px;
            animation: slideIn 0.5s ease-out, fadeOut 3s 2.5s forwards;
        }

        /* Success toast (green) */
        .toast.alert-success {
            background-color: #28a745;
        }

        /* Danger toast (red) */
        .toast.alert-danger {
            background-color: #dc3545;
        }

        /* Animation for sliding in */
        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        /* Fade out animation */
        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        /* Container for the toast */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Toast style */
        .toast {
            background-color: #dc3545;
            /* Red background for errors */
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            min-width: 250px;
            max-width: 300px;
            animation: slideIn 0.5s ease-out, fadeOut 3s 2.5s forwards;
        }

        /* Animation for sliding in */
        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        /* Fade out animation */
        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        .blog-share {
            margin-top: 10px;
        }

        .share-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .share-btn:hover {
            background: #0056b3;
        }
    </style>

    <body>
        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="toast-container">
                <div class="toast alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if (session('msg'))
            <div class="toast-container">
                <div class="toast alert-{{ session('msg')[0] }}">
                    <p>{{ session('msg')[1] }}</p>
                </div>
            </div>
        @endif
        <!-- Search Section -->
        <section class="search-container">
            <input type="text" id="searchInput" placeholder="Search for a blog..." aria-label="Search blogs" />
        </section>

        <!-- Filter Section -->
        <div class="filter-section">
            <select id="categoryFilter" aria-label="Filter blogs by category">
                <option value="">All Categories</option>
                <option value="Technology">Technology</option>
                <option value="Education">Education</option>
                <option value="Politics">Politics</option>
                <option value="Economics">Economics</option>
            </select>
            <button id="applyFilter">Apply Filter</button>
        </div>


        <!-- Blog List -->
        <main>
            <section>
                <div class="grid-container" id="gridBlogs">
                    <!-- Blog cards will be dynamically added here -->
                </div>
            </section>
        </main>
    </body>
    <script>
        $(document).ready(function() {
            // Fetch and display blogs
            function fetchBlogs(category = '', search = '') {
                $.ajax({
                    url: "{{ route('fetchBlogs') }}",
                    method: "GET",
                    data: {
                        category,
                        search
                    },
                    success: function(data) {
                        const blogContainer = $('#gridBlogs');
                        blogContainer.empty();

                        if (data.length > 0) {
                            data.forEach(post => {
    const userId = '{{ session('user_id') }}'; // Assuming you're using a PHP session variable.
    const userRole = '{{ session('role') }}'; // Assuming you're using a PHP session variable.

    const blogCard = `
    <div class="blog-card">
        <a href="/blog/${post.id}" class="blog-card-link" aria-label="Read more about ${post.title}">
            <img 
                class="blog-card-img" 
               src="{{ asset('assets/LOGO.png') }}"
                alt="${post.title} image" 
                onerror="this.src='{{ asset('assets/LOGO.png') }}';" />
            <div class="blog-card-content">
                <h3 class="blog-card-title">${post.title}</h3>
                <p class="blog-card-snippet">${post.content.substring(0, 100)}...</p>
                <span class="blog-card-category">${post.category}</span>
            </div>
        </a>
        ${userId && userRole !== 'Admin' ? `
            <div class="blog-likes">
                <button class="like-btn" data-id="${post.id}" data-user-id="${userId}">
                    <i class="fa fa-thumbs-up"></i> Like
                </button>
                <span class="likes-count">${post.likes_count || 0} Likes</span>
            </div>
        ` : ''}
        <div class="blog-share">
            <button class="share-btn" data-id="${post.id}" data-title="${post.title}">
                <i class="fa fa-share"></i> Share
            </button>
        </div>
    </div>
    `;
    blogContainer.append(blogCard);
});

                            // Add event listeners for share buttons
                            document.addEventListener('click', (event) => {
                                if (event.target.closest('.share-btn')) {
                                    const button = event.target.closest('.share-btn');
                                    const postId = button.getAttribute('data-id');
                                    const postTitle = button.getAttribute('data-title');
                                    const postUrl = `${window.location.origin}/blog/${postId}`;

                                    if (navigator.share) {
                                        // Use Web Share API if supported
                                        navigator.share({
                                            title: postTitle,
                                            text: `Check out this post: ${postTitle}`,
                                            url: postUrl,
                                        }).catch(error => console.error('Error sharing:',
                                            error));
                                    } else {
                                        // Fallback: Copy URL to clipboard
                                        navigator.clipboard.writeText(postUrl)
                                            .then(() => alert('Post URL copied to clipboard!'))
                                            .catch(error => console.error('Error copying URL:',
                                                error));
                                    }
                                }
                            });


                            // Add click event listener for like buttons
                            $(document).on('click', '.like-btn', function() {
                                const button = $(this);
                                const postId = button.data('id');
                                const userId = button.data('user-id');

                                $.ajax({
                                    url: '/likepost', // Laravel route for liking a post
                                    method: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        post_id: postId,
                                        user_id: userId,
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            const likesCountSpan = button.siblings(
                                                '.likes-count');
                                            const newLikesCount = response
                                                .likes_count;
                                            likesCountSpan.text(
                                                `${newLikesCount} Likes`);
                                        } else {
                                            alert(response.message ||
                                                'Error while liking the post.');
                                        }
                                    },
                                    error: function(xhr) {
                                        console.error(xhr.responseText);
                                        alert('An error occurred.');
                                    }
                                });
                            });

                        } else {
                            blogContainer.append('<p class="no-blogs">No blogs found.</p>');
                        }
                    },
                    error: function(err) {
                        console.error('Error fetching blogs:', err);
                    }
                });
            }

            // Fetch blogs on page load
            fetchBlogs();

            // Apply filters
            $('#applyFilter').click(function() {
                const category = $('#categoryFilter').val();
                const search = $('#searchInput').val();
                fetchBlogs(category, search);
            });

            // Trigger search on typing
            $('#searchInput').on('keyup', function() {
                const category = $('#categoryFilter').val();
                const search = $(this).val();
                fetchBlogs(category, search);
            });
        });
    </script>
@endsection
