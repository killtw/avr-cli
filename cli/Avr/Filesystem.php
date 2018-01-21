<?php

namespace Avr;

/**
 * Class Filesystem
 *
 * @package Avr
 */
class Filesystem
{
    /**
     * @param $path
     */
    public function mkdir($path)
    {
        if (! is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    /**
     * @param $path
     *
     * @return bool
     */
    public function exists($path)
    {
        return file_exists($path);
    }

    /**
     * @param $file
     * @param $name
     *
     * @return mixed
     */
    public function rename($file, $name)
    {
        $info = pathinfo($file);

        return $this->moveFileTo($file, "{$info['dirname']}/$name.{$info['extension']}");
    }

    /**
     * @param $path
     *
     * @return mixed
     */
    public function getFileName($path)
    {
        return pathinfo($path)['filename'];
    }

    public function download($url, $direction)
    {
        $image = pathinfo($url);
        $path = pathinfo($direction);
        $filename = "{$path['dirname']}/{$path['filename']}.{$image['extension']}";

        file_put_contents($filename, file_get_contents($url));
    }

    /**
     * @param $file
     * @param $direction
     *
     * @return mixed
     */
    public function moveTo($file, $direction)
    {
        $info = pathinfo($file);

        return $this->moveFileTo($file, "{$info['dirname']}/{$direction}/{$info['basename']}");
    }

    /**
     * @param $file
     * @param $direction
     *
     * @return mixed
     */
    private function moveFileTo($file, $direction)
    {
        $this->mkdir(pathinfo($direction)['dirname']);

        if (! $this->exists($direction)) {
            rename($file, $direction);
        }

        return $direction;
    }
}
