<?php

declare(strict_types=1);

namespace App\Tests\Application;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

final class GenerateThumbnailTest extends KernelTestCase
{
    private Application $application;
    private readonly string $rootDir;

    protected function setUp(): void
    {
        parent::setUp();

        $kernel = self::bootKernel();
        $this->application = new Application($kernel);
        $this->rootDir = $kernel->getContainer()->getParameter('kernel.project_dir');
    }

    /**
     * @test
     */
    public function it_generates_thumbnail(): void
    {
        $command = $this->application->find('app:generate-thumbnail');
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(["no"]);
        $commandTester->execute([]);
        $commandTester->assertCommandIsSuccessful();
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString(
            sprintf('Do you want to change upload directory? Current (%s/upload)', $this->rootDir),
            $output
        );
        $this->assertStringContainsString('Done!', $output);
    }
}
