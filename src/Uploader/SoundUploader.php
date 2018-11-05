<?php

namespace BAB\Uploader;

use BAB\Manager\SoundManager;
use BAB\Model\Sound;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SoundUploader
{
    private const RECORDS_DIR = '/sounds/records';

    private $soundManager;
    private $publicPath;

    public function __construct(SoundManager $soundManager, string $publicPath)
    {
        $this->soundManager = $soundManager;
        $this->publicPath = $publicPath;
    }

    public function upload(UploadedFile $file): Sound
    {
        $new = $file->move($this->publicPath.self::RECORDS_DIR, $file->getClientOriginalName());

        $sound = new Sound();
        $sound->label = $new->getBasename('.'.$new->getExtension());
        $sound->publicPath = self::RECORDS_DIR.'/'.$new->getBasename();
        $sound->isRecord = true;

        $this->soundManager->insert($sound);

        return $sound;
    }
}
