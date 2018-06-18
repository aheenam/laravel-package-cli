<?php

namespace Aheenam\LaravelPackageCli;

use Symfony\Component\Process\Process as SymfonyProcess;

class Process
{
    public function run($command)
    {
        $process = new SymfonyProcess($command);
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });
    }
}
