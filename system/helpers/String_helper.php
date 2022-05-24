<?php
/**
 * Created by PhpStorm.
 * User: welcome
 * Date: 7/19/21
 * Time: 12:13 PM
 */

class String_helper
{
    public function __construct()
    {
    }
    function remove_special_chars($string) {
        $string = strip_tags($string);
        $string = preg_replace('/[^A-Za-z0-9. -]/', ' ', $string);
        // Replace sequences of spaces with hyphen
        $string = preg_replace('/  */', '-', $string);
        return $string;
    }

    function remove_numbers_from_string($string) {
        /*
         * Remove numbers from string.
         * The end string wont have numbers
         * Eg: ashan1234 will be ashan
         */
        return preg_replace('/\d+/u', '', $string);
    }

    function replace_multiple_spaces($string) {
        /*
         * Remove extra spaces from the Strings
         * Replace double spaces with single space
         */
        return preg_replace('!\s+!', ' ', $string);
    }

    function remove_none_utf_char($string) {
        /*
         *
         * Get rid of non none UTF character encodings
         *
         *
        */
        $utf8 = array(
            '/[áàâãªä]/u'   =>   'a',
            '/[ÁÀÂÃÄ]/u'    =>   'A',
            '/[ÍÌÎÏ]/u'     =>   'I',
            '/[íìîï]/u'     =>   'i',
            '/[éèêë]/u'     =>   'e',
            '/[ÉÈÊË]/u'     =>   'E',
            '/[óòôõºö]/u'   =>   'o',
            '/[ÓÒÔÕÖ]/u'    =>   'O',
            '/[úùûü]/u'     =>   'u',
            '/[ÚÙÛÜ]/u'     =>   'U',
            '/ç/'           =>   'c',
            '/Ç/'           =>   'C',
            '/ñ/'           =>   'n',
            '/Ñ/'           =>   'N',
            '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
            '/[“”«»„]/u'    =>   ' ', // Double quote
            '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
        );
        return preg_replace(array_keys($utf8), array_values($utf8), $string);
    }


}