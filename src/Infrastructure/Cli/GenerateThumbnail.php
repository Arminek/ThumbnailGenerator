<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GenerateThumbnail extends Command
{
    protected static $defaultName = 'app:generate-thumbnail';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("Done!");

        return Command::SUCCESS;
    }
}
