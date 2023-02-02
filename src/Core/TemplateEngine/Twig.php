<?php

namespace App\Core\TemplateEngine;

use Throwable;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Twig implements TemplateEngineInterface
{
    private Environment $twig;

    /**
     * Twig constructor.
     * @param string $templateDir
     */
    public function __construct(string $templateDir)
    {
        $loader = new FilesystemLoader($templateDir);
        $this->twig = new Environment($loader);
    }

    /**
     * @inheritdoc
     */
    public function render(string $template, array $context = []): string
    {
        try {
            return $this->twig->load($template)->render($context);
        } catch (Throwable) {
            return 'Failed to load twig template';
        }
    }

    /**
     * @inheritdoc
     */
    public function show(string $template, array $context = []): void
    {
        echo $this->render($template, $context);
    }
}
