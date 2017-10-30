<?php
namespace Aheenam\LaravelPackageCli;

class InvalidPackageNameException extends \Exception
{
    
    /**
     * Constructor
     */
    public function __construct ()
    {
        $message = "The given package name is not valid.";
        parent::__construct($message);
    }    
}