<?php

namespace BAB;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Process;

class Player
{
    const BASIC_DIR = '/sounds/basics';
    const RECORDS_DIR = '/sounds/records';
    const PLAYED_FILE = '/data/played.txt';

    const COMMAND = 'omxplayer -o local';
    const MAX_PLAYED = 50;

    public function playRandom()
    {
        $file = $this->findRandomFile();
        $this->playFile($file);
        $this->addToPlayed($file);
    }

    public function playFile($file)
    {
        $process = new Process(sprintf('%s %s', self::COMMAND, $file));
        $process->run();
    }

    private function findRandomFile()
    {
        $finder = new Finder();
        $finder->files()->in([$this->getFullPath(self::BASIC_DIR), $this->getFullPath(self::RECORDS_DIR)]);

        $played = file($this->getFullPath(self::PLAYED_FILE), FILE_IGNORE_NEW_LINES);

        $files = [];
        foreach ($finder as $file) {
            if (in_array($file, $played, true)) {
                continue;
            }

            $files[] = $file->getPathname();
        }

        return $files[array_rand($files)];
    }

    private function addToPlayed($file)
    {
        $played = file($this->getFullPath(self::PLAYED_FILE), FILE_IGNORE_NEW_LINES);

        if (count($played) >= self::MAX_PLAYED) {
            unset($played[0]);
        }

        $played[] = $file;

        file_put_contents($this->getFullPath(self::PLAYED_FILE), implode("\r\n", $played));
    }

    private function getFullPath($path)
    {
        return dirname(__DIR__).$path;
    }
}
