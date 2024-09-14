<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UploadController extends Controller
{
    public function image(Request $request)
    {
        if ($request->files->count() > 0) {
            $hash = Str::random();
            $path = 'uploads/images/'.substr($hash, 0, 2).'/'.substr($hash, 2, 4).'/'.substr($hash, 4);

            /** @var UploadedFile $file */
            foreach($request->files->all() as $file) {
                Log::info(var_export($request->files->all(), true));
                $path = $path . '.' . $file->getClientOriginalExtension();
                $img = Image::make($file->getPathname());
                $img->orientate();
                $ratio = $img->getWidth() / $img->getHeight();
                $size = min(1200, max($img->getWidth(), $img->getHeight()));

                if ($ratio >= 1) {
                    $w = $size;
                    $h = round($w / $ratio);
                } else {
                    $h = $size;
                    $w = round($h * $ratio);
                }
                $img->fit($w, $h);
                $res = $img->stream('jpg')->detach();

                Storage::disk('s3')->put($path, $res, 'public');
                return [
                    'filename' => $file->getFilename(),
                    'uploaded' => 1,
                    'url' => env('CLOUDFRONT_DOMAIN', '').'/'.$path
                ];
            }
        }
    }
}
