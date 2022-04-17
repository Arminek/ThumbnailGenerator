<?php

declare(strict_types=1);

namespace spec\App\Infrastructure\Services;

use App\Application\Command\GenerateThumbnail;
use App\Application\Services\ThumbnailGenerator;
use App\Infrastructure\Services\ImagineThumbnailGenerator;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\ImagineInterface;
use Imagine\Image\ManipulatorInterface;
use PhpSpec\ObjectBehavior;

final class ImagineThumbnailGeneratorSpec extends ObjectBehavior
{
    function let(ImagineInterface $imagine): void
    {
        $this->beConstructedWith($imagine);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ImagineThumbnailGenerator::class);
    }

    function it_is_thumbnail_generator(): void
    {
        $this->shouldImplement(ThumbnailGenerator::class);
    }

    function it_generates_thumbnail_in_temporary_location(
        ImagineInterface $imagine,
        ImageInterface $image,
        ManipulatorInterface $manipulator
    ): void {
        $imagine->open('/some/source/path')->willReturn($image);
        $image->thumbnail(new Box(100, 200))->willReturn($manipulator);

        $manipulator->save('/some/target/path')->shouldBeCalled();
        $this->generate(new GenerateThumbnail('/some/source/path', '/some/target/path', 100, 200));
    }
}
