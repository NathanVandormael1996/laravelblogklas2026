@props(['post'])

<div class="single-post-title mb-4">
    <div class="gazette-post-tag">
        @foreach($post->categories as $category)
            <a href="{{ route('categories.show', $category->slug) }}">{{ $category->name }}</a>
        @endforeach
    </div>

    <h2 class="font-pt mt-2 mb-3">{{ $post->title }}</h2>

    <div class="d-flex align-items-center mb-4 text-muted small">
        <span class="me-4">
            <i class="fa fa-user me-1"></i> {{ $post->user->name ?? 'Onbekende auteur' }}
        </span>
        <span>
            <i class="fa fa-calendar me-1"></i> {{ optional($post->published_at)->format('d F Y') }}
        </span>
    </div>
</div>

@if($post->media)
    <div class="single-post-thumb mb-5">
        <img src="{{ $post->media->url() }}" alt="{{ $post->title }}" class="img-fluid w-100 rounded">
    </div>
@endif

<div class="single-post-text font-pt" style="font-size: 1.1rem; line-height: 1.8;">
    {!! $post->body !!}
</div>
