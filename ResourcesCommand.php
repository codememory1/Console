<?php

namespace Codememory\Components\Console;

use Codememory\Support\Str;

/**
 * Class ResourcesCommand
 * @package Codememory\Components\Console
 *
 * @author  Codememory
 */
class ResourcesCommand
{

    /**
     * @var array
     */
    private array $dataCommand = [];

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Set command name, if no handler for this command
     * exists, an exception will be thrown
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $command
     *
     * @return $this
     */
    public function commandToExecute(string $command): ResourcesCommand
    {

        $this->dataCommand['command'] = $command;

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Add arguments to be passed when running the command
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $argumentName
     * @param mixed  $value
     *
     * @return $this
     */
    public function addArgument(string $argumentName, mixed $value): ResourcesCommand
    {

        $this->dataCommand[$argumentName] = $value;

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Add options to the command, the transmitted option must
     * be without a hyphen, the method will automatically
     * detect and add a hyphen
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $option
     * @param mixed  $value
     *
     * @return $this
     */
    public function addOption(string $option, mixed $value): ResourcesCommand
    {

        $length = Str::length($option);
        $option = $length > 2 ? sprintf('--%s', $option) : sprintf('-%s', $option);

        $this->dataCommand[$option] = $value;

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns a dataset to run a command
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return array
     */
    public function getDataCommand(): array
    {

        return $this->dataCommand;

    }

}