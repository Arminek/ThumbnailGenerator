<?php

declare(strict_types=1);

namespace App\Tests\Application;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\HttpFoundation\Request;

final class GreetingsTest extends WebTestCase
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
    public function it_greets_caller(): void
    {
        $this->client->request(Request::METHOD_GET, '/v1/greetings/Arminek');

        $this->assertResponseIsSuccessful();
        $content = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('message', $content);
        $this->assertEquals('Hello Arminek!', $content['message']);
    }
}
