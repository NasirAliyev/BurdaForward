<?php

namespace App\Core\TemplateEngine;

use Exception;

class TemplateEngineFactory
{
    /**
     * Template engine factory.
     * Implementation of factory pattern.
     *
     * @param string $engine
     * @param string $templateDir
     *
     * @return TemplateEngineInterface
     *
     * @throws Exception
     */
    public function make(string $engine, string $templateDir): TemplateEngineInterface
    {
        switch ($engine) {
            case TemplateEngineInterface::TEMPLATE_ENGINE_TWIG:
                return new Twig($templateDir);
        }

        throw new Exception("Requested template engine not found");
    }
}
