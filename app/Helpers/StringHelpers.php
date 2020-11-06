<?php


namespace App\Helpers;


class StringHelpers
{
    public static function trimSpaceBeforeSpace($string, $offset) {
        return substr($string, 0, strpos($string, ' ', $offset));
    }
}
