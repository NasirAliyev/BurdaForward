<?php

namespace App\Tests\Unit\Core\TemplateEngine;

use App\Core\TemplateEngine\TemplateEngineFactory;
use App\Core\TemplateEngine\TemplateEngineInterface;
use App\Core\TemplateEngine\Twig;
use Exception;
use PHPUnit\Framework\TestCase;

class TemplateEngineFactoryTest extends TestCase
{
    private const TEMPLATE_DIR = __DIR__ . '/templates';

    /**
     * @throws Exception
     */
    public function testMakeWithValidEngine()
    {
        $factory = new TemplateEngineFactory();

        $engine = $factory->make(TemplateEngineInterface::TEMPLATE_ENGINE_TWIG, self::TEMPLATE_DIR);

        $this->assertInstanceOf(Twig::class, $engine);
    }

    public function testMakeWithInvalidEngine()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Requested template engine not found');

        $factory = new TemplateEngineFactory();
        $factory->make('invalid_engine', self::TEMPLATE_DIR);
    }
}
