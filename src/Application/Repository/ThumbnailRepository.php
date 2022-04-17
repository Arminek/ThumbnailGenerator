<?php

declare(strict_types=1);

namespace App\Application\Repository;

use Symfony\Component\Finder\SplFileInfo;

interface ThumbnailRepository
{
    public function save(SplFileInfo $thumbnail): void;
}
