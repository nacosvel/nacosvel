<?php

namespace Nacosvel\Console\Command;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends SymfonyCommand
{
    /**
     * The input interface implementation.
     *
     * @var InputInterface
     */
    protected InputInterface $input;

    /**
     * The output interface implementation.
     *
     * @var OutputInterface
     */
    protected OutputInterface $output;

    /**
     * The default verbosity of output commands.
     *
     * @var int
     */
    protected int $verbosity = OutputInterface::VERBOSITY_NORMAL;

    /**
     * The mapping between human-readable verbosity levels and Symfony's OutputInterface.
     *
     * @var array
     */
    protected array $verbosityMap = [
        'v'      => OutputInterface::VERBOSITY_VERBOSE,
        'vv'     => OutputInterface::VERBOSITY_VERY_VERBOSE,
        'vvv'    => OutputInterface::VERBOSITY_DEBUG,
        'quiet'  => OutputInterface::VERBOSITY_QUIET,
        'normal' => OutputInterface::VERBOSITY_NORMAL,
    ];

    public function __construct(string $name = null)
    {
        parent::__construct($name);

        $this->specifyParameters();
    }

    /**
     * Execute the console command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->setInput($input);
        $this->setOutput($output);

        if (false === method_exists($this, 'handle')) {
            throw new LogicException('You must override the handle() method in the concrete command class.');
        }

        return call_user_func([$this, 'handle']);
    }

    /**
     * Determine if the given argument is present.
     *
     * @param int|string $name
     *
     * @return bool
     */
    public function hasArgument(int|string $name): bool
    {
        return $this->input->hasArgument($name);
    }

    /**
     * Get the value of a command argument.
     *
     * @param string|null $key
     *
     * @return array|string|bool|null
     */
    public function argument(string $key = null): bool|array|string|null
    {
        if (is_null($key)) {
            return $this->input->getArguments();
        }

        return $this->input->getArgument($key);
    }

    /**
     * Get all the arguments passed to the command.
     *
     * @return array
     */
    public function arguments(): array
    {
        return $this->argument();
    }

    /**
     * Determine if the given option is present.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasOption(string $name): bool
    {
        return $this->input->hasOption($name);
    }

    /**
     * Get the value of a command option.
     *
     * @param string|null $key
     *
     * @return string|array|bool|null
     */
    public function option(string $key = null): bool|array|string|null
    {
        if (is_null($key)) {
            return $this->input->getOptions();
        }

        return $this->input->getOption($key);
    }

    /**
     * Get all the options passed to the command.
     *
     * @return array
     */
    public function options(): array
    {
        return $this->option();
    }

    /**
     * Write a string as information output.
     *
     * @param string          $string
     * @param int|string|null $verbosity
     *
     * @return void
     */
    public function info(string $string, int|string $verbosity = null): void
    {
        $this->line($string, 'info', $verbosity);
    }

    /**
     * Write a string as standard output.
     *
     * @param string          $string
     * @param string|null     $style
     * @param int|string|null $verbosity
     *
     * @return void
     */
    public function line(string $string, string $style = null, int|string $verbosity = null): void
    {
        $styled = $style ? "<$style>$string</$style>" : $string;

        $this->output->writeln($styled, $this->parseVerbosity($verbosity));
    }

    /**
     * Get the verbosity level in terms of Symfony's OutputInterface level.
     *
     * @param int|string|null $level
     *
     * @return int
     */
    protected function parseVerbosity(int|string $level = null): int
    {
        if (isset($this->verbosityMap[$level])) {
            $level = $this->verbosityMap[$level];
        } else {
            if (!is_int($level)) {
                $level = $this->verbosity;
            }
        }

        return $level;
    }

    /**
     * Write a string as comment output.
     *
     * @param string          $string
     * @param int|string|null $verbosity
     *
     * @return void
     */
    public function comment(string $string, int|string $verbosity = null): void
    {
        $this->line($string, 'comment', $verbosity);
    }

    /**
     * Write a string as question output.
     *
     * @param string          $string
     * @param int|string|null $verbosity
     *
     * @return void
     */
    public function question(string $string, int|string $verbosity = null): void
    {
        $this->line($string, 'question', $verbosity);
    }

    /**
     * Write a string as error output.
     *
     * @param string          $string
     * @param int|string|null $verbosity
     *
     * @return void
     */
    public function error(string $string, int|string $verbosity = null): void
    {
        $this->line($string, 'error', $verbosity);
    }

    /**
     * Write a string as warning output.
     *
     * @param string          $string
     * @param int|string|null $verbosity
     *
     * @return void
     */
    public function warn(string $string, int|string $verbosity = null): void
    {
        if (!$this->output->getFormatter()->hasStyle('warning')) {
            $style = new OutputFormatterStyle('yellow');

            $this->output->getFormatter()->setStyle('warning', $style);
        }

        $this->line($string, 'warning', $verbosity);
    }

    /**
     * Write a blank line.
     *
     * @param int $count
     *
     * @return $this
     */
    public function newLine(int $count = 1): static
    {
        $this->output->write(str_repeat("\n", $count));

        return $this;
    }

    /**
     * Set the input interface implementation.
     *
     * @param InputInterface $input
     *
     * @return void
     */
    public function setInput(InputInterface $input): void
    {
        $this->input = $input;
    }

    /**
     * Set the output interface implementation.
     *
     * @param OutputInterface $output
     *
     * @return void
     */
    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;
    }

    /**
     * Specify the arguments and options on the command.
     *
     * @return void
     */
    protected function specifyParameters(): void
    {
        // We will loop through all the arguments and options for the command and
        // set them all on the base command instance. This specifies what can get
        // passed into these commands as "parameters" to control the execution.
        foreach ($this->getArguments() as $arguments) {
            if ($arguments instanceof InputArgument) {
                $this->getDefinition()->addArgument($arguments);
            } else {
                $this->addArgument(...$arguments);
            }
        }

        foreach ($this->getOptions() as $options) {
            if ($options instanceof InputOption) {
                $this->getDefinition()->addOption($options);
            } else {
                $this->addOption(...$options);
            }
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [];
    }

}
