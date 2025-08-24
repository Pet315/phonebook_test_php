<?php
namespace App\Core;

class Router
{
    private $routes = ['GET' => [], 'POST' => []];
    private $config;

    public function __construct(array $config){ $this->config = $config; }

    public function get(string $path, string $handler, bool $auth=false): void {
        $this->routes['GET'][$path] = [$handler, $auth];
    }
    public function post(string $path, string $handler, bool $auth=false): void {
        $this->routes['POST'][$path] = [$handler, $auth];
    }

    public function dispatch(): void {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
        $route = $this->routes[$method][$path] ?? null;
        if (!$route){
            http_response_code(404);
            echo '404 Not Found';
            return;
        }
        [$handler, $auth] = $route;
        if ($auth && empty($_SESSION['user_id'])){
            header('Location: /login'); exit;
        }
        [$ctrlName, $action] = explode('@',$handler);
        $fqcn = 'App\\Controllers\\'.$ctrlName;
        $controller = new $fqcn($this->config);
        $controller->$action();
    }
}
