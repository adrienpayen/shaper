<?php

namespace Core\Basics;

/**
 * Class Request
 *
 * @author Adrien PAYEN <adrien.payen2@gmail.com>
 */
class Request
{
    private static $_instance = null;
    /** @var array */
    public $parameters = [];


    /**
     * Request constructor.
     */
    public function __construct(){}


    /**
     * @return Request|null
     */
    public static function getInstance()
    {
        if(is_null(self::$_instance)) {
            self::$_instance = new Request();
        }

        return self::$_instance;
    }

    /**
     * @param $key
     * @return bool
     */
    public static function get($key)
    {
        if(!empty($_POST[$key])) {
            return $_POST[$key];
        } else {
            return false;
        }
    }

    /**
     * @return bool | array
     */
    public static function getAll()
    {
        if(!empty($_POST)) {
            return $_POST;
        } else {
            return false;
        }
    }

    /**
     * @return bool | array
     */
    public static function getRequest()
    {
        if(!empty($_REQUEST)) {
            return $_REQUEST;
        } else {
            return false;
        }
    }

    /**
     * @return mixed
     */
    public static function getRequestMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @param $path
     * @param bool $absolute
     * @return bool
     */
    public static function redirect($path, $absolute = false)
    {
        if(!$absolute) {
            header("Location: ".HOST.$path);
            return true;
        }

        header("Location: http://www." . $path);
        return true;
    }
}