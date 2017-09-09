<?php

namespace BAB;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Process;

class Player
{
    const ROOT_PATH = '/var/www/html';

    const BASIC_DIR = self::ROOT_PATH.'/sounds/basics';
    const RECORDS_DIR = self::ROOT_PATH.'/sounds/records';
    const PLAYED_FILE = self::ROOT_PATH.'/data/played.txt';

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
        $finder->files()->in([self::BASIC_DIR, self::RECORDS_DIR]);

        $played = file(self::PLAYED_FILE);

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
        $played = file(self::PLAYED_FILE);

        if (count($played) >= self::MAX_PLAYED) {
            unset($played[0]);
        }
        $played[] = $file;

        file_put_contents(self::PLAYED_FILE, implode("\n", $played));
    }
}
