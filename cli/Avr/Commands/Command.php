<?php

namespace Avr\Commands;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class Command
 *
 * @package Avr\Commands
 */
class Command extends BaseCommand
{
    /**
     * @var InputInterface
     */
    protected $input;
    /**
     * @var SymfonyStyle
     */
    protected $output;

    /**
     * @param $question
     * @param bool $default
     *
     * @return bool|string
     */
    public function confirm($question, $default = false)
    {
        return $this->output->confirm($question, $default);
    }

    /**
     * @param $message
     */
    public function warning($message)
    {
        $this->output->warning($message);
    }

    /**
     * @param $message
     */
    public function comment($message)
    {
        $this->output->comment($message);
    }

    /**
     * @param $message
     */
    public function note($message)
    {
        $this->output->note($message);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws \Exception
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        return parent::run(
            $this->input = $input, $this->output = new SymfonyStyle($input, $output)
        );
    }
}
