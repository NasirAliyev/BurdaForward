<?php

namespace App\Tests\Unit\Core;

use App\Core\Route;
use App\Core\Router;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private Router $router;

    private MockObject $routeMock;

    protected function setUp(): void
    {
        $this->router = new Router();
        $this->routeMock = $this->createMock(Route::class);
    }

    public function testAddRoute(): void
    {
        $this->router->addRoute($this->routeMock);
        $this->assertCount(1, $this->router->getRoutes());
    }

    public function testFindRouteWithMatch(): void
    {
        $this->routeMock->method('getPathMatch')->willReturn(['/']);
        $this->routeMock->method('methodMatch')->willReturn(true);
        $this->routeMock->method('matches')->willReturn(true);
        $this->router->addRoute($this->routeMock);

        $route = $this->router->findRoute('/test', 'GET');
        $this->assertSame($this->routeMock, $route);
    }

    public function testFindRouteWhenMatchWithParams(): void
    {
        $this->routeMock->method('getPathMatch')->willReturn(
            [
                '/blog/2022/01/03',
                'year' => 2022,
                2022,
                'month' => '01',
                '01',
                'day' => '03',
                '03',
            ]
        );
        $this->routeMock->method('methodMatch')->willReturn(false);
        $this->routeMock->method('matches')->willReturn(true);
        $this->router->addRoute($this->routeMock);

        $route = $this->router->findRoute('/blog/2022/01/03', 'GET');
        $this->assertNull($route);
    }

    public function testFindRouteWithNoMethodMatch(): void
    {
        $this->routeMock->method('getPathMatch')->willReturn(['/']);
        $this->routeMock->method('methodMatch')->willReturn(false);
        $this->routeMock->method('matches')->willReturn(true);
        $this->router->addRoute($this->routeMock);

        $route = $this->router->findRoute('/test', 'GET');
        $this->assertNull($route);
    }

    public function testFindRouteWithoutMatch(): void
    {
        $this->routeMock->method('getPathMatch')->willReturn([]);
        $this->router->addRoute($this->routeMock);

        $route = $this->router->findRoute('/test', 'GET');
        $this->assertNull($route);
    }
}
