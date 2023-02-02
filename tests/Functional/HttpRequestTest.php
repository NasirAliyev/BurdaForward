<?php

namespace App\Tests\Functional;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class HttpRequestTest extends TestCase
{
    private const DOCKER_BASE_URL = 'http://host.docker.internal';
    private const MAIN_PAGE_URI = '/';
    private const BLOG_PAGE_URI = '/blog/2023/01/02';

    /**
     * @throws GuzzleException
     */
    public function testMainPageURL(): void
    {
        $client = new Client();

        $response = $client->get(self::DOCKER_BASE_URL . self::MAIN_PAGE_URI);

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }

    /**
     * @throws GuzzleException
     */
    public function testBlogPageURL(): void
    {
        $client = new Client();

        $response = $client->get(self::DOCKER_BASE_URL . self::BLOG_PAGE_URI);

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }

    /**
     * @throws GuzzleException
     */
    public function testNotExistingURL(): void
    {
        $client = new Client();

        try {
            $client->get(self::DOCKER_BASE_URL . '/not-exist');
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $this->assertSame(Response::HTTP_NOT_FOUND, $response->getStatusCode());
                return;
            }
        }

        $this->fail('Http response is not same as expected');
    }
}
