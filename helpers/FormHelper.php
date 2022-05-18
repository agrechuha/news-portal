<?php

namespace app\helpers;

class FormHelper
{
    public static function getAllErrors($errors)
    {
        $result = '';
        foreach ($errors as $error) {
            if ($result) {
                $result .= '<br> ';
            }
            $result .= join('<br> ', $error);
        }
        return $result;
    }
}