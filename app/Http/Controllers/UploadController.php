<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        // Mendukung format upload Summernote (file) atau CKEditor (upload)
        $fileKey = $request->hasFile('upload') ? 'upload' : ($request->hasFile('file') ? 'file' : null);

        if ($fileKey) {
            // Validasi file
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                $fileKey => 'image|mimes:jpeg,png,jpg,gif|max:500', // Max 500KB
            ], [
                "$fileKey.max" => 'Ukuran gambar terlalu besar! Maksimal adalah 500KB.',
                "$fileKey.image" => 'File yang diunggah harus berupa gambar.',
                "$fileKey.mimes" => 'Format gambar harus jpeg, png, jpg, atau gif.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'uploaded' => 0,
                    'error' => [
                        'message' => $validator->errors()->first($fileKey)
                    ]
                ], 400);
            }

            $originName = $request->file($fileKey)->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file($fileKey)->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file($fileKey)->move(public_path('uploads/editor'), $fileName);

            $url = asset('uploads/editor/' . $fileName);

            // Summernote biasanya hanya butuh URL string atau json sederhana
            // CKEditor butuh format spesifik. Kita dukung keduanya.
            if ($request->has('upload')) {
                return response()->json([
                    'fileName' => $fileName,
                    'uploaded' => 1,
                    'url' => $url
                ]);
            }

            return response()->json($url);
        }

        return response()->json([
            'uploaded' => 0,
            'error' => ['message' => 'Gagal mengunggah gambar.']
        ], 400);
    }

    public function deleteImage(Request $request)
    {
        $src = $request->src;
        if (!$src) {
            return response()->json(['success' => false, 'message' => 'No source provided'], 400);
        }

        // Ambil path relatif dari URL
        // Contoh URL: http://localhost:8000/uploads/editor/image_123.jpg
        // Kita butuh: uploads/editor/image_123.jpg
        $path = str_replace(asset(''), '', $src);
        $fullPath = public_path($path);

        if (file_exists($fullPath)) {
            unlink($fullPath);
            return response()->json(['success' => true, 'message' => 'File deleted successfully']);
        }

        return response()->json(['success' => false, 'message' => 'File not found: ' . $fullPath], 404);
    }
}
