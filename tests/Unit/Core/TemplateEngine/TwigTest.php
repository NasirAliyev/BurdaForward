<?php

namespace App\Tests\Unit\Core\TemplateEngine;

use App\Core\TemplateEngine\Twig;
use PHPUnit\Framework\TestCase;

class TwigTest extends TestCase
{
    private const TEMPLATE_DIR = __DIR__ . '/templates';

    public function testRender()
    {
        $twig = new Twig(self::TEMPLATE_DIR);
        $result = $twig->render('index.twig', ['name' => 'John Doe']);

        $this->assertEquals('Hello, John Doe', $result);
    }

    public function testShow()
    {
        $twig = new Twig(self::TEMPLATE_DIR);

        ob_start();
        $twig->show('index.twig', ['name' => 'John Doe']);
        $result = ob_get_clean();

        $this->assertEquals('Hello, John Doe', $result);
    }

    public function testRenderWithInvalidTemplate()
    {
        $twig = new Twig(self::TEMPLATE_DIR);
        $result = $twig->render('invalid_template.twig', ['name' => 'John Doe']);

        $this->assertEquals('Failed to load twig template', $result);
    }

    public function testShowWithInvalidTemplate()
    {
        $twig = new Twig(self::TEMPLATE_DIR);

        ob_start();
        $twig->show('invalid_template.twig', ['name' => 'John Doe']);
        $result = ob_get_clean();

        $this->assertEquals('Failed to load twig template', $result);
    }
}
