<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Command\GenerateThumbnail;

interface ThumbnailGenerator
{
    public function generate(GenerateThumbnail $command): void;
}
