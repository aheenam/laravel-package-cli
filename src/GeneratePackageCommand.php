<?php
namespace Aheenam\LaravelPackageCli;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Aheenam\LaravelPackageCli\Exceptions\InvalidPackageNameException;
use Aheenam\LaravelPackageCli\Exceptions\DirectoryAlreadyExistsException;

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
            ->setName('generate')
            ->setDescription('Generate a structure for your Laravel package')
			->addArgument('name', InputArgument::REQUIRED, 'The name of the package.')
			->addOption('force', 'f', InputOption::VALUE_NONE, 'Overrides existing directories')
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
			$generator = new PackageGenerator($filesystem, '/', $packageName, [
				'force' => $input->getOption('force')
			]);
		} catch (InvalidPackageNameException $e) {
			$io->error("$packageName is not a valid package name");
			return null;
		} catch (DirectoryAlreadyExistsException $e) {
			$io->error(explode('/', $packageName)[1] . " already exists.");
			return null;
		}

		$io->title('Generating Laravel Package');
		$generator->generate();

    }

}