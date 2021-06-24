<?php

namespace App\Exceptions;

use Exception;

class InvalidRefersionApiKeysException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report()
    {
        //Here we would write some code to notify employees via slack since api keys not working for this service breaks the service. If there is a slack setup to notify on critical logs this would work.
        \Log::critical('Stored refersion api keys are no longer active. Please correct environment variables immediately.');
    }
}
