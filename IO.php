<?php

namespace Codememory\Components\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class IO
 *
 * @package Codememory\Components\Database\Orm\vendor\codememory\console
 *
 * @author  Codememory
 */
class IO extends SymfonyStyle
{

    /**
     * @var InputInterface
     */
    private InputInterface $input;

    /**
     * @var OutputInterface
     */
    private OutputInterface $output;

    /**
     * @var Command
     */
    private Command $command;

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param Command         $command
     */
    public function __construct(InputInterface $input, OutputInterface $output, Command $command)
    {

        $this->input = $input;
        $this->output = $output;
        $this->command = $command;

        parent::__construct($this->input, $this->output);

    }

    /**
     * @param string        $question
     * @param array         $bundles
     * @param string|null   $default
     * @param callable|null $validator
     *
     * @return mixed
     */
    public function askWithAutocomplete(string $question, array $bundles, ?string $default = null, ?callable $validator = null): mixed
    {

        $question = new Question($question, $default);

        $question->setAutocompleterValues($bundles);
        $question->setValidator($validator);

        return $this->askQuestion($question);

    }

    /**
     * @param string        $question
     * @param callable      $customAutocomplete
     * @param string|null   $default
     * @param callable|null $validator
     *
     * @return mixed
     */
    public function customAskWithAutocomplete(string $question, callable $customAutocomplete, ?string $default = null, ?callable $validator = null): mixed
    {

        $question = new Question($question, $default);

        $question->setAutocompleterCallback($customAutocomplete);
        $question->setValidator($validator);

        return $this->askQuestion($question);

    }

}