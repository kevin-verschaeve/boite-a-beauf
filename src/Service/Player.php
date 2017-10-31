<?php

namespace BAB\Service;

use BAB\Manager\PlayedManager;
use BAB\Manager\SoundManager;
use BAB\Model\Sound;
use Symfony\Component\Process\Process;

class Player
{
    /** @var SoundManager */
    private $soundManager;

    /** @var PlayedManager */
    private $playedManager;

    /** @var string */
    private $publicPath;

    /** @var string */
    private $command;

    /** @var int */
    private $maxPlayed;

    public function __construct(SoundManager $soundManager, PlayedManager $playedManager, string $publicPath, string $command, int $maxPlayed)
    {
        $this->soundManager = $soundManager;
        $this->playedManager = $playedManager;
        $this->publicPath = $publicPath;
        $this->command = $command;
        $this->maxPlayed = $maxPlayed;
    }

    public function playRandom()
    {
        return $this->playSound($this->soundManager->findRandom());
    }

    public function playNamed(string $soundNamePart)
    {
        return $this->playSound($this->soundManager->findOneLike($soundNamePart));
    }

    private function playSound(Sound $sound)
    {
        $path = $this->publicPath.$sound->publicPath;

        $process = new Process(sprintf('%s %s', $this->command, $path));
        $process->run();

        $this->addToPlayed($sound);

        return $path;
    }

    private function addToPlayed(Sound $sound)
    {
        if ($this->playedManager->countPlayed() > $this->maxPlayed) {
            $this->playedManager->removeLast();
        }

        $this->playedManager->insert($sound);
    }
}
