<?php

namespace App;

class CurrencyRateProvider implements CurrencyRateProviderContract
{
    private const REMOTE_URL = 'https://api.exchangeratesapi.io/latest';

    public function getRatesInfo(string $currency): CurrencyRateInfo
    {
        $decodedResponse = @json_decode(
            file_get_contents('https://api.exchangeratesapi.io/latest'),
            true
        );

        return new CurrencyRateInfo((float) $decodedResponse['rates'][$currency]);
    }
}
