<?php

namespace CoinGate\Exception\Api;

use CoinGate\Exception\ApiErrorException;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * BadRequest is thrown when HTTP Status: 400 (Bad Request).
 */
class BadRequest extends ApiErrorException
{
}
