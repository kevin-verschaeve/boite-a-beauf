<?php

namespace BAB\Model;

class Sound
{
    /** @var int */
    public $id;

    /** @var string Public path of the sound */
    public $publicPath;

    /** @var string Label displayed in front */
    public $label;

    /** @var boolean Is it a recorded sound ? */
    public $isRecord = false;

    /** @var \DateTime */
    public $createdAt;

    /** @var bool Is the sound enabled ? */
    public $isEnabled = true;
}
