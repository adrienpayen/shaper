<?php
namespace Core\Builder;

class Module
{
    protected $provider;
    protected $action;

    public function __construct()
    {
        $this->provider = get_called_class();
    }

    public function register()
    {
        // renseigne un fichier (ou la bdd) qui liste l'ensemble des actions/provider
    }

    /**
     * @var string $actionName
     *
     * @param $actionName
     */
    public static function load($actionName)
    {
        // charger l'action en fonction du nom de l'action donnée par le json
    }
}
