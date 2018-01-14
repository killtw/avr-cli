<?php

namespace Avr\Commands;


use Avr;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class GetCommand extends Command
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('get')
            ->setDescription('Create a new BotMan application.')
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
            $info = Avr::search($input->getArgument('path'));

//            $helper = $this->getHelperSet()->get('question');
//
//            $question = new ConfirmationQuestion("Are you sure?\nY/n");
//
//            if ($helper->ask($input, $output, $question)) {
//                $output->writeln('Hello!');
//            }
            output($info->file);
        } catch (Exception $e) {
            warning($e->getMessage());
        }
    }
}
