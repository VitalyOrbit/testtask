<?php

namespace App;

class CurrencyRateInfo
{
    public float $rate;

    public function __construct(float $rate)
    {
        $this->rate = $rate;
    }
}
