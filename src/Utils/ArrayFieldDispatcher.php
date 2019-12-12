<?php


namespace App\Utils;

class ArrayFieldDispatcher
{

    /**
     * Search for a given key=>value in an array
     * @param $array
     * @param $fieldName
     * @return bool|mixed
     */
    public static function dispatchField($array, $fieldName)
    {
        foreach ($array as $key => $value) {
            if ($key === $fieldName) {
                return $value;
            }
            if (is_array($value)) {
                if ($result = ArrayFieldDispatcher::dispatchField($value, $fieldName)) {
                    return $result;
                }
            }
        }
        return null;
    }
}
