<?php

namespace Nacosvel\Console\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class DemoCommand extends Command
{
    /**
     * @var string|null The default command name
     */
    protected static $defaultName = 'demo';

    /**
     * @var string|null The default command description
     */
    protected static $defaultDescription = 'demo description';

    protected function handle(): int
    {
        $this->line($this->argument('name'));
        $this->line($this->option('option'));

        $this->line('line');
        $this->newLine();
        $this->info('info');
        $this->warn('warn');
        $this->error('error');
        $this->question('question');
        $this->comment('comment');

        return self::SUCCESS;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::OPTIONAL, 'The name of the class', 'demo'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            ['option', 'o', InputOption::VALUE_OPTIONAL, 'description', 'default'],
        ];
    }

}
