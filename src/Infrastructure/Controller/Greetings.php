<?php

namespace App\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class Greetings
{
    public function __invoke(string $name): Response
    {
        return new JsonResponse(['message' => sprintf('Hello %s!', $name)]);
    }
}
