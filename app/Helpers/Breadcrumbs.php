<?php

namespace App\Helpers;

class Breadcrumbs
{
    private static array $_items = [];

    public static function add(string $label, string $url): void
    {
        self::$_items[$label] = $url;
    }

    public static function render(bool $renderHome = true): string
    {
        $res = '<div class="breadcrumbs">';

        if ($renderHome) {
            $res .= '<a href="/" class="breadcrumbs_home" alt="Home page">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="18" height="18" viewBox="0 0 24 24">
                        <path d="M 12 2.0996094 L 1 12 L 4 12 L 4 21 L 11 21 L 11 15 L 13 15 L 13 21 L 20 21 L 20 12 L 23
                        12 L 12 2.0996094 z M 12 4.7910156 L 18 10.191406 L 18 11 L 18 19 L 15 19 L 15 13 L 9 13 L 9 19
                        L 6 19 L 6 10.191406 L 12 4.7910156 z"></path>
                        </svg>
                    </a>';
        }

        $i = 0;
        foreach (self::$_items as $label => $url)
        {
            if ($renderHome || $i > 0) {
                $res .= '<div class="breadcrumbs_arrow"></div>';
            }
            if ($i === count(self::$_items) - 1) {
                $res .= '<div class="breadcrumbs_item">'.e($label).'</div>';
            } else {
                $res .= '<a href="'.$url.'" class="breadcrumbs_item breadcrumbs_link">'.e($label).'</a>';
            }
            $i++;
        }

        return $res.'</div>';
    }
}
