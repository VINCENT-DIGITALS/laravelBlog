<section class="blogs-container">
    @if($posts->isEmpty())
        <p>No blogs found.</p>
    @else
        @foreach($posts as $post)
            <div class="blog-card">
                <h2>{{ $post->title }}</h2>
                <p>{{ \Illuminate\Support\Str::limit($post->content, 150, '...') }}</p>
                <span class="blog-category">Category: {{ $post->category }}</span>
                <span class="blog-date">Posted on: {{ $post->created_at->format('M d, Y') }}</span>
            </div>
        @endforeach
    @endif
</section>

<style>
    .blogs-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .blog-card {
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 5px;
        background: #fff;
    }

    .blog-category, .blog-date {
        display: block;
        margin-top: 10px;
        font-size: 0.9em;
        color: #666;
    }
</style>
