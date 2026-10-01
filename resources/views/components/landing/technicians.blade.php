@props(['technicians'])

<section id="teknisi" class="l-section" style="background:#f5f5f7;" aria-labelledby="tech-heading">
    <div class="max-w-5xl mx-auto px-5 sm:px-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-12 reveal">
            <div>
                <p class="text-xs font-bold tracking-widest uppercase text-[#0071e3] mb-3">Teknisi Terverifikasi</p>
                <h2 id="tech-heading" class="font-bold tracking-[-0.025em] text-[#1d1d1f]"
                    style="font-size: clamp(1.875rem, 4vw, 3rem);">
                    Butuh ahli?<br>Temukan teknisi yang tepat.
                </h2>
            </div>
            <a href="{{ route('technicians.index') }}" class="link-arrow text-base flex-shrink-0">
                Lihat semua teknisi <span aria-hidden="true">›</span>
            </a>
        </div>

        {{-- Technician cards --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($technicians as $idx => $tech)
            <article class="reveal reveal-d{{ $idx + 1 }} card-lift bg-white rounded-[24px] p-6 border border-gray-100 relative">

                {{-- Verified badge --}}
                <div class="absolute top-5 right-5 flex items-center gap-1.5 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-full">
                    <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-emerald-700 text-xs font-semibold">Verified</span>
                </div>

                {{-- Avatar --}}
                <div class="flex items-center gap-4 mb-5">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white font-bold text-lg flex-shrink-0"
                         style="background: {{ $tech['color'] }};"
                         role="img" aria-label="Avatar {{ $tech['name'] }}">
                        {{ $tech['initial'] }}
                    </div>
                    <div>
                        <h3 class="font-bold text-[#1d1d1f] text-base">{{ $tech['name'] }}</h3>
                        <p class="text-[#6e6e73] text-sm">{{ $tech['specialization'] }}</p>
                    </div>
                </div>

                {{-- Rating --}}
                <div class="flex items-center gap-2 mb-4">
                    <div class="flex gap-0.5" aria-label="Rating {{ $tech['rating'] }} dari 5">
                        @for($s = 0; $s < 5; $s++)
                        <svg class="w-3.5 h-3.5 {{ $s < floor($tech['rating']) ? 'text-yellow-400' : 'text-gray-200' }}"
                             fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        @endfor
                    </div>
                    <span class="text-sm font-semibold text-[#1d1d1f]">{{ $tech['rating'] }}</span>
                    <span class="text-sm text-[#6e6e73]">({{ $tech['reviews'] }} ulasan)</span>
                </div>

                {{-- Meta --}}
                <div class="space-y-2 mb-5">
                    <div class="flex items-center gap-2 text-sm text-[#6e6e73]">
                        <svg class="w-4 h-4 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $tech['area'] }}
                    </div>
                    <div class="flex items-center gap-2 text-sm text-[#6e6e73]">
                        <svg class="w-4 h-4 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $tech['experience'] }} tahun pengalaman
                    </div>
                </div>

                {{-- Fee & CTA --}}
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <div>
                        <p class="text-xs text-[#6e6e73]">Mulai dari</p>
                        <p class="font-bold text-[#1d1d1f]">Rp {{ number_format($tech['fee'], 0, ',', '.') }}<span class="text-[#6e6e73] font-normal">/kunjungan</span></p>
                    </div>
                    <a href="{{ route('technicians.show', ['technician' => 1]) }}"
                       class="btn-pill btn-outline text-sm py-2 px-4"
                       aria-label="Lihat profil {{ $tech['name'] }}">
                        Lihat profil
                    </a>
                </div>

            </article>
            @endforeach
        </div>

    </div>
</section>
