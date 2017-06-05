<?php
namespace Core\Helpers;

use Symfony\Component\Yaml\Yaml;

class Parameters
{
    public static function getParameters($parameter)
    {
        return Yaml::parse(file_get_contents('../App/config/parameters.yml'))[$parameter];
    }
}