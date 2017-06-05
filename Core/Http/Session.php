<?php
namespace Core\Basics;

/**
 * Class Session
 * @package Core\Basics
 */
class Session
{
    private static $instance = null;

    /**
     * Session constructor.
     */
    private function __construct()
    {
        session_start();
    }

    /**
     * @return Session|null
     */
    public static function getInstance()
    {
        if(is_null(self::$instance)) {
            self::$instance = new Session();
        }

        return self::$instance;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this);
    }

    /**
     * @param int $time
     */
    public function start($time = 60)
    {
        $_SESSION['session_id'] = session_id();
        $_SESSION['session_time'] = intval($time);
        $_SESSION['session_start'] = $this->newTime();
    }

    /**
     * Renew the session.
     */
    public function renew()
    {
        $_SESSION['session_start'] = $this->newTime();
    }

    /**
     * Destroy the session.
     */
    public function end()
    {
        $_SESSION = [];
        session_destroy();
    }

    /**
     * @return bool
     */
    public function isExpired()
    {
        if ($_SESSION['session_start'] < $this->timeNow()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function isRegistered()
    {
        if (! empty($_SESSION['session_id'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param $key
     * @return array|bool
     */
    public function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $_SESSION;
    }

    /**
     * @return false|int
     */
    private function timeNow()
    {
        $h = date('H');
        $i = date('i');
        $s = date('s');
        $m = date('m');
        $d = date('d');
        $y = date('y');
        return mktime($h, $i, $s, $m, $d, $y);
    }

    /**
     * @return false|int
     */
    private function newTime()
    {
        $h = date('H');
        $i = date('i');
        $s = date('s');
        $m = date('m');
        $d = date('d');
        $y = date('y');
        return mktime($h, $i + $_SESSION['session_time'], $s, $m, $d, $y);
    }
}