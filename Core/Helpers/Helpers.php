<?php
namespace Core\Helpers;

class Helpers
{
    /**
     * @param $array
     * @param $needle
     * @param null $parent
     * @return bool|null
     */
    public static function findParent($array, $needle, $parent = null) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $pass = $parent;
                if (is_string($key)) {
                    $pass = $key;
                }
                $found = self::findParent($value, $needle, $pass);
                if ($found !== false) {
                    return $found;
                }
            } else if ( $value === $needle) {
                return $parent;
            }
        }

        return false;
    }
}