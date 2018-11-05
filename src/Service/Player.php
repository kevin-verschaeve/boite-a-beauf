<?php

namespace BAB\Service;

use BAB\Manager\PlayedManager;
use BAB\Manager\SoundManager;
use BAB\Model\Sound;
use Symfony\Component\Process\Process;

class Player
{
    private $soundManager;
    private $playedManager;
    private $publicPath;
    private $command;
    private $maxPlayed;

    public function __construct(SoundManager $soundManager, PlayedManager $playedManager, string $publicPath, string $command, int $maxPlayed)
    {
        $this->soundManager = $soundManager;
        $this->playedManager = $playedManager;
        $this->publicPath = $publicPath;
        $this->command = $command;
        $this->maxPlayed = $maxPlayed;
    }

    public function playRandom(): string
    {
        return $this->playSound($this->soundManager->findRandom());
    }

    public function playNamed(string $soundNamePart): string
    {
        return $this->playSound($this->soundManager->findOneLike($soundNamePart));
    }

    public function playExact(string $path): string
    {
        return $this->playSound($this->soundManager->findOneByPath($path));
    }

    private function playSound(Sound $sound): string
    {
        $path = $this->publicPath.$sound->publicPath;

        (new Process(sprintf('%s %s', $this->command, $path)))->run();

        $this->addToPlayed($sound);

        return $path;
    }

    private function addToPlayed(Sound $sound): void
    {
        if ($this->playedManager->countPlayed() > $this->maxPlayed) {
            $this->playedManager->removeLast();
        }

        $this->playedManager->insert($sound);
    }
}
