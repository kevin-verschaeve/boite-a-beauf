<?php

namespace BAB\Service;

use BAB\Model\Sound;
use Symfony\Component\Process\Process;

class Player
{
    /** @var Finder */
    private $finder;

    /** @var string */
    private $command;

    /** @var int */
    private $maxPlayed;

    public function __construct(Finder $finder, string $command, int $maxPlayed)
    {
        $this->finder = $finder;
        $this->command = $command;
        $this->maxPlayed = $maxPlayed;
    }

    public function playRandom()
    {
        return $this->playSound($this->finder->findRandomSound());
    }

    public function playNamed(string $soundNamePart)
    {
        return $this->playSound($this->finder->findNamedSound($soundNamePart));
    }

    private function playSound(Sound $sound)
    {
        $process = new Process(sprintf('%s %s', $this->command, $sound->path));
        $process->run();

        $this->addToPlayed($sound);

        return $sound;
    }

    private function addToPlayed(Sound $sound)
    {
        $played = file($this->finder->getPlayedSoundsPath(), FILE_IGNORE_NEW_LINES);
        $played = array_slice($played, -$this->maxPlayed + 1);
        $played[] = $sound->path;

        file_put_contents($this->finder->getPlayedSoundsPath(), implode("\n", $played));
    }
}
