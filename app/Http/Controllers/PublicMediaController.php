<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class PublicMediaController extends Controller
{
    public function show(string $path)
    {
        $roots = [
            Storage::disk('public')->path(''),
            public_path('storage'),
        ];

        foreach ($roots as $candidateRoot) {
            $root = realpath($candidateRoot);
            if ($root === false) {
                continue;
            }

            $file = realpath($root . DIRECTORY_SEPARATOR . $path);
            if (
                $file !== false
                && is_file($file)
                && str_starts_with($file, $root . DIRECTORY_SEPARATOR)
            ) {
                return response()->file($file);
            }
        }

        abort(404);
    }
}
