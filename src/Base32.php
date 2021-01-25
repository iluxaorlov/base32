<?php

declare(strict_types=1);

namespace Iluxaorlov;

use function ord;
use function strlen;
use function chr;

class Base32
{
    private const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    private const PAD = '=';

    /**
     * @param string $data
     * @param bool $padding
     *
     * @return string
     */
    public static function encode(string $data, bool $padding = true): string
    {
        if ($data === '') {
            return '';
        }

        $binary = '';

        foreach (str_split($data) as $char) {
            $binary .= str_pad(base_convert((string) ord($char), 10, 2), 8, '0', STR_PAD_LEFT);
        }

        $result = '';

        foreach (str_split($binary, 5) as $char) {
            $result .= self::ALPHABET[(int) base_convert(str_pad($char, 5, '0'), 2, 10)];
        }

        if ($padding) {
            $remainder = strlen($binary) % 40;

            switch ($remainder) {
                case 8:
                    $result .= str_repeat(self::PAD, 6);

                    break;
                case 16:
                    $result .= str_repeat(self::PAD, 4);

                    break;
                case 24:
                    $result .= str_repeat(self::PAD, 3);

                    break;
                case 32:
                    $result .= str_repeat(self::PAD, 1);

                    break;
            }
        }

        return $result;
    }

    /**
     * @param string $data
     *
     * @return string
     */
    public static function decode(string $data): string
    {
        if ($data === '') {
            return '';
        }

        $data = str_replace('=', '', strtoupper($data));

        $binary = '';

        foreach (str_split($data) as $char) {
            $position = strpos(self::ALPHABET, $char);

            if ($position === false) {
                continue;
            }

            $binary .= str_pad(base_convert((string) $position, 10, 2), 5, '0', STR_PAD_LEFT);
        }

        $result = '';

        foreach (str_split($binary, 8) as $char) {
            $result .= chr((int) base_convert($char, 2, 10));
        }

        $controlCharacters = [];

        for ($control = 0; $control < 32; $control++) {
            if ($control !== 9 && $control !== 10) {
                $controlCharacters[] = chr($control);
            }
        }

        $controlCharacters[] = chr(127);

        return str_replace($controlCharacters, '', $result);
    }
}
