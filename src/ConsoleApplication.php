<?php
namespace Aheenam\LaravelPackageCli;

use Symfony\Component\Console\Application;

class ConsoleApplication extends Application
{
    /**
     * ConsoleApplication constructor.
     */
    public function __construct()
    {
        parent::__construct('Laravel Package CLI', '0.1.0');
        $this->add(new GeneratePackageCommand());
    }
}