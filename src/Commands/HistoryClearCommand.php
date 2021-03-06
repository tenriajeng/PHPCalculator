<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\History\CommandHistoryManager;
use Jakmall\Recruitment\Calculator\History\CommandHistoryServiceProvider;
use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;
use Symfony\Component\Console\Helper\Table;

class HistoryClearCommand extends Command
{
    //use HasCommand;

    /**
     * @var string
     */
    protected $command = 'history:clear';

    public function __construct()
    {
        $this->getDescriptions();
        $command = $this->command;
        $argument = "Find the data by the specified id";
        $this->signature = sprintf(
            '%s {commands?* : %s} ',
            $command,
            $argument,
        );

        parent::__construct();
    }

    public function handle(CommandHistoryManagerInterface $history): void
    {
        $commands = $this->argument('commands');

        if (empty($commands)) {
            $history->clearAll('mesinhitung.log', 'delete');
            $history->clearAll('latest.log', 'delete');
            $this->comment(sprintf('Success delete all data in every driver', $commands));
        } else {
            $history->clear('latest.log', $commands[0]);
            $history->clear('file.log', $commands[0]);
            $this->comment(sprintf('Success delete data id "%s" in every driver.', $commands[0]));
        }
    }

    protected function getDescriptions(): void
    {
        $this->description = 'Show result history with request';
    }
}
