<?php
namespace Aheenam\LaravelPackageCli\Test;


use Aheenam\LaravelPackageCli\GeneratePackageCommand;
use PHPUnit\Framework\TestCase;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Tester\CommandTester;

class GeneratePackageCommandTest extends TestCase
{
    
    protected function setUp()
    {
        (new Filesystem(new Local(__DIR__ . './../')))
            ->deleteDir('dummy-package');
    }

    /** @test */
    public function it_executes_command ()
    {

        $commandTester = $this->executeCommand([
            'name' => 'dummy/dummy-package'
        ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertContains('Generating Laravel Package', $output);
    }

    /** @test */
    public function command_fails_if_no_name_was_provided ()
    {
        $this->expectException(RuntimeException::class);
        $this->executeCommand([]);
    }

    /** @test */
    public function command_fails_if_directory_already_exists ()
    {

        // fake dir
        (new Filesystem(new Local(__DIR__ . './../')))
            ->createDir('dummy-package');

        $commandTester = $this->executeCommand([
            'name' => 'dummy/dummy-package'
        ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
		$this->assertContains('dummy-package already exists', $output);
		$this->assertNotContains('Generating Laravel Package', $output);
    }

    /** @test */
    public function command_overrides_if_force_is_set_true ()
    {
        
        // fake dir
        (new Filesystem(new Local(__DIR__ . './../')))
            ->createDir('dummy-package');

        $commandTester = $this->executeCommand([
            'name' => 'dummy/dummy-package',
            '--force' => true
        ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertNotContains('dummy-package already exists', $output);
        $this->assertContains('Generating Laravel Package', $output);

    }

	/** @test */
	public function command_fails_if_name_not_valid ()
	{
		$commandTester = $this->executeCommand([
			'name' => 'dummy/dummy-package/test'
		]);

		$output = $commandTester->getDisplay();
		$this->assertContains('dummy/dummy-package/test is not a valid package name', $output);
		$this->assertNotContains('Generating Laravel Package', $output);

	}

    /**
     * helper to execute the command for given options
     *
     * @param $options array
     * @return CommandTester
     */
    protected function executeCommand ($options)
    {
        $application = new Application();
        $application->add(new GeneratePackageCommand());

        $command = $application->find('generate-package');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array_merge([
            'command'  => $command->getName(),
        ], $options));

        return $commandTester;

    }

}