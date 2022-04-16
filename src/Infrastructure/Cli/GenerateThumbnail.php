<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

final class GenerateThumbnail extends Command
{
    private const DEFAULT_UPLOAD_DIR = '/upload';

    protected static $defaultName = 'app:generate-thumbnail';
    private readonly Finder $finder;
    private readonly Filesystem $filesystem;

    public function __construct(private readonly string $rootDir)
    {
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
        $choices = array_map(
            fn(\SplFileInfo $file) => $file->getFilename(),
            iterator_to_array($this->finder->files()->getIterator())
        );

        if (count($choices) !== 0) {
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion('Which files?', $choices, 0);
            $question->setMultiselect(true);
            $helper->ask($input, $output, $question);
        }

        return Command::SUCCESS;
    }

    private function pathFromInput(InputInterface $input): string
    {
        return sprintf('%s%s', $this->rootDir, $input->getOption('upload-dir'));
    }
}
