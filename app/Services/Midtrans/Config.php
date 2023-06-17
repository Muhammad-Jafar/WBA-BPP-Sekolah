<?php

namespace App\Services\Midtrans;

/**
 * Midtrans Configuration
 */
class Config
{
    /**
     * Your merchant's server key
     *
     * @static
     */
    public static $serverKey;

    /**
     * True for production
     * false for sandbox mode
     *
     * @static
     */
    public static $isProduction = false;

    const SANDBOX_BASE_URL = 'https://api.sandbox.midtrans.com/v2/';
    const PRODUCTION_BASE_URL = 'https://api.midtrans.com/v2/';

    /**
     * Get baseUrl
     *
     * @return string Midtrans API URL, depends on $isProduction
     */
    public static function getBaseUrl()
    {
        return Config::$isProduction ?
        Config::PRODUCTION_BASE_URL : Config::SANDBOX_BASE_URL;
    }
}
