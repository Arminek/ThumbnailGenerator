<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\GenerateThumbnail;
use App\Application\Repository\ThumbnailRepository;
use App\Application\Services\ThumbnailGenerator;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class GenerateThumbnailHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly ThumbnailGenerator $generator,
        private readonly ThumbnailRepository $repository,
        private readonly Filesystem $filesystem
    ) {}

    public function __invoke(GenerateThumbnail $command): void
    {
        $thumbnail = $this->generator->generate($command->sourceFile, $command->width, $command->height);
        $this->repository->save($thumbnail);
        $this->filesystem->remove($thumbnail->getPathname());
    }
}
