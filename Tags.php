<?php

namespace Codememory\Components\Console;

use JetBrains\PhpStorm\Pure;

/**
 * Class Tags
 * @package Codememory\Components\Console
 *
 * @author  Codememory
 */
class Tags
{

    /**
     * @param string $text
     * @param string $color
     *
     * @return string
     */
    #[Pure] public function colorText(string $text, string $color): string
    {

        return sprintf('<fg=%s>%s</>', $color, $text);

    }

    /**
     * @param string $text
     *
     * @return string
     */
    #[Pure] public function redText(string $text): string
    {

        return $this->colorText($text, 'red');

    }

    /**
     * @param string $text
     *
     * @return string
     */
    #[Pure] public function blackText(string $text): string
    {

        return $this->colorText($text, 'black');

    }

    /**
     * @param string $text
     *
     * @return string
     */
    #[Pure] public function greenText(string $text): string
    {

        return $this->colorText($text, 'green');

    }

    /**
     * @param string $text
     *
     * @return string
     */
    #[Pure] public function yellowText(string $text): string
    {

        return $this->colorText($text, 'yellow');

    }

    /**
     * @param string $text
     *
     * @return string
     */
    #[Pure] public function blueText(string $text): string
    {

        return $this->colorText($text, 'blue');

    }

    /**
     * @param string $text
     *
     * @return string
     */
    #[Pure] public function whiteText(string $text): string
    {

        return $this->colorText($text, 'white');

    }

    /**
     * @param string $text
     * @param string $bg
     * @param string $color
     *
     * @return string
     */
    #[Pure] public function background(string $text, string $bg, string $color = 'white'): string
    {

        return sprintf('<fg=%s;bg=%s>%s</>', $color, $bg, $text);

    }

}