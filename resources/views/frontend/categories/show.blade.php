<x-frontend.shell
    :title="'Categorie: ' . $category->name"
    :meta-description="'Bekijk alle artikels in de categorie ' . $category->name"
>
    <section class="gazatte-welcome-post section_padding_100">
        <div class="container">

            <div class="row mb-5">
                <div class="col-12 text-center">
                    <span class="text-uppercase text-muted small fw-bold tracking-wide">Categorie</span>
                    <h2 class="font-pt mt-2">{{ $category->name }}</h2>

                    @if(isset($category->description) && $category->description)
                        <p class="text-muted mt-3 mx-auto" style="max-width: 600px;">
                            {{ $category->description }}
                        </p>
                    @endif
                    <hr class="mt-4">
                </div>
            </div>

            <div class="row">
                @forelse($posts as $post)
                    <div class="col-12 col-md-4 mb-5">
                        <div class="gazette-single-todays-post">
                            @if($post->media)
                                <div class="todays-post-thumb mb-3">
                                    <a href="{{ route('posts.show', $post->slug) }}">
                                        <img src="{{ $post->media->url() }}" alt="{{ $post->title }}" class="img-fluid rounded w-100" style="height: 200px; object-fit: cover;">
                                    </a>
                                </div>
                            @endif

                            <div class="todays-post-content">
                                <div class="gazette-post-tag">
                                    @foreach($post->categories->take(2) as $cat)
                                        <a href="{{ route('categories.show', $cat->slug) }}">{{ $cat->name }}</a>
                                    @endforeach
                                </div>

                                <h4>
                                    <a href="{{ route('posts.show', $post->slug) }}" class="font-pt mb-2">{{ $post->title }}</a>
                                </h4>

                                <span class="gazette-post-date mb-2 d-block text-muted">
                                    {{ optional($post->published_at)->format('d F Y') }}
                                </span>

                                <p class="mb-0">
                                    {{ $post->excerpt ?: Str::limit(strip_tags($post->body), 100) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <h4 class="text-muted">Er zijn nog geen gepubliceerde artikels in deze categorie.</h4>
                        <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary mt-3">Bekijk alle artikels</a>
                    </div>
                @endforelse
            </div>

            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                    {{ $posts->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </section>
</x-frontend.shell>
