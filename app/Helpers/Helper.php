<?php


namespace App\Helpers;


use Illuminate\Http\Request;

class Helper
{
    public static function trimSpaceBeforeSpace($string, $offset)
    {
        return substr($string, 0, strpos($string, ' ', $offset));
    }
}
