<?php

namespace Leantime\Command;

use Leantime\Domain\Setting\Repositories\Setting;
use Leantime\Domain\Cron\Services\Cron;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Leantime\Domain\Auth\Models\Roles;
use Symfony\Component\Console\Style\SymfonyStyle;

class RunCronCommand extends Command
{
    protected static $defaultName = 'cron:run';
    protected static $defaultDescription = 'Runs the cronjob';

    protected function configure()
    {
        parent::configure();
    }

    /**
     * Execute the command
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return integer 0 if everything went fine, or an exit code.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $io = new SymfonyStyle($input, $output);

        try {
            $cron = app()->make(Cron::class);
            $result = $cron->runCron();

            if (!$result) {
                $io->error("Cron not executed. Not enough time elapsed");
                return Command::FAILURE;
            }
        } catch (Exception $ex) {
            $io->error($ex);
            return Command::FAILURE;
        }

        $io->success("Cron executed successfully");
        return Command::SUCCESS;
    }
}
