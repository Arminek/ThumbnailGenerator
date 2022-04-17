<?php

declare(strict_types=1);

namespace spec\App\Infrastructure\Repository;

use App\Application\Repository\ThumbnailRepository;
use App\Infrastructure\Repository\S3BucketThumbnailRepository;
use Aws\S3\S3ClientInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Finder\SplFileInfo;

final class S3BucketThumbnailRepositorySpec extends ObjectBehavior
{
    function let(S3ClientInterface $client): void
    {
        $this->beConstructedWith($client, 'thumbnails');
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(S3BucketThumbnailRepository::class);
    }

    function it_is_thumbnail_repository(): void
    {
        $this->shouldImplement(ThumbnailRepository::class);
    }

    function it_saves_thumbnail_in_s3_bucket(S3ClientInterface $client, SplFileInfo $image): void
    {
        $image->getFilename()->willReturn('some.jpg');
        $image->getContents()->willReturn('xyz');

        $client->upload(
            'thumbnails',
            'some.jpg',
            'xyz'
        )->shouldBeCalled();

        $this->save($image);
    }
}
