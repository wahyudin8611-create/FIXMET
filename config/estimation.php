<?php

/*
|--------------------------------------------------------------------------
| Estimasi Biaya Perbaikan
|--------------------------------------------------------------------------
|
| Parameter untuk menghitung estimasi biaya:
|   Estimasi = Biaya Jasa Teknisi + Harga Suku Cadang + Tingkat Kerumitan
|
| Nilai suku cadang & kerumitan dipakai sebagai fallback aturan ketika AI
| tidak tersedia, dan sebagai acuan/validasi hasil AI.
|
*/

return [

    'currency' => 'IDR',

    // Acuan tarif jasa PER JAM bila belum ada teknisi untuk dihitung mediannya.
    'default_hourly' => 100_000,

    // Perkiraan jam kerja teknisi per tingkat kerusakan (fallback non-AI).
    'hours_by_level' => [
        'ringan' => 1,
        'sedang' => 2,
        'berat' => 4,
    ],
    'max_hours' => 24,

    // Biaya Layanan Platform = flat + persen dari biaya jasa.
    'platform_fee' => [
        'flat' => 10_000,
        'percent_of_labor' => 10, // 10% dari (tarif/jam × jam)
    ],

    // Pemetaan severity diagnosis (expert system) → tingkat kerusakan tampilan.
    'severity_to_level' => [
        'low' => 'ringan',
        'medium' => 'sedang',
        'high' => 'berat',
        'critical' => 'berat',
    ],

    // Batas wajar hasil AI agar tidak ngawur (dalam rupiah).
    'max_part_price' => 50_000_000,
    'max_complexity_fee' => 1_000_000,
    'max_parts' => 6,

    // Rentang harga suku cadang (fallback non-AI) per kata kunci kategori/
    // perangkat dan tingkat kerusakan. Format: [min, max].
    'parts_baseline' => [
        'hp' => ['ringan' => [75_000, 200_000], 'sedang' => [250_000, 600_000], 'berat' => [600_000, 1_500_000]],
        'laptop' => ['ringan' => [100_000, 300_000], 'sedang' => [400_000, 900_000], 'berat' => [900_000, 2_500_000]],
        'komputer' => ['ringan' => [100_000, 300_000], 'sedang' => [400_000, 900_000], 'berat' => [900_000, 2_500_000]],
        'ac' => ['ringan' => [100_000, 250_000], 'sedang' => [350_000, 800_000], 'berat' => [800_000, 2_000_000]],
        'kulkas' => ['ringan' => [100_000, 300_000], 'sedang' => [400_000, 900_000], 'berat' => [900_000, 2_200_000]],
        'mesin cuci' => ['ringan' => [100_000, 250_000], 'sedang' => [350_000, 800_000], 'berat' => [800_000, 1_800_000]],
        'tv' => ['ringan' => [100_000, 300_000], 'sedang' => [400_000, 900_000], 'berat' => [900_000, 2_500_000]],
    ],

    // Dipakai bila kategori perangkat tidak dikenal.
    'parts_default' => [
        'ringan' => [75_000, 200_000],
        'sedang' => [300_000, 700_000],
        'berat' => [700_000, 1_800_000],
    ],
];
