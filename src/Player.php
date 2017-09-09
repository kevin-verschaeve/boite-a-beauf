<?php

namespace BAB;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Process;

class Player
{
    const BASIC_DIR = '/var/www/html/sounds/basics';
    const RECORDS_DIR = '/var/www/html/sounds/records';

    const COMMAND = 'omxplayer -o local';
    const PLAYED_FILE = 'data/played.txt';

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

        if (count($played) >= 50) {
            unset($played[0]);
        }
        $played[] = $file;

        file_put_contents(self::PLAYED_FILE, $played);
    }
}
