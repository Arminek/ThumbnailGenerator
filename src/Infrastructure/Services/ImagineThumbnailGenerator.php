<?php

declare(strict_types=1);

namespace App\Infrastructure\Services;

use App\Application\Services\ThumbnailGenerator;
use Imagine\Image\Box;
use Imagine\Image\ImagineInterface;
use Symfony\Component\Finder\SplFileInfo;

final class ImagineThumbnailGenerator implements ThumbnailGenerator
{
    public function __construct(
        private readonly ImagineInterface $imagine
    ) {}

    public function generate(SplFileInfo $sourceImage, int $width, int $height): SplFileInfo
    {
        $thumbnailPath = sprintf(
            '%s/%s',
            $sourceImage->getPath(),
            str_replace(
                $sourceImage->getExtension(),
                sprintf('%s-%s.%s', $sourceImage->getFilename(), uniqid(), $sourceImage->getExtension()),
                $sourceImage->getFilename()
            )
        );

        $this->imagine
            ->open(sprintf('%s/%s', $sourceImage->getPath(), $sourceImage->getFilename()))
            ->thumbnail(new Box($width, $height))
            ->save($thumbnailPath);

        return new SplFileInfo($thumbnailPath, $sourceImage->getRelativePath(), $sourceImage->getRelativePathname());
    }
}
