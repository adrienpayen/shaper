<?php
namespace Core\Database;

use Core\Helpers\Parameters;

class Connection
{
    private $PDOinstance;
    private static $instance = null;

    private function __construct()
    {
        $db = Parameters::getParameters('database');

        try {
            $this->PDOinstance = new \PDO("mysql:host=".$db['host'].";dbname=".$db['name'].";port=".$db['port'], $db['user'], $db['password']);
            $this->PDOinstance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch(\Exception $e) {
            die("Erreur SQL : ".$e->getMessage());
        }
    }

    /**
     * @return Connection|null
     */
    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new Connection();
        }
        return self::$instance;
    }
}