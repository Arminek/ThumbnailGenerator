<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

final class GenerateThumbnail extends Command
{
    private const DEFAULT_UPLOAD_DIR = 'upload';

    protected static $defaultName = 'app:generate-thumbnail';

    public function __construct(private readonly string $rootDir)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion(
            sprintf(
                'Do you want to change upload directory? Current (%s/%s)',
                $this->rootDir,
                self::DEFAULT_UPLOAD_DIR
            ),
            false
        );
        if ($helper->ask($input, $output, $question)) {

        }

        $output->writeln("Done!");

        return Command::SUCCESS;
    }
}
