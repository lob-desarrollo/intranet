<?php

namespace App\Console;

class CleanString {
    static function cleanForUrl($string) {
        $string = strtolower($string);
        $string = str_replace(['á','é','í','ó','ú',' '], 
                              ['a','e','i','o','u','-'], 
                              $string);
        return $string;
    }
}