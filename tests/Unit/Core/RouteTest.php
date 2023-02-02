<?php

namespace App\Tests\Unit\Core;

use App\Core\Route;
use Generator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class RouteTest extends TestCase
{
    public function testGetPathMatchSucceeded()
    {
        $route = $this->makeBlogRoute();

        $matches = $route->getPathMatch('/blog/2023/02/03');
        $this->assertCount(7, $matches);
        $this->assertArrayHasKey('year', $matches);
        $this->assertArrayHasKey('month', $matches);
        $this->assertArrayHasKey('day', $matches);
        $this->assertEquals('2023', $matches['year']);
        $this->assertEquals('02', $matches['month']);
        $this->assertEquals('03', $matches['day']);
    }

    public function testMatchesTrue()
    {
        $route = $this->makeBlogRoute();
        $matches = $route->getPathMatch('/blog/2023/02/03');
        $this->assertTrue($route->matches($matches));
    }

    public function testGetMatchedParams()
    {
        $route = $this->makeBlogRoute();
        $matches = $route->getPathMatch('/blog/2023/02/03');
        $params = $route->getMatchedParams($matches);

        $this->assertArrayHasKey('year', $params);
        $this->assertArrayHasKey('month', $params);
        $this->assertArrayHasKey('day', $params);
        $this->assertEquals('2023', $params['year']);
        $this->assertEquals('02', $params['month']);
        $this->assertEquals('03', $params['day']);
    }

    public function testMethodMatchSucceeded()
    {
        $route = $this->makeBlogRoute();
        $this->assertTrue($route->methodMatch(Request::METHOD_GET));
        $this->assertTrue($route->methodMatch(Request::METHOD_POST));
    }

    public function testMethodMatchFails()
    {
        $route = $this->makeBlogRoute();
        $this->assertFalse($route->methodMatch(Request::METHOD_PUT));
    }

    /**
     * @dataProvider failedCasesOnPathMatch
     * @param Route $route
     * @param string $path
     */
    public function testGetPathMatchFailed(Route $route, string $path)
    {
        $matches = $route->getPathMatch($path);
        $this->assertEmpty($matches);
    }

    /**
     * @dataProvider failedCasesOnParameterValidation
     * @param Route $route
     * @param string $path
     */
    public function testMatchesFailed(Route $route, string $path)
    {
        $matches = $route->getPathMatch($path);
        $this->assertFalse($route->matches($matches));
    }

    private function failedCasesOnPathMatch(): Generator
    {
        yield [
            $this->makeBlogRoute(),
            '/blog/2023/02/02/extra',
        ];
        yield [
            $this->makeBlogRoute(),
            '/blog/2023/02',
        ];
        yield [
            $this->makeBlogRoute(),
            '/blog',
        ];
        yield [
            $this->makeBlogRoute(),
            '/blog/2023',
        ];
    }

    private function failedCasesOnParameterValidation(): Generator
    {
        yield [
            $this->makeBlogRoute(),
            '/blog/2023/0A/02',
        ];
        yield [
            $this->makeBlogRoute(),
            '/blog/2023/02/o2',
        ];
        yield [
            $this->makeBlogRoute(),
            '/blog/2o23/03/20',
        ];
        yield [
            $this->makeBlogRoute(),
            '/blog/2023/ee/02',
        ];
    }

    private function makeBlogRoute(): Route
    {
        return new Route(
            '/blog/{year}/{month}/{day}',
            ['year' => '\d{4}', 'month' => '\d{2}', 'day' => '\d{2}'],
            'TestController',
            'TestAction',
            [Request::METHOD_GET, Request::METHOD_POST]
        );
    }
}
