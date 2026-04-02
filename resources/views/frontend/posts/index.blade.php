<x-frontend.shell title="Alle Artikels" meta-description="Ontdek al onze gepubliceerde artikels.">
    <section class="gazatte-welcome-post section_padding_100">
        <div class="container">

            <div class="row mb-5">
                <div class="col-12">
                    <h2 class="font-pt">
                        @if(request('search'))
                            Zoekresultaten voor: "{{ request('search') }}"
                        @else
                            Alle Gepubliceerde Artikels
                        @endif
                    </h2>
                    <hr>
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
                                    @foreach($post->categories->take(2) as $category)
                                        <a href="{{ route('categories.show', $category->slug) }}">{{ $category->name }}</a>
                                    @endforeach
                                </div>

                                <h4>
                                    <a href="{{ route('posts.show', $post->slug) }}" class="font-pt mb-2">{{ $post->title }}</a>
                                </h4>

                                <span class="gazette-post-date mb-2 d-block text-muted">
                                    {{ optional($post->published_at)->format('d F Y') }}
                                </span>

                                <p class="mb-0">
                                    {{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->body), 100) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <h4 class="text-muted">Geen artikels gevonden.</h4>
                        <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary mt-3">Verwijder filters</a>
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
