<?php

namespace App\Infrastructure\Controller;

use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;

final class Documentation
{
    public function __construct(private readonly string $rootDir) {}

    public function __invoke(): Response
    {
        $finder = new Finder();
        $apiDocs = $finder->in(sprintf("%s/docs", $this->rootDir))->files()->name("api.json");
        if ($apiDocs->count() !== 1) {
            throw new \RuntimeException("Missing api.json in /doc");
        }
        $iterator = $apiDocs->getIterator();
        $iterator->rewind();

        return new Response($iterator->current()->getContents());
    }
}
