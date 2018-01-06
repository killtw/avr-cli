<?php

use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * @param string $messages
 */
function output($messages) {
    (new ConsoleOutput)->writeln($messages);
}
