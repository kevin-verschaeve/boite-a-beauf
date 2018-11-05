<?php

namespace BAB\Command;

use BAB\Manager\SoundManager;
use BAB\Model\Sound;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class UpdateDatabaseCommand extends Command
{
    private $soundManager;

    private $publicPath;

    public function __construct(SoundManager $soundManager, string $publicPath, $name = null)
    {
        parent::__construct($name);
        $this->soundManager = $soundManager;
        $this->publicPath = $publicPath;
    }

    protected function configure()
    {
        $this
            ->setName('bab:db:update')
            ->setDescription('Check for files in sounds directories that are not in the database and insert them')
            ->addOption('dry-run', 'd', InputOption::VALUE_NONE, 'Check for file that will be inserted before really insert them')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dryRun = $input->getOption('dry-run');

        $finder = new Finder();
        $finder->files()->in([$this->publicPath.'/sounds/basics', $this->publicPath.'/sounds/records']);

        // get files from filesystem
        $onFilesystem = array_map(function(\SplFileInfo $file) {
            return $file->getFilename();
        }, iterator_to_array($finder->getIterator()));

        // get registered files in DB
        $onDatabase = array_map(function(Sound $sound) {
            return pathinfo($sound->publicPath, PATHINFO_BASENAME);
        }, $this->soundManager->findAll());

        if (true === $dryRun) {
            $output->writeln('<comment>These sounds will be added to the database. Check the path and the default label before inserting.</comment>');
        }

        $inserted = 0;
        foreach (array_diff($onFilesystem, $onDatabase) as $path => $name) {
            $sound = new Sound();
            $sound->publicPath = str_replace($this->publicPath, '', $path);
            $sound->label = pathinfo(str_replace(['_', '-'], ' ', $name), PATHINFO_FILENAME);
            $sound->isRecord = false !== strpos($path, '/sounds/records');
            $sound->createdAt = new \DateTime();
            $sound->isEnabled = true;

            if (true === $dryRun) {
                $output->writeln(sprintf('<comment>- Sound "%s" at path "%s"</comment>', $sound->label, $sound->publicPath));
                ++$inserted;

                continue;
            }

            if (true === $this->soundManager->insert($sound)) {
                ++$inserted;
            }
        }

        if (true === $dryRun) {
            $output->writeln(sprintf('<info>%d files would be inserted</info>', $inserted));

            return;
        }

        $output->writeln(sprintf('<fg=black;bg=green>%d files inserted', $inserted));
    }
}
