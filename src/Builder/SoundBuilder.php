<?php

namespace BAB\Builder;

use BAB\Model\Sound;
use BAB\Service\Utils;

class SoundBuilder
{
    /** @var Utils */
    private $utils;

    /** @var Sound */
    private $sound;

    public function __construct(Utils $utils)
    {
        $this->utils = $utils;
    }

    public function buildSound(string $path)
    {
        $sound = new Sound($path);
        $sound->label = $this->utils->humanizePath($path);
        $sound->publicPath = $this->utils->getSoundPath($path);

        $this->sound = $sound;

        return $this;
    }

    public function get()
    {
        return $this->sound;
    }
}
