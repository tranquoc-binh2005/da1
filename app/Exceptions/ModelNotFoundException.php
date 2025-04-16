<?php
namespace App\Exceptions;;

use Exception;
class ModelNotFoundException extends Exception
{
    public function __construct($message = '', $code = 404)
    {
        parent::__construct($message, $code);
    }
}