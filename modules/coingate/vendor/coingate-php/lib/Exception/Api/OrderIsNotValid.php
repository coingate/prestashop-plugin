<?php

namespace CoinGate\Exception\Api;

use CoinGate\Exception\ApiErrorException;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * OrderIsNotValid is thrown when order is not valid and HTTP Status: 422 (Unprocessable Entity).
 */
class OrderIsNotValid extends ApiErrorException
{
}
