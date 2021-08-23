<?php

namespace App\Helpers;

class FileHelper
{
    public static function splitByRow($file)
    {
        $text = $file->get();
        return explode(PHP_EOL, $text);
    }
}
