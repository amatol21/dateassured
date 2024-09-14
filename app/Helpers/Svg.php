<?php

namespace App\Helpers;

class Svg
{
    public static function icon(string $name, int $width = 50, int $height = 50, int $viewBoxSize = 13): string
    {
        $k = $height / $width;
        return '<svg viewBox="0 0 '.$viewBoxSize.' '.round($viewBoxSize * $k).'" width="'.$width.'" height="'.$height.'">'.
            '<use href="/images/icons.svg#'.$name.'"></use></svg>';
    }
}
