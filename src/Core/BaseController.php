<?php

namespace App\Core;

use App\Core\TemplateEngine\TemplateEngineInterface;

abstract class BaseController
{
    public TemplateEngineInterface $view;

    /**
     * This method is used for Dependency Injection into Base Controller class.
     *
     * @param TemplateEngineInterface $templateEngine
     */
    public function injectDependencies(TemplateEngineInterface $templateEngine)
    {
        $this->view = $templateEngine;
    }
}
