<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function fetchBlogs(Request $request)
    {
        $query = Post::query();

        // Apply category filter if provided
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Apply search filter if provided
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $posts = $query->orderBy('created_at', 'desc')->get();

        return response()->json($posts);
    }
    public function show($id)
    {
        $blog = Post::findOrFail($id); // Fetch the blog post by ID or throw a 404
        $comments = Comment::where('post_id', $id)->with('user')->latest()->get();
        return view('components.pages.blog_details', compact('blog', 'comments'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'content' => 'required|string',
        ]);
        try {
            // Ensure user_id is in the session
            if (!session()->has('user_id')) {
                // Success message
                $msg = ['danger', 'Try to re-login!'];
                return redirect()->route('AdminDashboard')->with(['msg' => $msg]);
            }
            // Save the blog to the database
            Post::create([
                'user_id' => session('user_id'), // Ensure this session value exists
                'title' => $request->title,
                'category' => $request->category,
                'content' => $request->content,
            ]);
            DB::commit();
            // Success message
            $msg = ['success', 'Blog Data is Added!'];
            return redirect()->route('AdminDashboard')->with(['msg' => $msg]);
        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->errorInfo[1] == 1062) {
                $msg = ['danger', $e->errorInfo[2]];
            } else {

                $msg = ['danger', 'Error in Adding Data! ' . $e->errorInfo[2]];
            }

            return redirect()->back()->with(['msg' => $msg]);
        }




        // Return a JSON response

    }
    public function edit($id)
    {
        $blog = Post::find($id);

        if (!$blog) {
            // Success message
            $msg = ['danger', 'Blog Data is not found!'];
            return redirect()->route('AdminDashboard')->with(['msg' => $msg]);
        }

        return view('components.pages.admin.edit_blog', compact('blog')); // Assuming you have an 'edit' view
    }
    // Update blog
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string|max:100',
        ]);

        $blog = Post::find($id);

        if (!$blog) {
            $msg = ['danger', 'Blog Data is not found!'];
            return redirect()->route('AdminDashboard')->with(['msg' => $msg]);
        }

        $blog->update([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
        ]);

        $msg = ['sucess', 'Blog Data is updated successfully!'];
        return redirect()->route('AdminDashboard')->with(['msg' => $msg]);
    }
    // Delete blog
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $post = Post::findOrFail($id); // Throws 404 if not found
            $post->delete();

            DB::commit();

            // Return JSON response for AJAX
            return response()->json(['success' => true, 'message' => 'Blog deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['success' => false, 'message' => 'Error deleting blog: ' . $e->getMessage()], 500);
        }
    }




    public function likePost(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $postId = $request->post_id;
        $userId = $request->user_id;

        try {
            // Use a database transaction
            return DB::transaction(function () use ($postId, $userId) {
                try {
                    // Check if the user has already liked the post
                    $existingLike = Like::where('post_id', $postId)->where('user_id', $userId)->first();

                    if ($existingLike) {
                        return response()->json(['success' => false, 'message' => 'You have already liked this post.']);
                    }
                } catch (\Exception $e) {
                    // Handle errors during the existence check
                    return response()->json(['success' => false, 'message' => 'Error checking like status: ' . $e->getMessage()]);
                }

                try {
                    // Increment the likes_count in posts table
                    $post = Post::findOrFail($postId);
                    $post->increment('likes_count');
                } catch (\Exception $e) {
                    // Handle errors during the post increment
                    return response()->json(['success' => false, 'message' => 'Error incrementing likes: ' . $e->getMessage()]);
                }

                try {
                    // Create a new like record
                    Like::create([
                        'post_id' => $postId,
                        'user_id' => $userId,
                    ]);
                } catch (\Exception $e) {
                    // Handle errors during the like creation
                    return response()->json(['success' => false, 'message' => 'Error saving like: ' . $e->getMessage()]);
                }

                // Return success response
                return response()->json(['success' => true, 'likes_count' => Post::findOrFail($postId)->likes_count]);
            }, 5); // Retry up to 5 times in case of a deadlock
        } catch (\Exception $e) {
            // Catch any general errors outside the transaction
            return response()->json(['success' => false, 'message' => 'Transaction failed: ' . $e->getMessage()]);
        }
    }
}
