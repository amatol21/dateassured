<?php

namespace App\Traits;

use App\Enums\Size;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait ImageContainer
{
    private ?array $_imagesData = null;
    private static array $_allowedExtensions = ['jpg', 'jpeg', 'png', 'bmp', 'webp'];

    protected function getImagePathPrefix() : string
    {
        return 'uploads';
    }

    protected function getImageUrlPrefix() : string
    {
        return env('CLOUDFRONT_DOMAIN', '');
    }

    protected function getImageFieldName() : string
    {
        return 'image_json';
    }

    protected function getImageStorageName() : string
    {
        return 's3';
    }

    /**
     * Returns available sizes of the image.
     * Please use Size enum for keys.
     *
     * @return int[]
     */
    protected function getImageSizes() : array
    {
        return [
            Size::SMALLEST->value => 50,
            Size::SMALL->value    => 120,
            Size::MEDIUM->value   => 240
        ];
    }

    /**
     * Returns ratio of the image.
     * Zero - free aspect ratio.
     *
     * @return float
     */
    public function getImageAspectRatio() : float
    {
        return 0;
    }


    public function getDefaultImageUrl() : string
    {
        return '/img/defaults/image.jpg';
    }


    public function getImageUrl(Size $size = Size::LARGE) : string
    {
        $this->prepareImagesData();
        if (array_key_exists($size->value, $this->_imagesData)) {
            $t = array_key_exists('t', $this->_imagesData) ? '?t='.$this->_imagesData['t'] : '';
            return $this->getImageUrlPrefix().'/'.$this->_imagesData[$size->value].$t;
        }
        return $this->getDefaultImageUrl();
    }


    private function prepareImagesData(): void
    {
        if ($this->_imagesData === null) {
            try {

                $this->_imagesData = json_decode($this->{$this->getImageFieldName()}, true);
                if (!is_array($this->_imagesData)) $this->_imagesData = [];
            } catch (Exception) {
                $this->_imagesData = [];
            }
        }
    }


    public function setFromFile(UploadedFile|string $file): void
    {
        $this->prepareImagesData();
        $hash = Str::random();
        $path = $this->getImagePathPrefix().'/'.substr($hash, 0, 2).'/'.substr($hash, 2, 4).'/'.substr($hash, 4);

        $img = Image::make(is_string($file) ? $file : $file->getPathname());
        $img->orientate();

        $storage = Storage::disk($this->getImageStorageName());
        $sizesConf = $this->getImageSizes();
        $sizes = [Size::LARGEST, Size::LARGE, Size::MEDIUM, Size::SMALL, Size::SMALLEST];
        $ratio = $this->getImageAspectRatio();

        foreach ($sizes as $size) {
            if (array_key_exists($size->value, $sizesConf)) {
                // Fit image to necessary size.
                if ($ratio >= 1) {
                    $w = $sizesConf[$size->value];
                    $h = round($w / $ratio);
                } else {
                    $h = $sizesConf[$size->value];
                    $w = round($h * $ratio);
                }

                $img->fit($w, $h);

                // Save image.
                $res = $img->stream('jpg')->detach();
                $name = array_key_exists($size->value, $this->_imagesData)
                    ? $this->_imagesData[$size->value]
                    : $path.'_'.$size->value.'.jpg';
                $putResult = $storage->put($name, $res, 'public');
                if (!$putResult) {
                    Log::info("Failed to store file to " . $this->getImageStorageName() . " storage");
                }
                $this->_imagesData[$size->value] = $name;
            }
        }
        $this->_imagesData['t'] = time();
        $this->{$this->getImageFieldName()} = json_encode($this->_imagesData);
    }
}
