<?php

namespace App\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class Health
{
    public function __invoke(): Response
    {
        return new JsonResponse(['message' => "Healthy"]);
    }
}
