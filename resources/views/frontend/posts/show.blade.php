<x-frontend.shell
    :title="$post->title"
    :meta-description="$post->excerpt ?? Str::limit(strip_tags($post->body), 150)"
>
    <section class="single-post-area section_padding_100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">

                    <x-frontend.posts.single-content :post="$post" />
                    <x-frontend.posts.discussion-area />

                </div>
            </div>
        </div>
    </section>
</x-frontend.shell>
