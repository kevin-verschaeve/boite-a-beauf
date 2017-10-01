<?php

namespace BAB\Model;

class Sound
{
    /** @var string Full path of the sound */
    public $path;

    /** @var string Public path of the sound */
    public $publicPath;

    /** @var string Label displayed in front */
    public $label;

    public function __construct(string $path)
    {
        $this->path = $path;
    }
}
