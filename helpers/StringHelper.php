<?php

namespace app\helpers;

use yii\helpers\BaseStringHelper;

class StringHelper extends BaseStringHelper
{
    public static function getTransliterate($input)
    {
        $map = array(
            ' ' => '_', ',' => '', '.' => '', '!' => '', '?' => '', '«' => '', '»' => '',
            '*' => '', '/' => '', '|' => '', '<' => '', '>' => '', '`' => '',
            '"' => '', ':' => '', ';' => '', '—' => '', '-' => '', '#' => '', '%' => '', '&' => '',
            "^" => "", "'" => "", "{" => '', "}" => '', "[" => '', "]" => '',
            "Є" => "YE", "І" => "I", "Ѓ" => "G", "і" => "i", "№" => "", "є" => "ye", "ѓ" => "g",
            "\xe2\x80\xa8" => "", "\\u2028" => "", "\xe2\x80\xa9" => "", "\\u2029" => "",
            "А" => "A", "Б" => "B", "В" => "V", "Г" => "G", "Д" => "D",
            "Е" => "E", "Ё" => "E", "Ж" => "ZH",
            "З" => "Z", "И" => "I", "Й" => "I", "К" => "K", "Л" => "L",
            "М" => "M", "Н" => "N", "О" => "O", "П" => "P", "Р" => "R",
            "С" => "S", "Т" => "T", "У" => "U", "Ф" => "F", "Х" => "H",
            "Ц" => "C", "Ч" => "CH", "Ш" => "SH", "Щ" => "SHH", "Ъ" => "'",
            "Ы" => "Y", "Ь" => "", "Э" => "E", "Ю" => "YU", "Я" => "YA",
            "а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d",
            "е" => "e", "ё" => "e", "ж" => "zh",
            "з" => "z", "и" => "i", "й" => "i", "к" => "k", "л" => "l",
            "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
            "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
            "ц" => "c", "ч" => "ch", "ш" => "sh", "щ" => "shh", "ъ" => "",
            "ы" => "y", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya"
        );
        return strtr($input, $map);
    }

    public static function generateTransliteration($field, $model, $propertyName)
    {
        $new_name = strtolower(self::getTransliterate(trim($field)));
        $salt = '';
        while ($items = $model::find()->where([$propertyName => $new_name . $salt])->one()) {
            ++$salt; //add salt 1....n to url
        }
        return $new_name . $salt;
    }
}