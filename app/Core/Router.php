<?php

namespace App\Core;

use InvalidArgumentException;

class Router
{
    protected array $routes = [];

    public function addRoute(string $method, string $uri, array $action): void
    {
        if (!in_array($method, ['GET', 'POST', 'DELETE'])) {
            throw new InvalidArgumentException("Invalid HTTP method: $method");
        }

        $this->routes[$method][$uri] = $action;
    }

    public function handleRequest(): mixed
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $action = $this->routes[$_SERVER['REQUEST_METHOD']][$path] ?? null;

        if (!is_null($action)) {
            $controller = $action[0];
            $method = $action[1];

            if (!class_exists($controller)) {
                throw new InvalidArgumentException("Controller class not found: {$controller}");
            }

            $controllerInstance = new $controller();
            if (!method_exists($controllerInstance, $method)) {
                throw new InvalidArgumentException("Method not found: {$method} in class {$controller}");
            }

            return $controllerInstance->$method();
        }

        return include BASE . '/views/error/not-found.php';
    }
}
