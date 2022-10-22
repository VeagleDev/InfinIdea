<?php


// Classe qui stocke les différents Regex
class SuperRegexer
{
    private static $regexes = array(
        'pseudo' => '/^[a-zA-Z0-9_-]{3,20}$/',
        'email' => '/^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/',
        'surname' => '/^[a-zA-Z -]{2,20}$/',
        'articleName' => '/^[a-zA-Z0-9 .,;:!?]{3,50}$/'
    );

    public static function check($string, $regex)
    {
        if (isset(self::$regexes[$regex])) {
            return preg_match(self::$regexes[$regex], $string);
        }
        return false;
    }

}