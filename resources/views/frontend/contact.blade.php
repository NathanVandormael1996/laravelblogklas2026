<x-frontend.shell title="Contact" meta-description="Neem contact met ons op via dit formulier.">
    <section class="section_padding_100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    <div class="contact-form-area bg-light p-5 rounded shadow-sm">
                        <h2 class="font-pt mb-3">Contact</h2>
                        <p class="text-muted mb-5">
                            Heb je een vraag of opmerking? Laat het ons weten via onderstaand formulier!
                        </p>

                        <form action="#" method="GET" onsubmit="event.preventDefault(); alert('Dit is een demo formulier. Er wordt geen echte e-mail verzonden.');">
                            <div class="form-group mb-4">
                                <label for="name" class="font-weight-bold">Naam</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Jouw naam" required>
                            </div>

                            <div class="form-group mb-4">
                                <label for="email" class="font-weight-bold">E-mail</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="jouw@email.com" required>
                            </div>

                            <div class="form-group mb-4">
                                <label for="message" class="font-weight-bold">Bericht</label>
                                <textarea name="message" id="message" rows="6" class="form-control" placeholder="Wat wil je ons vertellen?" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-dark w-100 py-2 mt-2">Verzenden</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-frontend.shell>
