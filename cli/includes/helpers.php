<?php

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * @param string|array $messages
 */
function output($messages) {
    if (is_array($messages)) {
        foreach ($messages as $message) {
            (new ConsoleOutput)->writeln($message);
        }
    } else {
        (new ConsoleOutput)->writeln($messages);
    }
}

/**
 * @param string $messages
 */
function warning($messages)
{
    output("<fg=red>$messages</>");
}

function table(array $headers = [], array $rows = [])
{
    $table = new Table(new ConsoleOutput);
    $table->setHeaders($headers)->setRows($rows);
    $table->render();
}
