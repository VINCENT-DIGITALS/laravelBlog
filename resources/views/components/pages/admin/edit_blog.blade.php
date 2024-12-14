<!DOCTYPE html>
<html lang="en">

@include('includes.header')

@extends('layouts.main')
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
    }

    .container {
        margin: 50px auto;
        max-width: 700px;
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        font-size: 1.8rem;
        font-weight: bold;
        margin-bottom: 20px;
        color: #343a40;
        text-align: center;
    }

    label {
        font-weight: bold;
        color: #495057;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ced4da;
        border-radius: 5px;
        font-size: 1rem;
        color: #495057;
    }

    .form-select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ced4da;
        border-radius: 5px;
        font-size: 1rem;
        color: #495057;
    }

    .btn {
        padding: 10px 20px;
        font-size: 1rem;
        font-weight: bold;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
        margin-top: 10px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
        margin-top: 10px;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    @media (max-width: 768px) {
        .container {
            margin: 20px;
            padding: 20px;
        }

        .btn {
            width: 100%;
            text-align: center;
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

@section('content')
<div class="container">
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

    <h1>Edit Blog</h1>
    <form action="{{ route('updateBlog', $blog->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="Enter blog title" value="{{ $blog->title }}" required>
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <select name="category" id="category" class="form-select">
                <option value="" disabled>Select a category</option>
                <option value="Economics" {{ $blog->category == 'Economics' ? 'selected' : '' }}>Economics</option>
                <option value="Politics" {{ $blog->category == 'Politics' ? 'selected' : '' }}>Politics</option>
                <option value="Education" {{ $blog->category == 'Education' ? 'selected' : '' }}>Education</option>
                <option value="Technology" {{ $blog->category == 'Technology' ? 'selected' : '' }}>Technology</option>
            </select>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea id="content" name="content" placeholder="Write your content here" required>{{ $blog->content }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="{{ route('AdminDashboard') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

</html>
