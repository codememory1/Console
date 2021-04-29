<?php

namespace Codememory\Components\Console\Exceptions;

use ErrorException;
use JetBrains\PhpStorm\Pure;

/**
 * Class NotCommandException
 * @package Codememory\Components\Console\Exceptions
 *
 * @author  Codememory
 */
class NotCommandException extends ErrorException
{

    /**
     * NotCommandException constructor.
     *
     * @param int $index
     */
    #[Pure] public function __construct(int $index)
    {

        parent::__construct(sprintf(
            'The item in the array at index %d is not a command',
            $index
        ));

    }

}