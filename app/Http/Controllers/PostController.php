<?php

// PostController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Get search and filter values
        $search = $request->input('search');
        $category = $request->input('category');

        // Query the database with filters
        $query = Post::query();

        if ($search) {
            $query->where('title', 'LIKE', "%$search%")
                  ->orWhere('content', 'LIKE', "%$search%");
        }

        if ($category) {
            $query->where('category', $category);
        }

        $posts = $query->orderBy('created_at', 'desc')->get();

        return response()->json($posts);
    }
}
