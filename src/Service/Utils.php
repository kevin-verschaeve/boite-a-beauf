<?php

namespace BAB\Service;

class Utils
{
    /** @var string */
    private $rootDir    ;

    public function __construct(string $rootDir)
    {
        $this->rootDir = $rootDir;
    }

    public function humanizePath($path)
    {
        return str_replace(['_', '-'], ' ', pathinfo($path, PATHINFO_FILENAME));
    }

    public function getPublicPath($endPath)
    {
        return $this->rootDir.DIRECTORY_SEPARATOR.'public'.$endPath;
    }

    public function getSoundPath($fullPath)
    {
        return str_replace($this->rootDir.DIRECTORY_SEPARATOR.'public', '', $fullPath);
    }
}
