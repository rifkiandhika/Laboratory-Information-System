<?php

namespace App\Http\Controllers;

use App\Models\HasilpemeriksaanImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class HasilImageController extends Controller
{
    public function uploadImages(Request $request)
    {
        // Tambahkan ini untuk debug
        Log::info('Upload Images Request', [
            'nolab' => $request->nolab,
            'has_images' => $request->hasFile('images'),
            'images_count' => $request->hasFile('images') ? count($request->file('images')) : 0
        ]);

        try {
            $request->validate([
                'nolab' => 'required|string',
                'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:3072',
                'descriptions.*' => 'nullable|string'
            ]);

            $nolab = $request->nolab;
            $uploadedFiles = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    Log::info('Processing image', ['index' => $index, 'name' => $image->getClientOriginalName()]);

                    $folder = 'images/hasil-pemeriksaan';
                    if (!file_exists(public_path($folder))) {
                        mkdir(public_path($folder), 0755, true);
                    }

                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $filepath = $folder . '/' . $filename;
                    $fullPath = public_path($filepath);

                    // Move file
                    $image->move(public_path($folder), $filename);
                    Log::info('File moved', ['path' => $fullPath]);

                    // Compress image
                    $compressed = $this->compressImageOnServer($fullPath, 85);
                    Log::info('Compression result', ['success' => $compressed]);

                    // Save to database
                    $imageRecord = HasilpemeriksaanImage::create([
                        'nolab' => $nolab,
                        'image' => $filepath,
                        'description' => $request->descriptions[$index] ?? null
                    ]);

                    $uploadedFiles[] = [
                        'id' => $imageRecord->id,
                        'nolab' => $imageRecord->nolab,
                        'image' => $filepath,
                        'description' => $imageRecord->description
                    ];
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Images berhasil diupload',
                'data' => $uploadedFiles
            ]);
        } catch (ValidationException $e) {
            Log::error('Validation error', ['errors' => $e->errors()]);

            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal: ' . implode(', ', $e->errors()['images.0'] ?? ['File terlalu besar atau format tidak didukung'])
            ], 422);
        } catch (\Exception $e) {
            Log::error('Upload error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Upload gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Compress image on server side
     */
    private function compressImageOnServer(string $filePath, int $quality = 85): bool
    {
        try {
            if (!file_exists($filePath)) {
                Log::warning('File not found: ' . $filePath);
                return false;
            }

            $imageInfo = @getimagesize($filePath);
            if (!$imageInfo) {
                Log::warning('Invalid image: ' . $filePath);
                return false;
            }

            $mime = $imageInfo['mime'];

            // Load image - PASTIKAN FUNGSI INI ADA
            $image = null;
            switch ($mime) {
                case 'image/jpeg':
                    $image = @imagecreatefromjpeg($filePath);
                    break;
                case 'image/png':
                    $image = @imagecreatefrompng($filePath);
                    break;
                case 'image/gif':
                    $image = @imagecreatefromgif($filePath);
                    break;
            }

            if (!$image) {
                Log::warning('Cannot create image resource: ' . $filePath);
                return false;
            }

            $width = imagesx($image);
            $height = imagesy($image);
            $maxWidth = 1920;
            $maxHeight = 1080;

            if ($width > $maxWidth || $height > $maxHeight) {
                $ratio = min($maxWidth / $width, $maxHeight / $height);
                $newWidth = (int)($width * $ratio);
                $newHeight = (int)($height * $ratio);

                $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

                if (!$resizedImage) {
                    return false;
                }

                if (in_array($mime, ['image/png', 'image/gif'])) {
                    imagealphablending($resizedImage, false);
                    imagesavealpha($resizedImage, true);
                    $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
                    imagefilledrectangle($resizedImage, 0, 0, $newWidth, $newHeight, $transparent);
                }

                imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                $image = $resizedImage;
            }

            // Save
            $result = false;
            switch ($mime) {
                case 'image/jpeg':
                    $result = imagejpeg($image, $filePath, $quality);
                    break;
                case 'image/png':
                    $result = imagepng($image, $filePath, (int)round((100 - $quality) / 10));
                    break;
                case 'image/gif':
                    $result = imagegif($image, $filePath);
                    break;
            }

            return $result;
        } catch (\Throwable $e) {
            Log::error('Compression failed', [
                'file' => $filePath,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }


    // Method untuk get images by nolab
    public function getImages($nolab)
    {
        try {
            $images = HasilpemeriksaanImage::where('nolab', $nolab)->get();

            return response()->json([
                'status' => 'success',
                'data' => $images
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Method untuk delete image
    public function deleteImage($id)
    {
        try {
            $image = HasilpemeriksaanImage::findOrFail($id);

            $path = public_path($image->image);

            if (file_exists($path)) {
                unlink($path);
            }

            $image->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Image berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
