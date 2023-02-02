<?php

namespace App\Core;

class Config
{
    /**
     * @var string
     */
    private string $routesDir;

    /**
     * @var string
     */
    private string $controllersNamespace;

    /**
     * @var string
     */
    private string $templateEngine;

    /**
     * @var string
     */
    private string $templateDir;

    /**
     * @var string
     */
    private string $notFoundTemplate;

    /**
     * @var bool
     */
    private bool $debugMode;

    /**
     * @return string
     */
    public function getNotFoundTemplate(): string
    {
        return $this->notFoundTemplate;
    }

    /**
     * @param string $notFoundTemplate
     * @return Config
     */
    public function setNotFoundTemplate(string $notFoundTemplate): Config
    {
        $this->notFoundTemplate = $notFoundTemplate;
        return $this;
    }

    /**
     * @return string
     */
    public function getRoutesDir(): string
    {
        return $this->routesDir;
    }

    /**
     * @param string $routesDir
     * @return Config
     */
    public function setRoutesDir(string $routesDir): Config
    {
        $this->routesDir = $routesDir;

        return $this;
    }

    /**
     * @return string
     */
    public function getControllersNamespace(): string
    {
        return $this->controllersNamespace;
    }

    /**
     * @param string $controllersNamespace
     * @return Config
     */
    public function setControllersNamespace(string $controllersNamespace): Config
    {
        $this->controllersNamespace = $controllersNamespace;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplateDir(): string
    {
        return $this->templateDir;
    }

    /**
     * @param string $templateDir
     * @return Config
     */
    public function setTemplateDir(string $templateDir): Config
    {
        $this->templateDir = $templateDir;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplateEngine(): string
    {
        return $this->templateEngine;
    }

    /**
     * @param string $templateEngine
     * @return Config
     */
    public function setTemplateEngine(string $templateEngine): Config
    {
        $this->templateEngine = $templateEngine;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDebugMode(): bool
    {
        return $this->debugMode;
    }

    /**
     * @param bool $debugMode
     * @return Config
     */
    public function setDebugMode(bool $debugMode): Config
    {
        $this->debugMode = $debugMode;

        return $this;
    }
}
