{{-- Hasil analisis foto oleh AI. Hanya tampil jika analisis berhasil dijalankan. --}}
@php
    $evidence = $consultation->visual_evidence;
    $symptomQuestions = $consultation->answers->mapWithKeys(fn ($answer) => [$answer->symptom_id => $answer->symptom?->question]);
    $userAnswers = $consultation->answers->pluck('answer', 'symptom_id');
    $judgedSymptoms = collect($evidence['symptoms'] ?? [])->where('assessment', '!==', 'not_determinable');
    $undeterminedCount = collect($evidence['symptoms'] ?? [])->where('assessment', 'not_determinable')->count();
@endphp

@if($evidence)
<div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-5">
    <div class="flex items-center justify-between gap-3 px-5 py-4 border-b border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-fm-primary/10 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-fm-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z"/></svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900">Analisis Foto AI</h3>
                <p class="text-xs text-fm-muted">Temuan dari foto yang Anda unggah</p>
            </div>
        </div>
        @php
            $qualityBadge = match ($evidence['image_quality'] ?? null) {
                'clear' => ['Foto jelas', 'bg-emerald-50 text-emerald-700'],
                'unclear' => ['Foto kurang jelas', 'bg-amber-50 text-amber-700'],
                default => ['Foto tidak sesuai', 'bg-red-50 text-red-700'],
            };
        @endphp
        <span class="text-xs font-semibold px-2.5 py-1 rounded-full whitespace-nowrap {{ $qualityBadge[1] }}">{{ $qualityBadge[0] }}</span>
    </div>

    <div class="p-5 space-y-4">
        @if(($evidence['image_quality'] ?? null) === 'unclear')
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 text-sm text-amber-800">
                Foto kurang jelas, sehingga tidak dipakai untuk menghitung skor diagnosis. Coba foto ulang dengan cahaya cukup dan fokus pada bagian yang rusak.
            </div>
        @elseif(($evidence['image_quality'] ?? null) === 'unrelated')
            <div class="bg-red-50 border border-red-200 rounded-xl p-3 text-sm text-red-800">
                Foto tidak menunjukkan {{ $consultation->device->name }}, sehingga tidak dipakai untuk menghitung skor diagnosis. Pastikan foto memperlihatkan perangkat yang rusak.
            </div>
        @endif

        @if(filled($evidence['summary'] ?? null))
            <p class="text-sm text-gray-700 leading-relaxed">{{ $evidence['summary'] }}</p>
        @endif

        @if(!empty($evidence['visual_conditions']))
            <div>
                <p class="text-xs font-semibold text-fm-muted uppercase tracking-wide mb-2">Kerusakan yang terlihat</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($evidence['visual_conditions'] as $condition)
                        <span class="text-xs font-medium bg-fm-accent/15 text-amber-800 border border-fm-accent/40 px-2.5 py-1 rounded-full">{{ $condition }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        @if($judgedSymptoms->isNotEmpty())
            <div>
                <p class="text-xs font-semibold text-fm-muted uppercase tracking-wide mb-2">Gejala yang dinilai dari foto</p>
                <div class="space-y-2">
                    @foreach($judgedSymptoms as $item)
                        @php
                            $isVisible = $item['assessment'] === 'visible';
                            $userAnswer = $userAnswers[$item['symptom_id']] ?? null;
                        @endphp
                        <div class="flex items-start gap-3 p-3 rounded-xl {{ $isVisible ? 'bg-emerald-50/60' : 'bg-amber-50/60' }}">
                            @if($isVisible)
                                <svg class="w-5 h-5 text-fm-primary shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            @else
                                <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">{{ $symptomQuestions[$item['symptom_id']] ?? 'Gejala' }}</p>
                                <p class="text-xs mt-0.5 {{ $isVisible ? 'text-fm-primary-dark' : 'text-amber-700' }}">
                                    {{ $isVisible ? 'Terlihat di foto' : 'Foto menunjukkan sebaliknya' }}
                                    · keyakinan {{ number_format($item['confidence'] * 100, 0) }}%
                                    @if($userAnswer !== null)
                                        · jawaban Anda: {{ $userAnswer ? 'Ya' : 'Tidak' }}
                                    @endif
                                </p>
                                @if(filled($item['reason']))
                                    <p class="text-xs text-gray-600 mt-1">{{ $item['reason'] }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($undeterminedCount > 0)
            <p class="text-xs text-fm-muted">{{ $undeterminedCount }} gejala lain tidak bisa dinilai dari foto (misalnya bunyi, bau, atau performa), sehingga hanya dinilai dari jawaban Anda.</p>
        @endif

        <p class="text-xs text-fm-muted border-t border-gray-100 pt-3">
            Analisis AI adalah pendukung, bukan kepastian. Diagnosis tetap ditentukan dari jawaban Anda, lalu skornya disesuaikan maksimal ±25% berdasarkan bukti foto.
        </p>
    </div>
</div>
@endif
