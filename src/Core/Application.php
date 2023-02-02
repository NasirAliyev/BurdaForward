<?php

namespace App\Core;

use App\Core\TemplateEngine\TemplateEngineFactory;
use App\Core\TemplateEngine\TemplateEngineInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;
use Throwable;

class Application
{
    /**
     * @var TemplateEngineInterface
     */
    public TemplateEngineInterface $templateEngine;

    /**
     * Application constructor method.
     *
     * @param Config $config
     * @param Request $request
     */
    public function __construct(
        private Config $config,
        private Request $request,
    ) {
    }

    /**
     * The main method for running whole application execution from outside.
     */
    public function run(): void
    {
        try {
            $router = $this->makeRouter();
            $this->setTemplateEngine();

            $route = $router->findRoute($this->request->getPathInfo(), $this->request->getMethod());
            if (!$route) {
                $this->showNotFound();
                return;
            }

            $this->execute($route);
        } catch (Throwable $e) {
            $this->handleException($e);
        }
    }

    /**
     * Router factory method.
     *
     * @return Router
     * @throws Exception
     */
    private function makeRouter(): Router
    {
        $routes = $this->getParsedRoutes();
        if (!$routes) {
            throw new Exception('No routes defined');
        }

        $router = new Router();

        foreach ($routes['routes'] as $route) {
            $router->addRoute(
                new Route(
                    $route['path'] ?? '',
                    $route['types'] ?? [],
                    $route['controller'] ?? '',
                    $route['action'] ?? '',
                    $route['methods'] ?? [],
                )
            );
        }

        return $router;
    }

    /**
     * Execute route
     *
     * @param Route $route
     *
     * @throws Exception
     */
    private function execute(Route $route): void
    {
        $className = $this->config->getControllersNamespace() . '\\' . $route->getController();
        $methodName = $route->getAction();

        if (class_exists($className) && method_exists($className, $methodName)) {
            /** @var BaseController $class */
            $class = new $className();
            $class->injectDependencies($this->templateEngine);

            call_user_func_array([$class, $methodName], [$this->request, $route->getParams()]);
            return;
        }

        throw new Exception('Controller or action not found');
    }

    /**
     * Making template engine depending on configs.
     *
     * @throws Exception
     */
    private function setTemplateEngine()
    {
        $this->templateEngine = (new TemplateEngineFactory())->make(
            $this->config->getTemplateEngine(),
            APP . $this->config->getTemplateDir(),
        );
    }

    /**
     * Showing default not found page based on configs.
     */
    private function showNotFound(): void
    {
        http_response_code(Response::HTTP_NOT_FOUND);

        $this->templateEngine->show($this->config->getNotFoundTemplate());
    }

    /**
     * Handling basic expected exceptions.
     *
     * @param Throwable $e
     */
    private function handleException(Throwable $e): void
    {
        http_response_code(Response::HTTP_INTERNAL_SERVER_ERROR);

        if ($this->config->isDebugMode()) {
            echo $e->getMessage();
            return;
        }

        echo 'Internal Server Error';
    }

    /**
     *
     * @return array
     */
    private function getParsedRoutes(): array
    {
        $ymlParser = new Yaml();

        try {
            return $ymlParser->parseFile(
                $this->config->getRoutesDir()
            );
        } catch (Throwable) {
            return [];
        }
    }
}
