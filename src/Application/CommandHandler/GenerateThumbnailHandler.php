<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\GenerateThumbnail;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class GenerateThumbnailHandler implements MessageHandlerInterface
{
    public function __invoke(GenerateThumbnail $command): void
    {

    }
}
