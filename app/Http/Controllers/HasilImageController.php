<?php

namespace App\Http\Controllers;

use App\Models\HasilpemeriksaanImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HasilImageController extends Controller
{
    public function uploadImages(Request $request)
    {
        // dd($request->all());
        try {
            $request->validate([
                'nolab' => 'required|string',
                'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'descriptions.*' => 'nullable|string'
            ]);

            $nolab = $request->nolab;
            $uploadedFiles = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {

                    // Buat folder jika belum ada
                    $folder = 'images/hasil-pemeriksaan';
                    if (!file_exists(public_path($folder))) {
                        mkdir(public_path($folder), 0777, true);
                    }

                    // Nama file baru
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                    // Pindahkan file ke folder public
                    $image->move(public_path($folder), $filename);

                    $filepath = $folder . '/' . $filename;

                    // Simpan ke database
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
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
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
