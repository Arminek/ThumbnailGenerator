<?php

declare(strict_types=1);

namespace App\Tests\Application;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\HttpFoundation\Request;

final class DocumentationTest extends WebTestCase
{
    private AbstractBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
    }

    /**
     * @test
     */
    public function it_returns_open_api_documentation(): void
    {
        $this->client->request(Request::METHOD_GET, '/_doc');
        $this->assertResponseIsSuccessful();
    }
}
