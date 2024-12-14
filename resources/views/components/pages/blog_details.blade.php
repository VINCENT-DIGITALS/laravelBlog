<!DOCTYPE html>
<html lang="en">

@include('includes.header')

@extends('layouts.main')
<style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        background-color: #f8f9fa;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .blog-details-container {
        margin: 2rem auto;
        max-width: 900px;
        padding: 2rem;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    /* Header Section */
    header h1 {
        font-size: 2rem;
        color: #333;
        margin-bottom: 1rem;
        text-align: center;
    }

    .blog-meta {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 1.5rem;
    }

    .category {
        background-color: #e9ecef;
        padding: 0.3rem 0.6rem;
        border-radius: 4px;
        font-size: 0.85rem;
        color: #495057;
    }

    .created-at {
        margin-left: auto;
        font-style: italic;
    }

    /* Blog Content */
    .blog-image {
        max-width: 100%;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        object-fit: cover;
        transition: transform 0.3s ease-in-out;
    }

    .blog-image:hover {
        transform: scale(1.02);
    }

    .blog-content p {
        line-height: 1.8;
        font-size: 1rem;
        margin: 1rem 0;
    }

    /* Footer Section */
    footer {
        text-align: center;
        margin-top: 2rem;
    }

    .back-button {
        display: inline-block;
        padding: 0.6rem 1.2rem;
        background-color: #007bff;
        color: #fff;
        border-radius: 5px;
        text-decoration: none;
        font-size: 1rem;
        transition: background-color 0.3s ease-in-out;
    }

    .back-button:hover {
        background-color: #0056b3;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .blog-details-container {
            margin: 1rem;
            padding: 1.5rem;
        }

        .blog-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .category {
            font-size: 0.8rem;
        }

        .created-at {
            margin-left: 0;
        }
    }

    .blog-likes {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 1.5rem;
        padding: 0.5rem;
        background-color: #f1f1f1;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .like-btn {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 5px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out, transform 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .like-btn i {
        font-size: 1.2rem;
    }

    .like-btn:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    .likes-count {
        font-size: 1rem;
        color: #333;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .likes-count i {
        font-size: 1.2rem;
    }


    /* Comments Section */
    .blog-comments {
        margin-top: 2rem;
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .comments-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .comments-header h3 {
        font-size: 1.2rem;
        margin: 0;
    }

    .toggle-comments-btn {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 0.4rem 0.8rem;
        font-size: 0.9rem;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out, transform 0.2s;
    }

    .toggle-comments-btn:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    .comments-container {
        display: block;
    }

    .comment-form {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 1.5rem;
    }

    .comment-form textarea {
        resize: none;
        padding: 0.8rem;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 1rem;
    }

    .submit-comment-btn {
        align-self: flex-start;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 0.6rem 1.2rem;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
    }

    .submit-comment-btn:hover {
        background-color: #0056b3;
    }

    .comment-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .comment-item {
        padding: 0.8rem;
        background-color: #fff;
        border-radius: 8px;
        margin-bottom: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .comment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .comment-header strong {
        font-size: 1rem;
        color: #333;
    }

    .comment-date {
        font-size: 0.85rem;
        color: #666;
    }

    .comment-text {
        font-size: 1rem;
        line-height: 1.6;
        color: #555;
    }
</style>


@section('content')
    <div class="blog-details-container">
        <header>
            <h1>{{ $blog->title }}</h1>
        </header>
        <section class="blog-meta">
            <span class="category">Category: {{ $blog->category }}</span>
            <span class="created-at">Published on: {{ $blog->created_at->format('F d, Y') }}</span>
        </section>
        <section class="blog-content">
            <img src="{{ $blog->image ?: asset('assets/LOGO.png') }}" alt="{{ $blog->title }} image" class="blog-image"
                onerror="this.src='{{ asset('assets/LOGO.png') }}';">
            <div class="blog-likes">
                <span class="likes-count">
                    <i class="fa fa-heart" style="color: red;"></i> {{ $blog->likes_count }} Likes
                </span>
            </div>
            <div>{!! $blog->content !!}</div>
        </section>

      
            <section class="blog-comments">
                <div class="comments-header">
                    <h3>Comments ({{ $comments->count() }})</h3>
                    <button class="toggle-comments-btn" onclick="toggleComments()">Toggle Comments</button>
                </div>
                <div id="comments-container" class="comments-container">
                        @if (session('user_id') && session('role') !== 'Admin')
                            <form action="{{ route('submitComment') }}" method="POST" class="comment-form">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $blog->id }}">
                                <textarea name="comment" rows="4" placeholder="Write a comment..." required></textarea>
                                <button type="submit" class="submit-comment-btn">Submit Comment</button>
                            </form>
                        @else
                        <p>You must be a registered user to comment.</p>
                    @endif

                    <ul class="comment-list">
                        @forelse ($comments as $comment)
                            <li class="comment-item">
                                <div class="comment-header">
                                    <strong>{{ $comment->user->username }}</strong>
                                    <span class="comment-date">{{ $comment->created_at->format('F d, Y h:i A') }}</span>
                                </div>
                                <p class="comment-text">{{ $comment->comment }}</p>
                            </li>
                        @empty
                            <li>No comments yet. Be the first to comment!</li>
                        @endforelse
                    </ul>
                </div>
            </section>
       

        <footer>
            <a href="{{ route('returnHome') }}" class="back-button">Back to Blogs</a>
        </footer>
    </div>
@endsection
<script>
    function toggleComments() {
        const commentsContainer = document.getElementById('comments-container');
        if (commentsContainer.style.display === 'none') {
            commentsContainer.style.display = 'block';
        } else {
            commentsContainer.style.display = 'none';
        }
    }
</script>

</html>
