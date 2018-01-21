<?php

namespace Avr;

use Exception;
use Filesystem;
use Parser;
use Serial;

/**
 * Class Avr
 *
 * @package Avr
 */
class Avr
{
    /**
     * @var array
     */
    public $file;
    /**
     * @var array
     */
    public $info;

    /**
     * @param $file
     *
     * @return Avr
     * @throws Exception
     */
    public function search($file)
    {
        if (!Filesystem::exists($file)) throw new Exception('File is not exists.');

        $this->file = $file;

        $this->info = Parser::search(Serial::get(Filesystem::getFileName($this->file)));

        table(array_keys($this->info), [$this->info]);

        return $this;
    }

    /**
     * @return $this
     */
    public function execute()
    {
        $this->rename()
            ->move()
            ->cover();

        return $this;
    }

    /**
     * @return $this
     */
    protected function rename()
    {
        $this->file = Filesystem::rename($this->file, $this->info['serial']);

        return $this;
    }

    /**
     * @return $this
     */
    protected function move()
    {
        $this->file = Filesystem::moveTo($this->file, "{$this->info['actress']}/{$this->info['serial']}");

        return $this;
    }

    protected function cover()
    {
        Filesystem::download($this->info['cover'], $this->file);
    }
}
