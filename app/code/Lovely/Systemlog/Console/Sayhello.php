<?php
namespace Appseconnect\Systemlog\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class Sayhello extends Command
{
    protected function configure()
    {
        $this->setName('example:sayhello');
        $this->setDescription('Demo command line');

        parent::configure();
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filesystem = new Filesystem();
        if ($filesystem->exists('var/log')){
            $filesystem->remove('var/log/lovely.log');
            $output->writeln("delete lovely log file");
        }
    }
}
