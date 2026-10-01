<section class="l-section dark-section relative overflow-hidden" aria-labelledby="cta-heading">

    {{-- Background decoration --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
        <div style="position:absolute;top:-200px;left:-200px;width:600px;height:600px;background:radial-gradient(ellipse at center,rgba(0,113,227,.12) 0%,transparent 65%);border-radius:50%;"></div>
        <div style="position:absolute;bottom:-150px;right:-100px;width:500px;height:500px;background:radial-gradient(ellipse at center,rgba(88,86,214,.1) 0%,transparent 65%);border-radius:50%;"></div>
    </div>

    <div class="relative max-w-3xl mx-auto px-5 sm:px-8 text-center">

        <div class="reveal">
            <p class="text-xs font-bold tracking-widest uppercase text-blue-400 mb-5">Mulai Sekarang</p>
            <h2 id="cta-heading" class="font-bold tracking-[-0.03em] text-white mb-6"
                style="font-size: clamp(2rem, 5.5vw, 4rem); line-height: 1.08;">
                Perangkatmu bermasalah?<br>Mulai dari satu foto.
            </h2>
            <p class="text-white/55 max-w-md mx-auto mb-10 font-light text-lg leading-relaxed">
                Diagnosis, panduan perbaikan, dan teknisi terverifikasi — semua dalam satu platform.
            </p>
        </div>

        <div class="reveal reveal-d1 flex flex-wrap justify-center gap-4">
            @auth
            <a href="{{ route('diagnosis.create') }}" class="btn-pill btn-white text-base px-8 py-3.5 font-semibold">
                Mulai Diagnosis
            </a>
            @else
            <a href="{{ route('diagnosis.create') }}" class="btn-pill btn-white text-base px-8 py-3.5 font-semibold">
                Mulai Diagnosis
            </a>
            @endauth
            <a href="{{ route('register.technician') }}" class="btn-pill btn-white-outline text-base px-8 py-3.5">
                Daftar Sebagai Teknisi
            </a>
        </div>

        <p class="reveal reveal-d2 text-white/25 text-xs mt-8">
            Gratis untuk pengguna. Teknisi mendaftar dan menunggu verifikasi tim kami.
        </p>

    </div>
</section>
