<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

#[AsCommand(
    name: 'app:reset-database',
    description: 'Drops, recreates, migrates and seeds the database.',
)]
class ResetDatabaseCommand extends Command
{
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {

        $io = new SymfonyStyle($input, $output);

        $commands = [
            'php bin/console doctrine:database:drop --force --if-exists',
            'php bin/console doctrine:database:create',
            'php bin/console doctrine:migrations:migrate --no-interaction',
            'php bin/console doctrine:fixtures:load --no-interaction',
        ];

        foreach ($commands as $command) {

            $io->section(sprintf(
                'Running: %s',
                $command
            ));

            $process = Process::fromShellCommandline($command);

            $process->setTimeout(null);

            $process->run(function ($type, $buffer) use ($output) {
                $output->write($buffer);
            });

            if (!$process->isSuccessful()) {

                $io->error(sprintf(
                    'Error while running: %s',
                    $command
                ));

                return Command::FAILURE;
            }
        }

        $io->success('Database successfully reset.');

        return Command::SUCCESS;
    }
}
