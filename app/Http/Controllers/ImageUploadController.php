<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

// Assuming you have an Image model
class ImageUploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.webp';

            // Compress and convert to WebP
            $compressedImage = Image::make($image)
                ->encode('webp', 75); // Adjust quality as needed
            $path = $this->checkFolder();

            // Save the compressed and converted image
            $compressedImage->save($path.'/'.$imageName);

            // Save the image path to the database or do further processing

            return response()->json(['success' => 'Image uploaded successfully.', 'image_path' => '/'.$path.'/'.$imageName]);
        }

        return response()->json(['error' => 'Image upload failed.']);
    }

    public function checkFolder(){
        $yFolder = "uploads/" . date("Y");
        if (!file_exists($yFolder)) {
            mkdir($yFolder, 0777, true);
            $myfile = fopen($yFolder . "/index.html", "w");
            fclose($myfile);
        }
        $ym = date("Y") . "/" . date("m") . "/";
        $ym1 = "uploads/" . date("Y") . "/" . date("m");
        if (!file_exists($ym1)) {
            mkdir($ym1, 0777, true);
            $myfile = fopen($ym1 . "/index.html", "w");
            fclose($myfile);
        }
        return $ym1;

    }
}
