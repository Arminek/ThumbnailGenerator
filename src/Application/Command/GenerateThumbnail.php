<?php

declare(strict_types=1);

namespace App\Application\Command;

use Symfony\Component\Finder\SplFileInfo;

final class GenerateThumbnail
{
    public function __construct(
        public readonly SplFileInfo $sourceFile,
        public readonly int $width,
        public readonly int $height
    ) {}
}
