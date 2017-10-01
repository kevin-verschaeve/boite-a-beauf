<?php

namespace BAB\Service;

use BAB\Builder\SoundBuilder;
use Symfony\Component\Finder\Finder as SFFinder;

class Finder
{
    const BASIC_DIR = '/sounds/basics';
    const RECORDS_DIR = '/sounds/records';
    const PLAYED_FILE = '/sounds/played.txt';

    /** @var SoundBuilder */
    private $soundBuilder;

    /** @var Utils */
    private $utils;

    /** @var array */
    private $allowedFormats;

    public function __construct(SoundBuilder $soundBuilder, Utils $utils, array $allowedFormats)
    {
        $this->utils = $utils;
        $this->soundBuilder = $soundBuilder;
        $this->allowedFormats = $allowedFormats;
    }

    public function findAll($ignorePlayed = false)
    {
        $playedFile = $this->getPlayedSoundsPath();
        $this->ensureFileExists($playedFile);

        $finder = (new SFFinder())
            ->files()
            ->in([$this->getBasicsSoundsPath(), $this->getRecordsSoundsPath()])
            ->sortByName();

        return $this->getFilesPath($finder, true === $ignorePlayed ? file($playedFile, FILE_IGNORE_NEW_LINES) : []);
    }

    public function findRandomSound()
    {
        $sounds = $this->findAll(true);

        return $sounds[array_rand($sounds)];
    }

    public function findNamedSound(string $soundNamePart)
    {
        $finder = (new SFFinder())
            ->files()
            ->in([$this->getBasicsSoundsPath(), $this->getRecordsSoundsPath()])
            ->name('/.*'.$soundNamePart.'.*\.('.implode('|', $this->allowedFormats).')/i');

        if (0 === $finder->count()) {
            throw new \Exception("$soundNamePart, Aucun fichier trouvé.");
        }

        if ($finder->count() > 1) {
            throw new \Exception("$soundNamePart Plusieurs fichiers trouvés");
        }

        return $this->soundBuilder->buildSound($finder->getIterator()->current()->getPathname())->get();
    }

    public function ensureFileExists($filePath)
    {
        if (file_exists($filePath)) {
            return;
        }

        file_put_contents($filePath, null);
    }

    public function getBasicsSoundsPath()
    {
        return $this->utils->getPublicPath(self::BASIC_DIR);
    }

    public function getRecordsSoundsPath()
    {
        return $this->utils->getPublicPath(self::RECORDS_DIR);
    }

    public function getPlayedSoundsPath()
    {
        return $this->utils->getPublicPath(self::PLAYED_FILE);
    }

    private function getFilesPath(SFFinder $finder, $played)
    {
        $files = [];
        foreach ($finder as $file) {
            if (in_array($file->getPathname(), $played, true)) {
                continue;
            }

            $files[] = $this->soundBuilder->buildSound($file->getPathname())->get();
        }

        return $files;
    }
}
