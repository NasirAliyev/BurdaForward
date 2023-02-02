<?php

namespace App\Core;

class Route
{
    private array $params = [];

    /**
     * Route constructor.
     *
     * @param string $path
     * @param array $types
     * @param string $controller
     * @param string $action
     * @param array $methods
     */
    public function __construct(
        private string $path,
        private array $types,
        private string $controller,
        private string $action,
        private array $methods,
    ) {
    }

    /**
     * Finding path match without type validation.
     *
     * @param string $path
     * @return array
     */
    public function getPathMatch(string $path): array
    {
        $pattern = preg_replace('/\{(\w+?)\}/', '(?P<$1>[^/]+)', $this->path);
        $pattern = '#^' . $pattern . '$#';

        if (!preg_match($pattern, $path, $matches)) {
            return [];
        }

        return $matches;
    }

    /**
     * Checking found parameters for type validation.
     *
     * @param array $matches
     * @return bool
     */
    public function matches(array $matches): bool
    {
        foreach ($matches as $key => $match) {
            if (!is_string($key)) {
                continue;
            }

            if (isset($this->types[$key]) && preg_match('/^' . $this->types[$key] . '$/', $match)) {
                continue;
            }

            return false;
        }

        return true;
    }

    /**
     * Extracting matched parameter values.
     *
     * @param array $matches
     * @return array
     */
    public function getMatchedParams(array $matches): array
    {
        $params = [];

        foreach ($matches as $key => $match) {
            if (is_string($key)) {
                $params[$key] = $match;
            }
        }

        return $params;
    }

    /**
     * Validating that, requested HTTP method is allowed.
     *
     * @param string $method
     * @return bool
     */
    public function methodMatch(string $method): bool
    {
        return in_array($method, $this->methods);
    }

    /**
     * Getter method for params.
     * Returns parameter key => value map from path.
     *
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Set found params.
     *
     * @param array $params
     * @return $this
     */
    public function setParams(array $params): Route
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Getting defined controller for found route.
     *
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * Getting defined action method for found route.
     *
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }
}
