<?php

declare(strict_types=1);

namespace App\Infrastructure\Services;

use App\Application\Command\GenerateThumbnail;
use App\Application\Services\ThumbnailGenerator;
use Imagine\Image\Box;
use Imagine\Image\ImagineInterface;

final class ImagineThumbnailGenerator implements ThumbnailGenerator
{
    public function __construct(
        private readonly ImagineInterface $imagine
    ) {}

    public function generate(GenerateThumbnail $command): void
    {
        $this->imagine
            ->open($command->sourcePath)
            ->thumbnail(new Box($command->width, $command->height))
            ->save($command->temporaryPath);
    }
}
