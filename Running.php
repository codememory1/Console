<?php

namespace Codememory\Components\Console;

use Codememory\Components\Console\Exceptions\NoCommandIndexSpecifiedException;
use Codememory\Components\Console\Exceptions\NotCommandException;
use Codememory\Components\Console\Interfaces\AnsiConverterInterface;
use Codememory\Components\Console\Traits\ExecutionTrait;
use Exception;
use JetBrains\PhpStorm\Pure;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Running
 * @package Codememory\Components\Console
 *
 * @author  Codememory
 */
class Running
{

    use ExecutionTrait;

    public const ASYNC_EXECUTION = 'async';
    public const SPECIFIC_EXECUTION = 'specific';
    public const FIRST_EXECUTION = 'first';
    public const LAST_EXECUTION = 'last';

    /**
     * @var Application
     */
    private Application $app;

    /**
     * @var array
     */
    private array $commands = [];

    /**
     * @var array|string[]
     */
    private array $execution = [
        'type'  => self::ASYNC_EXECUTION,
        'index' => null
    ];

    /**
     * @var array
     */
    private array $response = [];

    /**
     * Running constructor.
     *
     * @param bool $exitAfterExecution
     */
    public function __construct(bool $exitAfterExecution = false)
    {

        $this->app = new Application();

        $this->app->setAutoExit($exitAfterExecution);

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Add a command to the launch list, using an argument
     * you can specify arguments and options
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param callable $handlerAddData
     *
     * @return $this
     */
    public function addCommand(callable $handlerAddData): Running
    {

        $command = new ResourcesCommand();

        call_user_func_array($handlerAddData, [&$command]);

        $this->commands[] = $command;

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Investigates the symfony application object
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return Application
     */
    public function getApp(): Application
    {

        return $this->app;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Add an array of command handlers that must inherit
     * from the parent Command class
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param array $commands
     *
     * @return $this
     * @throws NotCommandException
     * @throws ReflectionException
     */
    public function addCommands(array $commands): Running
    {

        foreach ($commands as $index => $command) {
            $reflection = new ReflectionClass($command);
            $parent = $reflection->getParentClass()->getName();

            if ($parent !== Command::class) {
                throw new NotCommandException($index);
            }

            $this->app->add($command);
        }

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * The method is needed to determine how to run a command or what
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string   $typeExecution
     * @param int|null $index
     *
     * @return $this
     * @throws NoCommandIndexSpecifiedException
     */
    public function executeAs(string $typeExecution, ?int $index = null): Running
    {

        $this->execution['type'] = $typeExecution;

        if (self::SPECIFIC_EXECUTION === $typeExecution && null === $index) {
            throw new NoCommandIndexSpecifiedException();
        }

        $this->execution['index'] = $index;

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Launching commands. If you need to get the result with ansi,
     * then the $outputAnsi argument must be true
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param bool $outputAnsi
     *
     * @return Running|ExecutionTrait
     * @throws Exception
     */
    public function run(bool $outputAnsi = false): Running|ExecutionTrait
    {

        $output = new BufferedOutput();

        if ($outputAnsi) {
            $output = new BufferedOutput(OutputInterface::VERBOSITY_NORMAL, true);
        }

        return $this
            ->asyncExecution($output)
            ->firstExecution($output)
            ->lastExecution($output)
            ->specificExecution($output);

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns the result of an executed command
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return string|null
     */
    #[Pure] public function getResponse(): ?string
    {

        return implode('', $this->response);

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Get ansi result in html
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param AnsiConverterInterface $converter
     *
     * @return string|null
     */
    public function getResponseToHtml(AnsiConverterInterface $converter): ?string
    {

        $response = null;

        foreach ($this->response as $value) {
            $response .= sprintf('%s<br>', $converter->convert($value));
        }

        return $response;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns an array of inputs
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return array
     */
    private function getInputs(): array
    {

        $inputs = [];

        foreach ($this->commands as $command) {
            $inputs[] = new ArrayInput($command->getDataCommand());
        }

        return $inputs;

    }


}