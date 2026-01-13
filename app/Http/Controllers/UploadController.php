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
}
