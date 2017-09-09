<?php

namespace BAB;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Process;

class Player
{
    const BASIC_DIR = '/var/www/html/sounds/basics';
    const RECORDS_DIR = '/var/www/html/sounds/records';

    const COMMAND = 'omxplayer -o local';

    public function playRandom()
    {
        $file = $this->findRandomFile();
        $this->playFile($file);
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

        $files = [];
        foreach ($finder as $file) {
            $files[] = $file->getPathname();
        }

        return $files[array_rand($files)];
    }
}
