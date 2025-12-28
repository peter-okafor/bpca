<?php

namespace App\Exceptions;

use Exception;
use Inertia\Inertia;

class BlogException extends Exception
{
    protected $status;

    public function __construct(int $status, string $message)
    {
        parent::__construct($message, $status);
    }

    public function render()
    {
        return Inertia::render('Blog/ErrorPage', [
            'status' => $this->getCode(),
            'error' => $this->getMessage()
        ]);
    }
}
