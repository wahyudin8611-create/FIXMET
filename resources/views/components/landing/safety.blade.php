<section class="l-section dark-section" aria-labelledby="safety-heading">
    <div class="max-w-6xl mx-auto px-5 sm:px-8">

        <div class="text-center mb-14 reveal">
            <p class="eyebrow text-fm-accent mb-4">Keselamatan</p>
            <h2 id="safety-heading" class="display-lg text-white mb-6"
                style="font-size: clamp(1.875rem, 4vw, 3rem);">
                Aman dulu,<br>baru diperbaiki.
            </h2>
            <p class="max-w-lg mx-auto" style="font-size:1.125rem;line-height:1.75;color:rgba(255,255,255,.5);">
                Setiap diagnosis dilengkapi label risiko. FIXMET tidak mendorong kamu
                memperbaiki sesuatu yang berbahaya sendirian.
            </p>
        </div>

        @php
            $levels = [
                ['key' => 'LOW', 'label' => 'Low', 'class' => 'badge-low', 'desc' => 'Perbaikan ringan, tidak memerlukan alat khusus, aman dilakukan sendiri.', 'examples' => 'Ganti filter, bersihkan debu, reset perangkat', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['key' => 'MEDIUM', 'label' => 'Medium', 'class' => 'badge-medium', 'desc' => 'Perlu kehati-hatian. Baca panduan lengkap sebelum mencoba sendiri.', 'examples' => 'Ganti layar laptop, perbaiki kipas angin', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['key' => 'HIGH', 'label' => 'High', 'class' => 'badge-high', 'desc' => 'Sistem menyarankan teknisi. Berisiko jika dikerjakan tanpa keahlian.', 'examples' => 'Kompresor AC, komponen kelistrikan utama', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
                ['key' => 'CRITICAL', 'label' => 'Critical', 'class' => 'badge-critical', 'desc' => 'Hubungi teknisi atau profesional. Jangan coba sendiri.', 'examples' => 'Gas bocor, baterai lithium, tegangan tinggi', 'icon' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636'],
            ];
        @endphp

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($levels as $idx => $level)
            <div class="reveal reveal-d{{ $idx + 1 }} rounded-2xl p-6"
                 style="background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.06);">
                <div class="flex items-center gap-3 mb-5">
                    <span class="{{ $level['class'] }} inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full font-bold" style="font-size:.6875rem;letter-spacing:.02em;">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $level['icon'] }}"/>
                        </svg>
                        {{ $level['label'] }}
                    </span>
                </div>
                <p class="mb-3" style="font-size:.875rem;line-height:1.7;color:rgba(255,255,255,.65);">{{ $level['desc'] }}</p>
                <p style="font-size:.8125rem;line-height:1.6;color:rgba(255,255,255,.28);">Contoh: {{ $level['examples'] }}</p>
            </div>
            @endforeach
        </div>

        <p class="text-center mt-10 reveal max-w-xl mx-auto" style="font-size:.8125rem;line-height:1.65;color:rgba(255,255,255,.22);">
            Untuk perangkat dengan risiko yang melibatkan gas, listrik tegangan tinggi, baterai lithium, atau kendaraan,
            FIXMET secara default menyarankan teknisi terverifikasi.
        </p>

    </div>
</section>
