<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{

    public function index(Request $request): View
    {
        $query = Post::query()
            ->with(['user', 'categories', 'media'])
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->latest('published_at');

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');

            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                    ->orWhere('body', 'like', "%{$searchTerm}%");
            });
        }

        $posts = $query->paginate(12)->withQueryString();

        return view('frontend.posts.index', compact('posts'));
    }

    public function show(Post $post): View
    {
        if (!$post->is_published || !$post->published_at) {
            abort(404);
        }

        return view('frontend.posts.show', compact('post'));
    }
}
