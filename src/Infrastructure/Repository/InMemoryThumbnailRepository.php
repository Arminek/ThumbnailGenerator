<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Application\Repository\ThumbnailRepository;
use Symfony\Component\Finder\SplFileInfo;

final class InMemoryThumbnailRepository implements ThumbnailRepository
{
    /** @var SplFileInfo[] */
    private array $memory = [];

    public function save(SplFileInfo $thumbnail): void
    {
        $this->memory[] = $thumbnail;
    }
}
