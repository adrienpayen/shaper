<?php

namespace Core\Form;

use Symfony\Component\Yaml\Yaml;

/**
 * Class FormError
 *
 * @author Adrien PAYEN <adrien.payen2@gmail.com>
 */
class FormError
{
    public static function getError($key)
    {
        return Yaml::parse(file_get_contents('../App/Config/FormErrors.yml'))[$key];
    }
}