<?php

namespace Avr;

use Exception;
use Filesystem;
use Parser;
use Serial;

class Avr
{
    public $file;
    protected $serial;
    public $info;

    /**
     * @param $path
     *
     * @return Avr
     * @throws Exception
     */
    public function search($path)
    {
        if (! Filesystem::exists($path)) throw new Exception('File is not exists.');

        $this->file = pathinfo($path);

        $this->serial = Serial::get($this->file['filename']);
        $this->info = Parser::search($this->serial);

        table(array_keys($this->info), [$this->info]);

        return $this;
    }
}
