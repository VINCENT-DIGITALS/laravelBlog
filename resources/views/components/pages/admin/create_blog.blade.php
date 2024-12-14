<!DOCTYPE html>
<html lang="en">

@include('includes.header')

<style>
    body {
        background-color: #f5f5f5;
        font-family: 'Arial', sans-serif;
    }

    .page-header {

        color: black;
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 30px;
        text-align: center;
        position: relative;
    }

    .cancel-button {
        position: absolute;
        top: 50%;
        left: 20px;
        transform: translateY(-50%);
        background-color: white;
        color: #007bff;
        font-weight: bold;
        border: 1px solid #007bff;
        border-radius: 5px;
        padding: 8px 15px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s ease;
    }

    .cancel-button:hover {
        background-color: #007bff;
        color: white;
    }

    .card {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 0 auto;
    }

    .card h5 {
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-size: 1.25rem;
        font-weight: bold;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-control,
    .form-select {
        border-radius: 6px;
        padding: 10px;
        font-size: 1rem;
        border: 1px solid #ccc;
        transition: border-color 0.2s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 4px rgba(0, 123, 255, 0.3);
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        color: white;
        padding: 10px 20px;
        font-size: 1rem;
        border-radius: 6px;
        cursor: pointer;
        width: 100%;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .alert {
        padding: 10px 15px;
        font-size: 0.9rem;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .alert-danger ul {
        margin: 0;
        padding: 0;
        list-style: none;
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
</style>

<script src="https://cdn.tiny.cloud/1/4rplkn6gfdwnjpds0mcmaeoq6t7zzmvc4dn3cnv1jp40i1ky/tinymce/7/tinymce.min.js"
    referrerpolicy="origin"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        tinymce.init({
            selector: 'textarea#content',
            plugins: 'link image media table',
            toolbar: 'undo redo | formatselect | bold italic | link image | alignleft aligncenter alignright | numlist bullist',
            height: 300,
        });
    });
</script>

<body>
    @include('includes.navbar')

    <header class="page-header">
        <a href="{{ route('AdminDashboard') }}" class="cancel-button">
            <i class="fa fa-arrow-left"></i> Cancel
        </a>
        <h2>Add Blog</h2>
    </header>

    <div class="card">
        <h5>Create a New Blog Post</h5>

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

        <form method="POST" action="{{ route('blogs.store') }}">
            @csrf

            <!-- Title Field -->
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Enter blog title"
                    value="{{ old('title') }}">
                @if ($errors->has('title'))
                    <small class="text-danger">{{ $errors->first('title') }}</small>
                @endif
            </div>
            <!-- Category Field -->
            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="category" class="form-select">
                    <option value="" disabled selected>Select a category</option>
                    <option value="Economics" {{ old('category') == 'Economics' ? 'selected' : '' }}>Economics</option>
                    <option value="Politics" {{ old('category') == 'Politics' ? 'selected' : '' }}>Politics</option>
                    <option value="Education" {{ old('category') == 'Education' ? 'selected' : '' }}>Education</option>
                    <option value="Technology" {{ old('category') == 'Technology' ? 'selected' : '' }}>Technology
                    </option>
                </select>

            </div>
            <!-- Content Field -->
            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" class="form-control" placeholder="Write your content here">{{ old('content') }}</textarea>
                @if ($errors->has('content'))
                    <small class="text-danger">{{ $errors->first('content') }}</small>
                @endif
            </div>



            <!-- Submit Button -->
            <button type="submit" class="btn-primary">Add Blog</button>
        </form>
    </div>

    @include('includes.footer')
</body>

</html>
