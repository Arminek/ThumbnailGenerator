<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Application\Repository\ThumbnailRepository;
use Aws\S3\S3ClientInterface;
use Symfony\Component\Finder\SplFileInfo;

final class S3BucketThumbnailRepository implements ThumbnailRepository
{
    public function __construct(
        private readonly S3ClientInterface $client,
        private readonly string $bucket
    ) {}

    public function save(SplFileInfo $thumbnail): void
    {
        $this->client->upload(
            $this->bucket,
            $thumbnail->getFilename(),
            $thumbnail->getContents()
        );
    }
}
