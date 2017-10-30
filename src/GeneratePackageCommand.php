<?php
namespace Aheenam\LaravelPackageCli;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Aheenam\LaravelPackageCli\Exceptions\InvalidPackageNameException;

class GeneratePackageCommand extends Command
{

    /**
     * Configure the command
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('generate-package')
            ->setDescription('Generate a structure for your Laravel package')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the package.')
            ;
    }

	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 *
	 * @return int|null|void
	 */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
	    $io = new SymfonyStyle($input, $output);
		
		$packageName = $input->getArgument('name');

		try {
			$filesystem = new Filesystem(new Local(getcwd()));
			$generator = new PackageGenerator($filesystem, '/', $packageName);
		} catch (InvalidPackageNameException $e) {
			$io->error("$packageName is not a valid package name");
			return null;
		}

		$io->title('Generating Laravel Package');
		$generator->generate();

    }

}