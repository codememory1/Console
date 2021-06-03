<?php

namespace Codememory\Components\Console\Exceptions;

use ErrorException;
use JetBrains\PhpStorm\Pure;

/**
 * Class NoCommandIndexSpecifiedException
 * @package Codememory\Components\Console\Exceptions
 *
 * @author  Codememory
 */
class NoCommandIndexSpecifiedException extends ErrorException
{

    /**
     * NoCommandIndexSpecifiedException constructor.
     */
    #[Pure] public function __construct()
    {

        parent::__construct('When launching a specific command, you need to specify the command index');

    }

}