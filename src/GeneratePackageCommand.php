<?php
namespace Aheenam\LaravelPackageCli;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

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
	    $packageParts = explode('/', $packageName);

	    if ( count($packageParts) !== 2 ) {
	    	$io->error("$packageName is not a valid name!");
	    	return null;
	    }

        $io->title('Generating Laravel Package');

	    $filesystem = new Filesystem(new Local(getcwd()));
	    $packageInfo = [
		    'name' => $packageParts[1],
		    'vendor' => $packageParts[0]
	    ];

	    (new PackageGenerator($filesystem, '/', $packageInfo))
		    ->generate();

    }

}