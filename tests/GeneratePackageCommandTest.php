<?php
namespace Aheenam\LaravelPackageCli\Test;


use Aheenam\LaravelPackageCli\GeneratePackageCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Tester\CommandTester;

class GeneratePackageCommandTest extends TestCase
{

    /** @test */
    public function it_executes_command ()
    {

        $commandTester = $this->executeCommand([
            'name' => 'dummy-package'
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