<?php

namespace Core\Basics;

use Symfony\Component\Yaml\Yaml;

/**
 * Class Routing
 */
class Routing
{
    private $uriExploded;
    private $controller;
    private $controllerName;
    private $action;
    private $actionName;

    private $params;

    /**
     * Routing constructor.
     */
    public function __construct()
    {
        $uri = $_SERVER["REQUEST_URI"];
        $uri = preg_replace("#/#i", "", $uri, 1);
        $this->uri = $uri;
        $this->uriExploded = explode("/", trim($uri, "/"));

        $isAdmin = $this->distributor();
        $this->setParams();
        $this->runRoute($isAdmin);
    }

    public static function load()
    {
        return new self;
    }

    /**
     *
     */
    public function setParams()
    {
        $this->params = array_merge(array_values($this->uriExploded), $_POST);
    }

    /**
     * @param $isAdmin
     * @return bool
     */
    public function checkRoute($isAdmin)
    {
        if ($isAdmin) {
            $pathController = "../src/BackOffice/Controllers/" . $this->controllerName . ".php";
        } else {
            $pathController = "../src/FrontOffice/Controllers/" . $this->controllerName . ".php";
        }

        if (!file_exists($pathController)) {
            echo "Le fichier du controller n'existe pas";
            return false;
        }

        include $pathController;


        if ($isAdmin) {
            $this->controllerName = 'BackOffice\\Controllers\\' . $this->controllerName;

            if (!class_exists($this->controllerName)) {
                echo "Le fichier du controller existe mais il n'y a pas de classe";
                return false;
            }
        } else {
            $this->controllerName = 'FrontOffice\\Controllers\\' . $this->controllerName;

            if (!class_exists($this->controllerName)) {
                echo "Le fichier du controller existe mais il n'y a pas de classe";
                return false;
            }
        }

        if ($isAdmin) {
            if (!method_exists($this->controllerName, $this->actionName)) {
                echo "L'action n'existe pas";
                return false;
            }
        } else {
            if (!method_exists($this->controllerName, $this->actionName)) {
                echo "L'action n'existe pas";
                return false;
            }
        }
        return true;
    }

    /**
     * @param bool $isAdmin
     */
    public function runRoute($isAdmin = false)
    {


        if ($this->checkRoute($isAdmin)) {
            //$this->controllerName = IndexController
            $controller = new $this->controllerName();
            //$this->actionName = indexAction
            $controller->{$this->actionName}($this->params);
        } else {
            $this->page404();
        }
    }

    /**
     * todo:
     */
    public function page404()
    {
        die(" Erreur 404");
    }

    /**
     * Check if we request admin interface or front interface.
     *
     * @return bool
     */
    private function distributor()
    {
        if ($this->uriExploded[0] == "admin") {
            $routing = Yaml::parse(file_get_contents('../src/BackOffice/Routes.yml'));

            $this->checkPath($routing);

            return true;
        } else {
            $route = Yaml::parse(file_get_contents('../src/FrontOffice/Routes.yml'));


            if (isset($route[$this->uriExploded[0]])) {
                $path = $route[$this->uriExploded[0]];

                $this->controllerName = $path['controller'] . "Controller";
                $this->actionName = $path['action'] . "Action";

                unset($this->uriExploded[0]);
                unset($this->uriExploded[1]);
            } else {
                $this->controllerName = 'IndexController';
                $this->actionName = 'indexAction';
            }

            return false;
        }

    }

    /**
     * @param $routing
     * @return mixed
     */
    private function checkPath($routing)
    {
        foreach ($routing as $key => $val) {
            $path = 'admin/' . $val['path'];
            $pathExploded = explode("/", trim($path, "/"));
            $directory = $val['directory'];

            $regex = "";
            foreach ($pathExploded as $item) {
                if (is_string($item) && substr($item, -1) != "}") {
                    $regex .= "(\\/)(" . $item . ")";
                }
                if ($val['requires'][str_replace(['{', '}'], '', $item)]['type'] === "int") {
                    if ($val['requires'][str_replace(['{', '}'], '', $item)]['required']) {
                        $regex .= "(\\/)(\\d+)";
                    } else {
                        $regex .= "(\\s*|(\\/)(\\s*|\\d+))";
                    }
                }
            }

            $regex = "/^" . substr($regex, 4) . "/";

            if (preg_match($regex, $this->uri)) {
                $this->controllerName = $directory['controller'] . "Controller";
                $this->actionName = $directory['action'] . "Action";

                return true;
            }
        }

        return $this->page404();
    }
}






