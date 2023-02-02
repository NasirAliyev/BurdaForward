<?php

namespace App\Core;

class Router
{
    /**
     * @var Route[]
     */
    private array $routes = [];

    /**
     * Adding routes.
     *
     * @param Route $route
     */
    public function addRoute(Route $route)
    {
        $this->routes[] = $route;
    }

    /**
     * Find requested route.
     *
     * @param string $path
     * @param string $method
     * @return Route|null
     */
    public function findRoute(string $path, string $method): ?Route
    {
        foreach ($this->routes as $route) {
            $match = $route->getPathMatch($path);

            if (!$match) {
                continue;
            }

            if (!$route->methodMatch($method)) {
                continue;
            }

            if (count($match) === 1) {
                return $route;
            }

            if ($route->matches($match)) {
                return $route->setParams($route->getMatchedParams($match));
            }
        }

        return null;
    }

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}
