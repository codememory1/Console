<?php

namespace Codememory\Components\Console\Interfaces;

/**
 * Interface AnsiConverterInterface
 * @package Codememory\Components\Console\Interfaces
 *
 * @author  Codememory
 */
interface AnsiConverterInterface
{

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * The main method that must be implemented in a class
     * that converts ansi code to html
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $ansiTest
     *
     * @return string
     */
    public function convert(string $ansiTest): string;

}