<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Models\File;

class FileController extends Controller
{
    public function show(File $file)
    {
        abort_if(!$file->if_exists, 404);

        return response()->file($file->filepath);
    }

    public function download(File $file)
    {
        return $file->download ?? abort(404);
    }
}
