<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

if (!function_exists('uploadImage')) {

    function uploadImage(UploadedFile $file, string $folder = 'uploads', ?string $oldPath = null): ?string
    {
        $disk = Storage::disk('public');
        
        if (!$disk->exists($folder)) {
            $disk->makeDirectory($folder);
        }


        if ($oldPath && $disk->exists($oldPath)) {
            $disk->delete($oldPath);
        }

        $path = $file->store($folder, 'public');

        return $path;
    }
}