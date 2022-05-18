<?php

namespace app\helpers;

class ArrayHelper extends \yii\helpers\ArrayHelper
{
    /**
     * Finds Object in Array of objects by passed function
     * Function must return boolean value based on needed condition
     * @param $array
     * @param $function
     * @return Object|null
     */
    public static function findObject($array, $function)
    {
        foreach ($array as $item) {
            if (call_user_func($function, $item)) {
                return $item;
            }
        }
        return null;
    }

    /**
     * Finds Objects in Array of objects by passed function and return array of objects
     * Function must return boolean value based on needed condition
     * @param $array
     * @param $function
     * @return array.
     */
    public static function findAllObjects($array, $function)
    {
        $resultArray = [];
        foreach ($array as $item) {
            if (call_user_func($function, $item)) {
                array_push($resultArray, $item);
            }
        }
        return $resultArray;
    }
}