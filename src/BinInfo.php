<?php

namespace App;

class BinInfo
{
    private const EU_COUNTRY_CODES = [
        'AT',
        'BE',
        'BG',
        'CY',
        'CZ',
        'DE',
        'DK',
        'EE',
        'ES',
        'FI',
        'FR',
        'GR',
        'HR',
        'HU',
        'IE',
        'IT',
        'LT',
        'LU',
        'LV',
        'MT',
        'NL',
        'PO',
        'PT',
        'RO',
        'SE',
        'SI',
        'SK',
    ];

    public string $issuerCountryCode;

    public function __construct(string $issuerCountryCode)
    {
        $this->issuerCountryCode = $issuerCountryCode;
    }

    public function isEUCountryCode(): bool
    {
        return in_array(strtoupper($this->issuerCountryCode), self::EU_COUNTRY_CODES);
    }
}
