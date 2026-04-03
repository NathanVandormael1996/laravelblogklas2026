<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function show(Category $category): View
    {
        $posts = $category->posts()
            ->with(['user', 'categories', 'media'])
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->paginate(12);

        return view('frontend.categories.show', ['category' => $category, 'posts' => $posts]);
    }
}
