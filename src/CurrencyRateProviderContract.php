<?php

namespace App;

interface CurrencyRateProviderContract
{
    public function getRatesInfo(string $currency): CurrencyRateInfo;
}
