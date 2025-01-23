<?php
namespace Core;
use App\Controllers;
class Router
{
    private static string $method;
    private static string $uri;
    private static array $routes = [];
    private static function addRoutes($method,$route,$action) : void
    {
        $method = strtoupper($method);
        $route = trim($route, '/');
        self::$routes[$method][$route] = $action;
    }
    public static function get(string $route,$action): void
    {
        self::addRoutes('GET',$route,$action);
    }
    public static function post(string $route,$action): void
    {
        self::addRoutes('POST',$route,$action);
    }
    public static function put(string $route,$action): void
    {
        self::addRoutes('PUT',$route,$action);
    }
    public static function delete(string $route,$action): void
    {
        self::addRoutes('DELETE',$route,$action);
    }

    public function dispatch(array $server, array $post): void
    {
        self::$method = $post['_method'] ?? $server['REQUEST_METHOD'];
        self::$uri = trim(parse_url($server['REQUEST_URI'], PHP_URL_PATH), '/');

        if(!isset(self::$routes[self::$method])) {
            self::send404("HTTP method not supported.");
            return;
        }
        foreach(self::$routes[self::$method] as $route => $action)
        {
            $pattern = "@^". preg_replace("/\{[a-zA-Z0-9_]+}/","([^/]+)",$route) . "$@";
            if(preg_match($pattern,self::$uri, $matches)){
                array_shift($matches);
                [$controller, $method] = explode('@', $action);
                $controller = "App\\Controllers\\" . $controller;
                if (!class_exists($controller) || !method_exists($controller, $method)) {
                    self::send404("Controller or method not found.");
                    return;
                }
                call_user_func_array([new $controller, $method], $matches);
                return;
            }
        }
        self::send404("Route not found");
    }

    private static function send404(string $message): void
    {
        http_response_code(404);
        echo "<h1>404 - Not Found</h1>";
        echo "<p>$message</p>";
    }
    public static function listRoutes(): void
    {
        echo "<pre>";
        print_r(self::$routes);
        echo "</pre>";
    }
}