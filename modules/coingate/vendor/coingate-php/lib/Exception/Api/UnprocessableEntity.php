<?php

namespace CoinGate\Exception\Api;

use CoinGate\Exception\ApiErrorException;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * UnprocessableEntity is thrown when HTTP Status: 422 (Unprocessable Entity).
 */
class UnprocessableEntity extends ApiErrorException
{
}
