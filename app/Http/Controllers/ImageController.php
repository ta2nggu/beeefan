<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImageController extends Controller
{
//    21.02.23 김태영, 이거 중복선언하면 안되는듯..
//    public function __construct(){
//        $this->middleware('role:creator');
//    }

    public function index() {
        return view('welcome');
    }
    public function store(Request $request) {
        $request->validate([
            'file_name.*' => 'image|mimes:jpg,jpeg,png,gif,bmp',
        ]);

        $images = $this->uploadFiles($request);

        foreach ($images as $imageFile) {
            list($fileName, $title) = $imageFile;

            $image = new Image();
            $image->title = $title;
            $image->file_name = $fileName;
            $image->save();
        }

        return response()->json([
            'uploaded' => true
        ]);
        //return redirect('/creator_write')->with('message', 'Your image successfully uploaded!');
    }
    protected function uploadFiles($request) {
        $uploadedImages = [];

        if ($request->hasFile('file_name')) {
            $images = $request->file('file_name');

            foreach ($images as $image) {
                $uploadedImages[] = $this->uploadFile($image);
            }
        }

        return $uploadedImages;
    }

    protected  function uploadFile($image) {
        $originalFileName = $image->getClientOriginalName();
        $extension = $image->getClientOriginalExtension();
        $fileNameOnly = pathinfo($originalFileName, PATHINFO_FILENAME);
        $fileName = Str::slug($fileNameOnly)."-".time().$extension;

        $uploadedFileName = $image->storeAs('public', $fileName);

        return [$uploadedFileName, $fileNameOnly];
    }
}
