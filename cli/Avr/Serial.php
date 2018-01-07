<?php

namespace Avr;

/**
 * Class Serial
 *
 * @package Avr
 */
class Serial
{
    /**
     * Regex for getting video serial.
     */
    const REGEX = "/[A-Za-z]{2,5}\-?\d{2,5}/";

    /**
     * Get video serial from path.
     *
     * @param string $path
     *
     * @return bool|string
     */
    public function get($path)
    {
        if ($serial = $this->match($path)) {
            return strtoupper($serial);
        }

        return false;
    }

    /**
     * @param string $path
     *
     * @return string|null
     */
    public function match($path)
    {
        preg_match(self::REGEX, $path, $match);

        return $match[0] ?? null;
    }
}
