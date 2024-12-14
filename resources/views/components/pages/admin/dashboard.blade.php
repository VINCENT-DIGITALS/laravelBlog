<!DOCTYPE html>
<html lang="en">

@include('includes.header')

<style>
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
        color: black;
        padding: 5px;

    }

    .add_btn {
        background-color: #007bff;
        color: white;
        font-weight: bold;
        border: none;
        border-radius: 5px;
        padding: 10px 15px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s ease;
    }

    .add_btn:hover {
        background-color: #0056b3;
    }

    .search-container {
        display: flex;
        justify-content: center;
        margin: 20px auto;
    }

    .search-container input {
        width: 100%;
        max-width: 500px;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 1rem;
    }

    .filter-section {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin: 20px auto;
    }

    .filter-section select {
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #ddd;
        font-size: 1rem;
    }

    #applyFilter {
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 10px 15px;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    #applyFilter:hover {
        background-color: #0056b3;
    }

    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .blog-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-decoration: none;
        color: inherit;
    }

    .blog-card:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .blog-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .blog-card-content {
        padding: 15px;
    }

    .blog-card-content h3 {
        font-size: 1.5rem;
        margin: 0;
        margin-bottom: 10px;
        color: #007bff;
    }

    .blog-card-content p {
        font-size: 0.9rem;
        color: #555;
        margin-bottom: 10px;
    }

    .blog-card-content .category {
        display: inline-block;
        margin-top: 10px;
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

    .blog-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 10px;
    }

    .blog-actions button {
        display: flex;
        align-items: center;
        gap: 5px;
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .blog-actions .edit-btn {
        background-color: #007bff;
        /* Blue */
        color: white;
    }

    .blog-actions .edit-btn:hover {
        background-color: #0056b3;
        /* Darker Blue */
    }

    .blog-actions .delete-btn {
        background-color: #dc3545;
        /* Red */
        color: white;
    }

    .blog-actions .delete-btn:hover {
        background-color: #a71d2a;
        /* Darker Red */
    }

    /* Add icons styling */
    .blog-actions button i {
        font-size: 16px;
    }
</style>

<body>
    @include('includes.navbar')

    <!-- Header Section -->
    <header>

        <a class="add_btn" href="{{ route('adminCreate') }}">
            <i class="fa fa-plus-circle me-1"></i> Create Blog
        </a>
    </header>
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
        <input type="text" id="searchInput" placeholder="Search for a blog..." />
    </section>

    <!-- Filter Section -->
    <div class="filter-section">
        <select id="categoryFilter">
            <option value="">All Categories</option>
            <option value="Technology">Technology</option>
            <option value="Education">Education</option>
            <option value="Politics">Politics</option>
            <option value="Economics">Economics</option>
        </select>
        <button id="applyFilter">Apply Filter</button>
    </div>

    <main>
        <section>
            <div class="grid-container" id="gridBlogs">
                <!-- Blog cards will be dynamically added here -->
            </div>
        </section>
    </main>

    @include('includes.footer')
</body>

<script>
    $(document).ready(function() {
        // Function to fetch and display blogs
        function fetchBlogs(category = '', search = '') {
            $.ajax({
                url: "{{ route('fetchBlogs') }}",
                method: "GET",
                data: {
                    category: category,
                    search: search
                },
                success: function(data) {
                    const blogContainer = $('#gridBlogs');
                    blogContainer.empty();

                    if (data.length > 0) {
                        data.forEach(post => {
                            const blogCard = `
                                <div class="blog-card">
                                    <a href="/blog/${post.id}" class="blog-link">
                                        <img src="{{ session('profile_picture') ?: asset('assets/LOGO.png') }}" alt="Blog Image">
                                        <div class="blog-card-content">
                                            <h3>${post.title}</h3>
                                            <p>${post.content.substring(0, 100)}...</p>
                                            <span class="category">${post.category}</span>
                                        </div>
                                    </a>
                                    <div class="blog-actions">
                                        <button class="edit-btn" data-id="${post.id}">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                        <button class="delete-btn" data-id="${post.id}">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </div>

                                </div>
                                `;
                            blogContainer.append(blogCard);
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

        // Apply filters on button click
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

        // Handle edit button click
        $(document).on('click', '.edit-btn', function() {
            const blogId = $(this).data('id');
            // Redirect to edit page
            window.location.href = `/blog/edit/${blogId}`;
        });

        // Handle delete button click
        $(document).on('click', '.delete-btn', function() {
            const blogId = $(this).data('id');
            const confirmed = confirm('Are you sure you want to delete this blog?');

            if (confirmed) {
                $.ajax({
                    url: `/blog/delete/${blogId}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Display a toast message for success
                        alert(response.message || 'Blog deleted successfully.');
                        fetchBlogs(); // Refresh the blog list
                    },
                    error: function(err) {
                        console.error('Error deleting blog:', err);
                        alert(err.responseJSON?.message || 'Failed to delete the blog.');
                    }
                });
            }
        });

    });
</script>


</html>
