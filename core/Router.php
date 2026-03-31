<?php
class Router
{
    private array $routes = [];

    public function get(string $path, string $controller, string $method): void
    {
        $this->routes[] = [
            'path'       => $path,
            'controller' => $controller,
            'method'     => $method,
            'httpMethod' => 'GET',
        ];
    }

    public function post(string $path, string $controller, string $method): void
    {
        $this->routes[] = [
            'path'       => $path,
            'controller' => $controller,
            'method'     => $method,
            'httpMethod' => 'POST',
        ];
    }

    public function dispatch(): void
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');

        if ($basePath !== '' && str_starts_with($url, $basePath)) {
            $url = substr($url, strlen($basePath));
        }

        if ($url === '' || $url === false) {
            $url = '/';
        }

        $httpMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            $routeMethod = $route['httpMethod'] ?? 'GET';

            if ($route['path'] === $url && $routeMethod === $httpMethod) {
                // Extraire le nom de classe depuis le chemin (ex: 'Admin/DashboardController' → 'DashboardController')
                $controllerPath  = $route['controller'];
                $controllerClass = basename(str_replace('/', DIRECTORY_SEPARATOR, $controllerPath));

                require_once __DIR__ . '/../app/controllers/' . $controllerPath . '.php';
                $controller = new $controllerClass();
                $controller->{$route['method']}();
                return;
            }
        }

        http_response_code(404);
        require __DIR__ . '/../app/views/errors/404.php';
    }
}
