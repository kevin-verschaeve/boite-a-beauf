<?php

namespace BAB\Command;

use BAB\Service\Player;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PlaySoundCommand extends Command
{
    /** @var Player */
    private $player;

    public function __construct(Player $player, $name = null)
    {
        parent::__construct($name);
        $this->player = $player;
    }

    protected function configure()
    {
        $this
            ->setName('bab:play')
            ->setDescription('Play a named or a random sound')
            ->addArgument('sound', InputArgument::OPTIONAL, 'Sound name to play')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sound = $input->getArgument('sound');
        $played = null === $sound ? $this->player->playRandom() : $this->player->playNamed($sound);

        $output->writeln('<info>Played "'.$played->path.'"</info>');
    }
}
