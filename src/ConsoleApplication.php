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
        parent::__construct('Laravel Package CLI', '1.0.4');
        $this->add(new GeneratePackageCommand());
    }
}
