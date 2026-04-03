<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PostIndexRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;
use Throwable;

class PostController extends Controller
{
    public function __construct(protected PostService $postService) {}

    public function index(PostIndexRequest $request)
    {
        $this->authorize('viewAny', Post::class);

        $filters = $request->defaults();

        $postsQuery = Post::query()
            ->with(['user', 'creator', 'editor', 'categories', 'media'])
            ->search($filters['q'])
            ->authorFilter($filters['author'])
            ->categoryFilter($filters['category'])
            ->statusFilter($filters['status'])
            ->trashedFilter($filters['trashed'])
            ->sortBySafe($filters['sort'], $filters['dir']);

        if (! $this->canManageAllPosts()) {
            $postsQuery->where('user_id', auth()->id());
        }

        $posts = $postsQuery
            ->paginate($filters['per_page'])
            ->withQueryString();

        $authorsQuery = User::query()->orderBy('name');

        if (! $this->canManageAllPosts()) {
            $authorsQuery->where('id', auth()->id());
        }

        $authors = $authorsQuery->get(['id', 'name']);

        $categories = Category::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('backend.posts.index', [
            'posts' => $posts,
            'authors' => $authors,
            'categories' => $categories,
            'filters' => $filters,
            'perPageAllowed' => [10, 25, 50, 100],
        ]);
    }

    public function create()
    {
        $this->authorize('create', Post::class);

        $authors = User::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        $categories = Category::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('backend.posts.create', [
            'authors' => $authors,
            'categories' => $categories,
        ]);
    }

    public function store(StorePostRequest $request)
    {
        $this->authorize('create', Post::class);

        $validated = $request->validated();

        $imageFile = $validated['image'] ?? null;
        unset($validated['image']);

        $post = $this->postService->create($validated);

        if ($imageFile) {
            $this->processAndSaveImage($post, $imageFile);
        }

        return redirect()
            ->route('backend.posts.index')
            ->with('success', "Post '{$post->title}' created successfully.");
    }

    public function show(Post $post)
    {
        $this->authorize('view', $post);

        $post->load(['user', 'creator', 'editor', 'categories', 'media']);

        return view('backend.posts.show', [
            'post' => $post,
        ]);
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        $post->load(['categories', 'media']);

        $authorsQuery = User::query()->orderBy('name');

        if (! $this->canManageAllPosts()) {
            $authorsQuery->where('id', auth()->id());
        }

        $authors = $authorsQuery->get(['id', 'name']);

        $categories = Category::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('backend.posts.edit', [
            'post' => $post,
            'authors' => $authors,
            'categories' => $categories,
        ]);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validated();

        $imageFile = $validated['image'] ?? null;
        unset($validated['image']);

        $post = $this->postService->update($post, $validated);

        if ($imageFile) {
            $this->processAndSaveImage($post, $imageFile);
        }

        return redirect()
            ->route('backend.posts.edit', $post)
            ->with('success', "Post '{$post->title}' updated successfully.");
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        try {
            $post->delete();

            return redirect()
                ->route('backend.posts.index')
                ->with('success', "Post '{$post->title}' deleted successfully.");
        } catch (Throwable) {
            return back()
                ->with('error', 'Post could not be deleted.');
        }
    }

    public function restore(int $id)
    {
        try {
            $post = Post::withTrashed()->findOrFail($id);

            $this->authorize('restore', $post);

            $post->restore();

            return redirect()
                ->route('backend.posts.index')
                ->with('success', "Post '{$post->title}' restored successfully.");
        } catch (Throwable) {
            return back()
                ->with('error', 'Post could not be restored.');
        }
    }

    public function forceDelete(int $id)
    {
        try {
            $post = Post::withTrashed()->findOrFail($id);

            $this->authorize('forceDelete', $post);

            $title = $post->title;

            $post->forceDelete();

            return redirect()
                ->route('backend.posts.index')
                ->with('success', "Post '{$title}' permanently deleted.");
        } catch (Throwable) {
            return back()
                ->with('error', 'Post could not be permanently deleted.');
        }
    }

    protected function canManageAllPosts(): bool
    {
        return in_array(auth()->user()?->role?->name, ['admin', 'editor'], true);
    }

    protected function processAndSaveImage(Post $post, $file): void
    {
        $filename = time().'_'.uniqid().'.jpg';
        $savePath = 'posts/'.$filename;

        $manager = ImageManager::usingDriver(Driver::class);
        $image = $manager->decode($file->getPathname());

        $image->scale(width: 1200);

        $encodedImage = $image->encodeUsingFormat(Format::JPEG, 80);

        Storage::disk('public')->put($savePath, $encodedImage->toString());

        if ($post->media) {
            $post->media()->update(['filename' => $savePath]);
        } else {
            $post->media()->create(['filename' => $savePath]);
        }
    }
}
