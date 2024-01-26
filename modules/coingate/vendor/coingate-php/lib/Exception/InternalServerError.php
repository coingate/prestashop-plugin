<?php

namespace CoinGate\Exception;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * InternalServerError is thrown when something wrong in CoinGate and HTTP Status: 500 (Internal Server Error).
 */
class InternalServerError extends ApiErrorException
{
}
