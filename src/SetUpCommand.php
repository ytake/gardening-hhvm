<?php

namespace Ytake\GardeningHhvm;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Ytake\GardeningHhvm\Foundation\Command;
use Ytake\GardeningHhvm\Foundation\Filer;

/**
 * Class SetUpCommand
 */
class SetUpCommand extends Command
{
    /** @var string  command name */
    protected $command = 'gardening-hhvm:setup';

    /** @var string  command description */
    protected $description = 'Vagrantfile setup';

    /** @var Filer */
    protected $file;

    /** @var string */
    private $name = 'gardening-hhvm';

    /** @var string */
    protected $current;

    /** @var string */
    protected $projectName;

    /** @var string */
    protected $defaultProjectName;

    /**
     * SetUpCommand constructor.
     *
     * @param Filer $file
     * @param null  $name
     */
    public function __construct(Filer $file, $name = null)
    {
        parent::__construct($name = null);
        $this->file = $file;
        $this->current = getcwd();
        $this->projectName = basename($this->current);
        $this->defaultName = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $this->defaultProjectName)));
    }

    /**
     * setup arguments and options
     *
     * @return void
     */
    protected function arguments()
    {
        $this
            ->addOption('filetype', null, InputOption::VALUE_REQUIRED, 'choose configure file type[json or yaml]',
                'yaml')
            ->addOption('name', null, InputOption::VALUE_OPTIONAL, 'The name of the virtual machine.')
            ->addOption('hostname', null, InputOption::VALUE_OPTIONAL, 'The hostname of the virtual machine.',
                $this->name)
            ->addOption('ip', null, InputOption::VALUE_REQUIRED, 'The IP address of the virtual machine.',
                '192.168.10.10')
            ->addOption('aliases', null, InputOption::VALUE_NONE, 'if the aliases file is created.');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function action(InputInterface $input, OutputInterface $output)
    {
        if (!$this->file->exists($this->current . '/Vagrantfile')) {
            $this->file->copy(__DIR__ . '/stub/Vagrantfile.dist', $this->current . '/Vagrantfile');
        }

        if (!$this->file->exists($this->current . '/append.sh')) {
            $this->file->copy(__DIR__ . '/stub/append.sh', $this->current . '/append.sh');
        }

        if ($input->getOption('aliases')) {
            if (!$this->file->exists($this->current . '/aliases')) {
                $this->file->copy(__DIR__ . '/stub/aliases', $this->current . '/aliases');
            }
        }
        /** @var string[] $configure */
        $configure = require __DIR__ . '/data/configure.php';
        $configure['name'] = ($input->getOption('name')) ? $input->getOption('name') : $this->defaultProjectName;
        $configure['hostname'] = $input->getOption('hostname');
        $configure['ip'] = $input->getOption('ip');
        $configure['folders'][0]['map'] = $this->current;
        $configure['folders'][0]['to'] = str_replace('Code', $this->defaultProjectName, $configure['folders'][0]['to']);

        $configure['sites'][0]['to'] = str_replace('Code', $this->defaultProjectName, $configure['sites'][0]['to']);
        $fileExtension = mb_strtolower($input->getOption('filetype'));
        $publishMethod = 'to' . ucfirst($fileExtension);

        if (!$this->file->exists($this->current . "/vagrant.{$fileExtension}")) {
            file_put_contents($this->current . "/vagrant.{$fileExtension}", $this->file->$publishMethod($configure));
            return $output->writeln("<fg=cyan>success Gardening setup. see {$this->current}/vagrant.{$fileExtension}</>");
        }
        return $output->writeln("<fg=red>{$this->current}/vagrant.{$fileExtension} file exists.</>");
    }
}
