<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageAnalysisService
{
    private const ALLOWED_MIMES = ['image/jpeg', 'image/png', 'image/webp'];
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp'];
    private const MAX_SIZE_KB = 5120; // 5MB

    public function validateImage(UploadedFile $file): array
    {
        $errors = [];

        if (!in_array($file->getMimeType(), self::ALLOWED_MIMES)) {
            $errors[] = 'Format file tidak didukung. Gunakan JPG, PNG, atau WebP.';
        }

        if (!in_array(strtolower($file->getClientOriginalExtension()), self::ALLOWED_EXTENSIONS)) {
            $errors[] = 'Ekstensi file tidak valid.';
        }

        if ($file->getSize() > self::MAX_SIZE_KB * 1024) {
            $errors[] = 'Ukuran file terlalu besar. Maksimal 5MB.';
        }

        return $errors;
    }

    public function storeImage(UploadedFile $file, string $folder = 'consultations'): string
    {
        $year = date('Y');
        $month = date('m');
        $filename = Str::uuid() . '.' . strtolower($file->getClientOriginalExtension());
        $path = "{$folder}/{$year}/{$month}/{$filename}";

        Storage::disk('public')->put($path, file_get_contents($file->getRealPath()));

        return $path;
    }

    public function analyzeImage(string $imagePath): array
    {
        // Stub: returns possible visual conditions based on filename/basic detection
        // In production, this would call an AI Vision API (e.g., Google Vision, OpenAI Vision)
        return [
            'detected_objects' => ['electronic_device'],
            'visual_conditions' => [],
            'confidence' => 0.0,
            'note' => 'Analisis visual tidak tersedia. Diagnosis berdasarkan gejala yang Anda berikan.',
        ];
    }

    public function extractVisualEvidence(array $aiOutput): array
    {
        return [
            'objects' => $aiOutput['detected_objects'] ?? [],
            'conditions' => $aiOutput['visual_conditions'] ?? [],
            'confidence' => $aiOutput['confidence'] ?? 0,
        ];
    }

    public function deleteImage(string $path): void
    {
        Storage::disk('public')->delete($path);
    }
}
