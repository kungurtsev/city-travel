<?php

namespace App\App;

use App\Exception\NotFoundException;

class Router
{
    private $route = [];

    /**
     * @param $url
     * @param $callback
     */
    public function get($url, $callback)
    {
        // Отрезаем слешы в начале и в конце.
        $url = '/' . trim($url, '/');
        // Регистрируем маршрут.
        $this->route[$url] = $callback;
    }

    /**
     * @return mixed
     * @throws NotFoundException
     */
    public function dispatch()
    {
        $requestUri = '/' . trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->route as $key => $callback) {
            if ($requestUri === $key) {
                if (is_callable($callback)) {
                    return $callback();
                }
                $buf = explode('@', $callback);
                $controller = new $buf[0];
                $action = $buf[1];
                return $controller->$action();
            }
        }
        throw new NotFoundException();
    }
}
