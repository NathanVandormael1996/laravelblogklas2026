<div class="gazette-post-discussion-area mt-5 pt-5 border-top">
    <h3 class="font-pt mb-4">Discussie</h3>

    <div class="single-comment d-flex mb-4">
        <div class="comment-author-avatar me-3">
            <img src="{{ asset('frontend/gazette/img/core-img/logo.png') }}" alt="Avatar" style="width: 50px; height: 50px; border-radius: 50%; background: #eee; object-fit: contain; padding: 5px;">
        </div>
        <div class="comment-content p-4 bg-light rounded" style="flex: 1;">
            <h5 class="font-pt mb-1">Gazette Redactie</h5>
            <span class="text-muted small mb-2 d-block">{{ now()->format('d F Y') }}</span>
            <p class="mb-0">Bedankt voor het lezen van dit artikel! Reacties zijn momenteel gesloten voor deze post, maar blijf onze blog volgen voor meer updates.</p>
        </div>
    </div>

    <div class="leave-comment-area mt-5">
        <h4 class="font-pt mb-4">Laat een reactie achter</h4>
        <form action="#" method="get" onsubmit="event.preventDefault(); alert('Reacties zijn momenteel uitgeschakeld.');">
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <input type="text" class="form-control" placeholder="Naam" disabled>
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <input type="email" class="form-control" placeholder="Email" disabled>
                </div>
                <div class="col-12 mb-3">
                    <textarea class="form-control" rows="5" placeholder="Bericht" disabled></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-secondary w-100" disabled>Plaats Reactie (Binnenkort beschikbaar)</button>
                </div>
            </div>
        </form>
    </div>
</div>
