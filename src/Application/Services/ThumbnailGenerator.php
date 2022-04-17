<?php

declare(strict_types=1);

namespace App\Application\Services;

use Symfony\Component\Finder\SplFileInfo;

interface ThumbnailGenerator
{
    public function generate(SplFileInfo $sourceImage, int $width, int $height): SplFileInfo;
}
