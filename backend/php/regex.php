<?php

class SuperRegexer
{
    // make an array of regexes
    // pseudo with 3 to 20 characters, letters, numbers, underscores and dashes
    // email with an email regex
    // surname with 2 to 20 characters, letters, spaces and dashes
    // article name with 3 to 50 characters, letters, numbers, spaces, dots, and signs
    private static $regexes = array(
        'pseudo' => '/^[a-zA-Z0-9_-]{3,20}$/',
        'email' => '/^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/',
        'surname' => '/^[a-zA-Z -]{2,20}$/',
        'articleName' => '/^[a-zA-Z0-9 .,;:!?]{3,50}$/'
    );

    // make a function to check if a string matches a regex
    public static function check($string, $regex)
    {
        // if the regex exists
        if (isset(self::$regexes[$regex])) {
            // return the result of the preg_match function
            return preg_match(self::$regexes[$regex], $string);
        }
        // if the regex doesn't exist, return false
        return false;
    }

}

if (SuperRegexer::check('Je suis un test', 'articleName')) {
    echo 'OK';
} else {
    echo 'KO';
}


if (SuperRegexer::check('Je suis un test', 'pseudo')) {
    echo 'OK';
} else {
    echo 'KO';
}

if (SuperRegexer::check('Je suis un test', 'email')) {
    echo 'OK';
} else {
    echo 'KO';
}

if (SuperRegexer::check('Je suis un test', 'surname')) {
    echo 'OK';
} else {
    echo 'KO';
}

if (SuperRegexer::check('ogeajijga@gmail.com', 'email')) {
    echo 'OK';
} else {
    echo 'KO';
}