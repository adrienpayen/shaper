<?php

namespace Core\Basics;

/**
 * Class View
 *
 * @author Adrien PAYEN <adrien.payen2@gmail.com>
 */
class View
{
    protected $view;
    protected $template;

    /**
     * View constructor.
     *
     * @param string $view
     * @param string $template
     */
    public function __construct($view = "index", $template = "frontend")
    {
        $this->setView($view);
        $this->setTemplate($template);
    }

    /**
     * @param $view
     * @return string
     */
    public function setView($view)
    {
        if (file_exists( "../src/views/" . $view . ".view.php" )) {
            return $this->view = $view . ".view.php";
        }

        die("La vue n'existe pas");
    }

    /**
     * @param $template
     * @return string
     */
    public function setTemplate($template)
    {
        if (file_exists( "../src/views/" . $template . ".layout.php" )) {
            return $this->template = $template . ".layout.php";
        }

        die("Le template n'existe pas");
    }

    public function render($view, array $params = [])
    {
        $this->setView($view);

        foreach ($params as $key => $value) {
            $this->data[$key] = $value;
        }

        return true;
    }

    public function includeModal($modal, $config)
    {
        if (file_exists("../src/views/modals/" . $modal . ".view.php")) {
            include "../src/views/modals/" . $modal . ".view.php";
        } else {
            die("Le modal n'existe pas");
        }
    }
    
    public function __destruct()
    {
        if ($this->data) {
            extract($this->data);
        }
        include "../src/views/" . $this->template;
    }
}