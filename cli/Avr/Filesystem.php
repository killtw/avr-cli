<?php

namespace Avr;

class Filesystem
{
    public function mkdir($path)
    {
        if (! is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    public function exists($path)
    {
        return file_exists($path);
    }
}
