<?php

namespace Core\Custom;

use Core\Basics\Session;
use Core\Database\BaseSql;

class Manager
{
    public static function checkConnection($login, $password)
    {
        $pdo = BaseSql::getInstance();
        $query = $pdo->getDb()->prepare("SELECT * FROM user where email='" . $login . "'");
        $query->execute();

        $result = $query->fetch(\PDO::FETCH_ASSOC);

        if (!password_verify($password, $result['password'])) {
            return false;
        }

        $session = Session::getInstance();

        if (!$session->get('user')) {
            $session->set('user', $result['id']);
        }

        return true;
    }
}