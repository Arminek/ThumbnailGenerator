<?php

declare(strict_types=1);

namespace spec\App\Application\CommandHandler;

use App\Application\Command\GenerateThumbnail;
use App\Application\CommandHandler\GenerateThumbnailHandler;
use App\Application\Repository\ThumbnailRepository;
use App\Application\Services\ThumbnailGenerator;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;

final class GenerateThumbnailHandlerSpec extends ObjectBehavior
{
    function let(ThumbnailGenerator $generator, ThumbnailRepository $repository, Filesystem $filesystem)
    {
        $this->beConstructedWith($generator, $repository, $filesystem);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(GenerateThumbnailHandler::class);
    }

    function it_coordinates_thumbnail_generation(
        ThumbnailGenerator $generator,
        ThumbnailRepository $repository,
        Filesystem $filesystem
    ): void {
        $image = new SplFileInfo('/some/source/path.jpg', '/some-relative/source/path', '/relative-path-name');
        $thumbnail = new SplFileInfo('/some/generated/path.jpg', '/some-relative/generated/path', '/relative-path-name');
        $generator->generate($image, 100, 100)->willReturn($thumbnail);
        $repository->save($thumbnail)->shouldBeCalled();
        $filesystem->remove('/some/generated/path.jpg')->shouldBeCalled();

        $this(new GenerateThumbnail($image, 100, 100));
    }
}
