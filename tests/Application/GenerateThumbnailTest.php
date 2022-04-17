<?php

declare(strict_types=1);

namespace App\Tests\Application;

use App\Infrastructure\Cli\GenerateThumbnail;
use Imagine\Image\Box;
use Imagine\Image\ImagineInterface;
use Imagine\Image\Palette\RGB;
use Imagine\Imagick\Imagine;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

final class GenerateThumbnailTest extends KernelTestCase
{
    private const TEST_UPLOAD_DIR = '/tests/upload';

    private readonly string $rootDir;
    private readonly Filesystem $filesystem;
    private readonly CommandTester $commandTester;
    private readonly ImagineInterface $imagine;

    protected function setUp(): void
    {
        parent::setUp();

        $kernel = self::bootKernel();
        $this->filesystem = new Filesystem();
        $this->rootDir = $kernel->getContainer()->getParameter('kernel.project_dir');

        $application = new Application($kernel);
        $command = $application->find(GenerateThumbnail::getDefaultName());
        $this->commandTester = new CommandTester($command);

        $this->imagine = new Imagine();
    }

    /**
     * @test
     */
    public function it_has_default_upload_directory(): void
    {
        $this->commandTester->execute([]);

        $output = $this->commandTester->getDisplay();
        $this->commandTester->assertCommandIsSuccessful();
        $this->assertStringContainsString(sprintf('Current upload directory: %s/upload', $this->rootDir), $output);
    }

    /**
     * @test
     */
    public function it_uses_parameter_for_upload_directory(): void
    {
        $this->commandTester->execute(['--upload-dir' => self::TEST_UPLOAD_DIR]);

        $output = $this->commandTester->getDisplay();
        $this->commandTester->assertCommandIsSuccessful();
        $this->assertStringContainsString(sprintf('Current upload directory: %s/tests/upload', $this->rootDir), $output);
    }

    /**
     * @test
     */
    public function it_lists_files_as_options_for_thumbnails(): void
    {
        $images = ['a.jpg', 'b.jpg', 'c.jpg'];
        $this->thereAreSomeImages($images);
        $this->commandTester->setInputs(['b.jpg']);
        $this->commandTester->execute(['--upload-dir' => self::TEST_UPLOAD_DIR]);

        $output = $this->commandTester->getDisplay();
        $this->commandTester->assertCommandIsSuccessful();
        $this->assertStringContainsString('Which files?', $output);

        foreach ($images as $image) {
            $this->assertStringContainsString(sprintf('[%s/%s] %s', $this->path(), $image, $image), $output);
        }
    }

    /**
     * @after
     */
    public function purge(): void
    {
        if ($this->filesystem->exists($this->path())) {
            $this->filesystem->remove($this->path());
        }
    }

    /**
     * @param string[] $images
     */
    private function thereAreSomeImages(array $images): void
    {
        if (!$this->filesystem->exists($this->path())) {
            $this->filesystem->mkdir($this->path());
        }

        foreach ($images as $image) {
            $this->createImage(sprintf('%s/%s', $this->path(), $image));
        }
    }

    private function createImage(string $path): void
    {
        $palette = new RGB();
        $size  = new Box(400, 300);
        $color = $palette->color('#000', 0);
        $this->imagine
            ->create($size, $color)
            ->save($path);
    }

    private function path(): string
    {
        return sprintf('%s%s', $this->rootDir, self::TEST_UPLOAD_DIR);
    }
}
