<?php

namespace BAB;

class Utils
{
    public static function getFullPath($path)
    {
        return dirname(__DIR__).$path;
    }

    public static function humanizePath($path)
    {
        return str_replace(['_', '-'], ' ', pathinfo($path, PATHINFO_FILENAME));
    }

    public static function getPublicPath($fullPath)
    {
        $directory = str_replace(dirname(__DIR__), '', $fullPath);

        return dirname($directory).DIRECTORY_SEPARATOR.pathinfo($fullPath, PATHINFO_BASENAME);
    }
}
