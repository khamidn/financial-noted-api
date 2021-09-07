<?php

namespace App\Exceptions;

use Exception;

class ModelNotExistException extends Exception
{
    protected $message;
    
    public function __construct(string $message)
    {
        $this->message = $message;
    }
    
    public function render()
    {
        return response()->json([
            'success' => false,
            'message' => $this->message
        ], 404);
    }
}
