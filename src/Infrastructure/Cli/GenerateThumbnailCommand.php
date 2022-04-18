<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli;

use App\Application\Command\GenerateThumbnail;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Messenger\MessageBusInterface;

final class GenerateThumbnailCommand extends Command
{
    private const DEFAULT_UPLOAD_DIR = '/upload';
    private const DEFAULT_WIDTH = 150;
    private const DEFAULT_HEIGHT = 150;

    protected static $defaultName = 'app:generate-thumbnail';
    private readonly Finder $finder;
    private readonly Filesystem $filesystem;

    public function __construct(
        private readonly string $rootDir,
        private readonly MessageBusInterface $messageBus
    ) {
        $this->finder = new Finder();
        $this->filesystem = new Filesystem();
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command allows you to generate thumbnails!')
            ->addOption(
                'upload-dir',
                null,
                InputOption::VALUE_OPTIONAL,
                sprintf('Choose within %s as your upload directory', $this->rootDir),
                self::DEFAULT_UPLOAD_DIR
            )
            ->addOption(
                'width',
                null,
                InputOption::VALUE_OPTIONAL,
                'Width of the thumbnails',
                self::DEFAULT_WIDTH
            )
            ->addOption(
                'height',
                null,
                InputOption::VALUE_OPTIONAL,
                'Height of the thumbnails',
                self::DEFAULT_HEIGHT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $path = $this->pathFromInput($input);
        $output->writeln(sprintf('Current upload directory: %s', $path));
        if (!$this->filesystem->exists($path)) {
            $this->filesystem->mkdir($path);
        }

        $this->finder->in($path);
        $choices = iterator_to_array($this->finder->files()->getIterator());
        $choiceNames = array_map(fn(SplFileInfo $file) => $file->getFilename(), $choices);

        if (count($choiceNames) !== 0) {
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion('Which files?', $choiceNames, 0);
            $question->setMultiselect(true);
            $chosenImages = $helper->ask($input, $output, $question);

            foreach ($chosenImages as $chosenImage) {
                $width = $input->getOption('width');
                $height = $input->getOption('height');
                $this->messageBus->dispatch(
                    new GenerateThumbnail(
                        $choices[$chosenImage],
                        $width,
                        $height
                    )
                );
                $output->writeln(sprintf('Thumbnail generated for: %s (%sx%s)', $chosenImage, $width, $height));
            }
        }

        return Command::SUCCESS;
    }

    private function pathFromInput(InputInterface $input): string
    {
        $uploadDir = trim($input->getOption('upload-dir'));
        if ('/' !== $uploadDir[0]) {
            $uploadDir = '/'.$uploadDir;
        }

        return sprintf('%s%s', $this->rootDir, $uploadDir);
    }
}
