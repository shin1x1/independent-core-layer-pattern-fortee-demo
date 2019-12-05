<?php

namespace Fortee\Proposal\Core\Exception;

use RuntimeException;

final class NotFoundException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message, 404);
    }
}
