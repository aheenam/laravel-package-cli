<?php

namespace Aheenam\LaravelPackageCli\Test;

use Aheenam\LaravelPackageCli\GeneratePackageCommand;
use Carbon\Carbon;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Tester\CommandTester;

class GeneratePackageCommandTest extends TestCase
{
    protected function tearDown()
    {
        (new Filesystem(new Local(__DIR__.'/../')))
            ->deleteDir('dummy-package');

        (new Filesystem(new Local(__DIR__.'/../')))
            ->deleteDir('packages');
    }

    /** @test */
    public function it_executes_command()
    {
        $commandTester = $this->executeCommand([
            'name' => 'dummy/dummy-package',
        ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertContains('Generating Laravel Package', $output);
    }

    /** @test */
    public function command_fails_if_no_name_was_provided()
    {
        $this->expectException(RuntimeException::class);
        $this->executeCommand([]);
    }

    /** @test */
    public function command_fails_if_directory_already_exists()
    {

        // fake dir
        (new Filesystem(new Local(__DIR__.'/../')))
            ->createDir('dummy-package');

        $commandTester = $this->executeCommand([
            'name' => 'dummy/dummy-package',
        ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertContains('dummy-package already exists', $output);
        $this->assertNotContains('Generating Laravel Package', $output);
    }

    /** @test */
    public function command_overrides_if_force_is_set_true()
    {

        // fake dir
        (new Filesystem(new Local(__DIR__.'/../')))
            ->createDir('dummy-package');

        $commandTester = $this->executeCommand([
            'name'    => 'dummy/dummy-package',
            '--force' => true,
        ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertNotContains('dummy-package already exists', $output);
        $this->assertContains('Generating Laravel Package', $output);
    }

    /** @test */
    public function command_fails_if_name_not_valid()
    {
        $commandTester = $this->executeCommand([
            'name' => 'dummy/dummy-package/test',
        ]);

        $output = $commandTester->getDisplay();
        $this->assertContains('dummy/dummy-package/test is not a valid package name', $output);
        $this->assertNotContains('Generating Laravel Package', $output);
    }

    /** @test */
    public function command_passes_path_to_generator()
    {
        $commandTester = $this->executeCommand([
            'name'    => 'dummy/dummy-package',
            'path'    => './packages/aheenam/',
            '--force' => true,
        ]);

        $output = $commandTester->getDisplay();
        $this->assertContains('Generating Laravel Package', $output);
        $this->assertTrue(
            (new Filesystem(new Local(__DIR__.'/../')))
                ->has('/packages/aheenam/dummy-package/composer.json')
        );
    }

    /** @test */
    public function command_does_not_create_config_dir_if_flag_set()
    {
        $commandTester = $this->executeCommand([
            'name'        => 'dummy/dummy-package',
            '--no-config' => true,
        ]);

        $output = $commandTester->getDisplay();
        $this->assertContains('Generating Laravel Package', $output);
        $this->assertFalse(
            (new Filesystem(new Local(__DIR__.'/../')))
                ->has('/dummy-package/config/dummy-package.php')
        );
    }

    /** @test */
    public function command_passes_license_option()
    {
        Carbon::setTestNow(Carbon::create(2002, 5, 21, 12));

        $commandTester = $this->executeCommand([
            'name'      => 'dummy/dummy-package',
            '--license' => 'MIT',
        ]);

        $output = $commandTester->getDisplay();
        $this->assertContains('Generating Laravel Package', $output);
        $this->assertContains('Added LICENSE MIT', $output);

        $filesystem = new Filesystem(new Local(__DIR__.'/../'));

        $this->assertTrue($filesystem->has('/dummy-package/LICENSE'));
        $this->assertContains('Copyright (c) 2002 Dummy', $filesystem->read('./dummy-package/LICENSE'));
    }

    /**
     * helper to execute the command for given options.
     *
     * @param $options array
     *
     * @return CommandTester
     */
    protected function executeCommand($options)
    {
        $application = new Application();
        $application->add(new GeneratePackageCommand());

        $command = $application->find('generate');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array_merge([
            'command'  => $command->getName(),
        ], $options));

        return $commandTester;
    }
}
