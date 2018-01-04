<?php

namespace Aheenam\LaravelPackageCli\Exceptions;

class DirectoryAlreadyExistsException extends \Exception
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $message = 'An directory with this name already exists.';
        parent::__construct($message);
    }
}
