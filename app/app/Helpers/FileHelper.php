<?php

namespace App\Helpers;

class FileHelper
{
    const SIZES_TO_SPLIT = [3, 8, 10, 2, 20, 8];

    public static function splitByRow($file): array
    {
        $text = $file->get();
        return explode(PHP_EOL, $text);
    }

    public static function splitBySizes($string, $sizesToSplit = self::SIZES_TO_SPLIT)
    {
        $terms = [];
        $position = 0;

        for ($i = 0; $i < count($sizesToSplit); $i++) {
            $size = $sizesToSplit[$i];
            $term = substr($string, $position, $size);
            $position += $size;
            array_push($terms, $term);
        }

        return $terms;
    }
}

