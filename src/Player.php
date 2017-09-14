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

    public function findAll($ignorePlayed = false)
    {
        $finder = new Finder();
        $finder->files()->in([Utils::getFullPath(self::BASIC_DIR), Utils::getFullPath(self::RECORDS_DIR)]);
        $played = true === $ignorePlayed ? file(Utils::getFullPath(self::PLAYED_FILE), FILE_IGNORE_NEW_LINES) : [];

        $files = [];
        foreach ($finder as $file) {
            if (in_array($file->getPathname(), $played, true)) {
                continue;
            }

            $files[] = $file->getPathname();
        }

        return $files;
    }

    private function findRandomFile()
    {
        $files = $this->findAll(true);

        return $files[array_rand($files)];
    }

    private function addToPlayed($file)
    {
        $played = file(Utils::getFullPath(self::PLAYED_FILE), FILE_IGNORE_NEW_LINES);
        $played = array_slice($played, -self::MAX_PLAYED + 1);
        $played[] = $file;

        file_put_contents(Utils::getFullPath(self::PLAYED_FILE), implode("\n", $played));
    }
}
