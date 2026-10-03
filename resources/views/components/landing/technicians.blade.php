@props(['technicians'])

{{-- Reviews / Testimonials section (Maverick style) --}}
<section id="teknisi" class="l-section bg-white" aria-labelledby="tech-heading">
    <div class="max-w-6xl mx-auto px-5 sm:px-8">

        {{-- Header --}}
        <div class="grid lg:grid-cols-2 gap-8 mb-12 reveal">
            <div>
                <p class="eyebrow text-fm-primary mb-4">Teknisi Terverifikasi</p>
                <h2 id="tech-heading" class="display-lg text-fm-dark"
                    style="font-size: clamp(1.875rem, 4vw, 3rem);">
                    Rasakan perbedaan FIXMATE
                </h2>
                <p class="body-lg mt-4">Pengalaman nyata dari pengguna yang mengandalkan kami.</p>
            </div>
            <div class="flex items-end lg:justify-end">
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2.5 bg-fm-light rounded-xl px-4 py-2.5">
                        <div class="flex gap-0.5">
                            @for($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 text-fm-accent" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <span class="font-bold text-fm-dark" style="font-size:.875rem;font-variant-numeric:tabular-nums;">4.9</span>
                        <span class="text-fm-muted" style="font-size:.8125rem;">500+ ulasan</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Review cards (Maverick testimonial style) --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($technicians as $idx => $tech)
            <article class="reveal reveal-d{{ $idx + 1 }} review-card card-lift relative">

                {{-- Stars --}}
                <div class="flex items-center gap-2.5 mb-5">
                    <span class="font-bold text-fm-dark" style="font-size:.875rem;font-variant-numeric:tabular-nums;">5.0</span>
                    <div class="flex gap-0.5">
                        @for($s = 0; $s < 5; $s++)
                        <svg class="w-4 h-4 text-fm-accent" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                </div>

                {{-- Review text --}}
                <p class="text-fm-dark mb-6" style="font-size:.9375rem;line-height:1.75;letter-spacing:-.005em;">
                    @php
                        $reviews = [
                            'AC kantor tiba-tiba mati total. Pakai FIXMATE, dalam 5 menit dapat diagnosis yang jelas — kompresor bermasalah. Langsung booking teknisi dari app, besoknya sudah beres.',
                            'Laptop sering overheat dan tiba-tiba mati. Upload foto motherboard, sistem langsung kasih tahu kipas internal perlu diganti. Panduan perbaikannya detail banget.',
                            'Kulkas bunyi keras tengah malam. Diagnosis bilang bearing kipas aus. Teknisi dari FIXMATE datang tepat waktu, tarif sesuai estimasi. Sangat recommended!',
                        ];
                    @endphp
                    {{ $reviews[$idx] ?? 'Pelayanan sangat baik dan diagnosis akurat.' }}
                </p>

                {{-- Author --}}
                <div class="flex items-center gap-3 pt-5 border-t border-gray-100">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0" style="font-size:.8125rem;background: {{ $tech['color'] }};">
                        {{ $tech['initial'] }}
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-1.5">
                            <p class="font-bold text-fm-dark" style="font-size:.875rem;letter-spacing:-.01em;">{{ $tech['name'] }}</p>
                            <svg class="w-3.5 h-3.5 text-fm-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        </div>
                        <p class="text-fm-muted" style="font-size:.8125rem;letter-spacing:.005em;">{{ $tech['area'] }} · {{ $tech['experience'] }} thn pengalaman</p>
                    </div>
                </div>

            </article>
            @endforeach
        </div>

        {{-- CTA --}}
        <div class="text-center mt-12 reveal">
            <a href="{{ route('technicians.index') }}" class="link-arrow text-base">
                Lihat semua teknisi <span aria-hidden="true">→</span>
            </a>
        </div>

    </div>
</section>
