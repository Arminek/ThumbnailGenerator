<?php

declare(strict_types=1);

namespace App\Tests\Application;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

final class GenerateThumbnailTest extends KernelTestCase
{
    private const TEST_UPLOAD_DIR = '/tests/upload';

    private readonly Application $application;
    private readonly string $rootDir;
    private readonly Filesystem $filesystem;

    protected function setUp(): void
    {
        parent::setUp();

        $kernel = self::bootKernel();
        $this->application = new Application($kernel);
        $this->filesystem = new Filesystem();
        $this->rootDir = $kernel->getContainer()->getParameter('kernel.project_dir');
    }

    /**
     * @test
     */
    public function it_has_default_upload_directory(): void
    {
        $command = $this->application->find('app:generate-thumbnail');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $output = $commandTester->getDisplay();
        $commandTester->assertCommandIsSuccessful();
        $this->assertStringContainsString(sprintf('Current upload directory: %s/upload', $this->rootDir), $output);
    }

    /**
     * @test
     */
    public function it_uses_parameter_for_upload_directory(): void
    {
        $command = $this->application->find('app:generate-thumbnail');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['--upload-dir' => self::TEST_UPLOAD_DIR]);

        $output = $commandTester->getDisplay();
        $commandTester->assertCommandIsSuccessful();
        $this->assertStringContainsString(sprintf('Current upload directory: %s/tests/upload', $this->rootDir), $output);
    }

    /**
     * @test
     */
    public function it_lists_files_as_options_for_thumbnail(): void
    {
        $images = ['a.jpg', 'b.jpg', 'c.jpg'];
        $this->thereAreSomeImages($images);
        $command = $this->application->find('app:generate-thumbnail');
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['b.jpg']);
        $commandTester->execute(['--upload-dir' => self::TEST_UPLOAD_DIR]);

        $output = $commandTester->getDisplay();
        $commandTester->assertCommandIsSuccessful();
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
            $this->filesystem->touch(sprintf('%s/%s', $this->path(), $image));
        }
    }

    private function path(): string
    {
        return sprintf('%s%s', $this->rootDir, self::TEST_UPLOAD_DIR);
    }
}
