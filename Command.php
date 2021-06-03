<?php

namespace Codememory\Components\Console;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class Command
 * @package System\Console
 *
 * @author  Codememory
 */
abstract class Command extends SymfonyCommand
{

    /**
     * @var string|null
     */
    protected ?string $command = null;

    /**
     * @var string|null
     */
    protected ?string $description = null;

    /**
     * @var string|null
     */
    protected ?string $help = null;

    /**
     * @var SymfonyStyle|null
     */
    protected ?SymfonyStyle $io = null;

    /**
     * @var array
     */
    private array $options = [];

    /**
     * @var array
     */
    private array $arguments = [];

    /**
     * @var Tags|null
     */
    protected ?Tags $tags = null;

    /**
     * @var InputInterface|null
     */
    private ?InputInterface $input = null;

    /**
     * @var OutputInterface|null
     */
    private ?OutputInterface $output = null;

    /**
     * Command constructor.
     *
     * @param string|null $name
     */
    public function __construct(string $name = null)
    {

        parent::__construct($name);

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * & Adding a description to a command
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return $this
     */
    private function addDescription(): Command
    {

        if (null !== $this->description) {
            $this->setDescription($this->description);
        }

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * & Adding a helper to a team
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return Command
     */
    private function addHelp(): Command
    {

        if (null !== $this->help) {
            $this->setHelp($this->help);
        }

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * & A handler method that adds options from an array
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return Command
     */
    private function addOptions(): Command
    {

        if ([] !== $this->options) {
            foreach ($this->options as $option) {
                $this->addOption(
                    $option['name'],
                    $option['shortcut'],
                    $option['mode'],
                    $option['desc'],
                    $option['default']
                );
            }
        }

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * & A handler method that adds arguments from an array
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return Command
     */
    private function addArgs(): Command
    {

        if ([] !== $this->arguments) {
            foreach ($this->arguments as $argument) {
                $this->addArgument(
                    $argument['name'],
                    $argument['mode'],
                    $argument['desc'],
                    $argument['default']
                );
            }
        }

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * & Method that initializes command configuration
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return Command
     */
    private function init(): Command
    {

        $this->setName($this->command);

        $this
            ->addDescription()
            ->addHelp()
            ->addOptions()
            ->addArgs();

        return $this;

    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {

        $this->tags = new Tags();

        $this
            ->wrapArgsAndOptions()
            ->init()
            ->overrideConfig();

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * & The main method in which all the processing of the
     * & command execution takes place
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    abstract protected function handler(InputInterface $input, OutputInterface $output): int;

    /**
     * {@inheritdoc}
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $this->io = new SymfonyStyle($input, $output);
        $this->input = $input;
        $this->output = $output;

        return $this->handler($input, $output);

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>
     * & Adding an option
     * <=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string   $name
     * @param null     $shortcut
     * @param int|null $mode
     * @param string   $description
     * @param null     $default
     *
     * @return $this
     */
    protected function option(string $name, $shortcut = null, int $mode = null, string $description = '', $default = null): Command
    {

        $this->options[] = [
            'name'     => $name,
            'shortcut' => $shortcut,
            'mode'     => $mode,
            'desc'     => $description,
            'default'  => $default
        ];

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>
     * & Adding an argument
     * <=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string   $name
     * @param int|null $mode
     * @param string   $description
     * @param null     $default
     *
     * @return $this
     */
    protected function argument(string $name, int $mode = null, string $description = '', $default = null): Command
    {

        $this->arguments[] = [
            'name'    => $name,
            'mode'    => $mode,
            'desc'    => $description,
            'default' => $default
        ];

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * & Method in which arguments and options are created
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return $this
     */
    protected function wrapArgsAndOptions(): Command
    {

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * & The method will override the command configuration,
     * & for example, if you need to make a colored description
     * & of the command, then you need to use the addition of an
     * & option in this method
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     */
    protected function overrideConfig(): void
    {

    }

}