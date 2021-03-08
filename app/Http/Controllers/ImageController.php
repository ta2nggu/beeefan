<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\File;

class ImageController extends Controller
{
    public function getPubliclyStorgeFile($filename)
    {
        $path = storage_path('app/public/images/'. $filename);
//        $path = storage_path('images/18/47/'. $filepath);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);

        $response->header("Content-Type", $type);

        return $response;

    }
}
