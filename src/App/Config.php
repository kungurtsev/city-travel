<?php

namespace App\App;

class Config
{
    private $configs = array();
    private static $instance;

    // Защита от создания объекта.
    private function __clone() {}
    private function __construct() {}

    /**
     * Возвращает объект конфигураций.
     *
     * @return mixed
     */
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
            static::$instance->set('db', require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .
                                                        'configs' . DIRECTORY_SEPARATOR .
                                                        'db.php');
            $db = Config::getInstance()->get('db');
            $connect = new \PDO(
                "mysql:host=" . $db['host'] . ";dbname=" . $db['db'] . ";utf-8",
                $db['user'],
                $db['password']
            );
            static::$instance->set('connect', $connect);
        }
        return static::$instance;
    }

    /**
     * Возвращает конфиг по ключу.
     *
     * @param $key
     * @param null $default
     * @return null
     */
    public function get($key, $default = null)
    {
        return array_get($this->configs, $key, $default);
    }

    /**
     * Задать конфиг.
     *
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->configs[$key] = $value;
    }

}