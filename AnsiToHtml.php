<?php

namespace Codememory\Components\Console;

use Codememory\Components\Console\Interfaces\AnsiConverterInterface;
use SensioLabs\AnsiConverter\AnsiToHtmlConverter;

/**
 * Class AnsiToHtml
 * @package Codememory\Components\Console
 *
 * @author  Codememory
 */
class AnsiToHtml implements AnsiConverterInterface
{

    /**
     * @var AnsiToHtmlConverter
     */
    private AnsiToHtmlConverter $converter;

    /**
     * AnsiToHtml constructor.
     */
    public function __construct()
    {

        $this->converter = new AnsiToHtmlConverter();

    }

    /**
     * @inheritDoc
     */
    public function convert(string $ansiTest): string
    {

        return $this->converter->convert($ansiTest);

    }

}