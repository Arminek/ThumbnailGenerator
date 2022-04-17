<?php

declare(strict_types=1);

namespace App\Application\Command;

final class GenerateThumbnail
{
    public function __construct(
        public readonly string $sourcePath,
        public readonly string $temporaryPath,
        public readonly int $width,
        public readonly int $height
    ) {}
}
