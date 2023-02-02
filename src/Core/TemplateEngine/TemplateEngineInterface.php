<?php

namespace App\Core\TemplateEngine;

interface TemplateEngineInterface
{
    /**
     * Twig engine.
     * @see https://twig.symfony.com/
     */
    public const TEMPLATE_ENGINE_TWIG = 'twig';

    /**
     * Blade engine.
     * @see https://laravel.com/docs/9.x/blade
     */
    public const TEMPLATE_ENGINE_BLADE = 'blade';

    /**
     * Method for rendering whole page with given data and template.
     *
     * @param string $template
     * @param array $context
     * @return string
     */
    public function render(string $template, array $context = []): string;

    /**
     * Method for showing rendered page.
     *
     * @param string $template
     * @param array $context
     * @return mixed
     */
    public function show(string $template, array $context = []): void;
}
