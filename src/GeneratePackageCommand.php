<?php

namespace Aheenam\LaravelPackageCli;

use Aheenam\LaravelPackageCli\Exceptions\DirectoryAlreadyExistsException;
use Aheenam\LaravelPackageCli\Exceptions\InvalidPackageNameException;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GeneratePackageCommand extends Command
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('generate')
            ->setDescription('Generate a structure for your Laravel package')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the package.')
            ->addArgument('path', InputArgument::OPTIONAL, 'Path where the package should be created.')
            ->addOption('license', null, InputOption::VALUE_OPTIONAL, 'License that should be generated')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Overrides existing directories')
            ->addOption('no-config', null, InputOption::VALUE_NONE, 'Prevents from creating a config directory.')
            ->addOption('install', null, InputOption::VALUE_NONE, 'Run composer install after generating the package.');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $packageName = $input->getArgument('name');
        $path = $input->hasArgument('path') ? $input->getArgument('path') : '/';

        $projectName = explode('/', $packageName)[1];

        try {
            $filesystem = new Filesystem(new Local(getcwd()));
            $generator = new PackageGenerator($filesystem, $path, $packageName, [
                'force'     => $input->getOption('force'),
                'no-config' => $input->getOption('no-config'),
                'license'   => $input->getOption('license'),
            ]);
        } catch (InvalidPackageNameException $e) {
            $io->error("$packageName is not a valid package name");

            return;
        } catch (DirectoryAlreadyExistsException $e) {
            $io->error($projectName.' already exists.');

            return;
        }

        $io->title('Generating Laravel Package');
        if ($input->getOption('license') !== null) {
            $license = $input->getOption('license');
            $io->writeln("Added LICENSE $license");
        }
        $generator->generate();

        if ($input->getOption('install')) {
            (new Process)->run("cd $path/$projectName; composer install");
        }
    }
}
