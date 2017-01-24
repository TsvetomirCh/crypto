<?php

namespace Crypto;

final class Str
{
    /**
     * @param $text
     * @return string
     */
    public static function prepareTheText($text) : string
    {
        return trim(strtoupper(str_replace(' ', '', $text)));
    }

    /**
     * Split duplicated consecutive chars with X char.
     *
     * @param $text
     * @return mixed
     */
    public static function splitDuplicates($text) : string
    {
        for($i = 0; $i < strlen ($text) - 1; $i ++) {
            if ($text[$i] === $text[$i+1]) {
                $text = substr_replace ( $text, "X", $i+1, 0 );
                if ($text[$i] === $text[$i+1]) {
                    throw new \LogicException("Two consecutive X's ...");
                }

                $i ++;
            }
        }

        return $text;
    }
}