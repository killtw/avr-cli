<?php

namespace Avr\Commands;

use Avr\Facade\Avr;
use Exception;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetCommand extends Command
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('g')
            ->setDescription('Rename, move and download cover.')
            ->addArgument('path', InputArgument::OPTIONAL);
    }

    /**
     * Execute the command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $file = $input->getArgument('path');
            $avr = Avr::search($file);

            if ($this->confirmToProceed(true)) {
                $avr->execute();

                $this->output->success('Success!');
            }
        } catch (Exception $e) {
            warning($e->getMessage());
        }
    }

    /**
     * @param bool $default
     *
     * @return bool
     */
    protected function confirmToProceed($default = false)
    {
        if (! $this->confirm('Do you really wish to run this command?', $default)) {
            $this->note('Command aborted!');

            return false;
        }

        return true;
    }
}
