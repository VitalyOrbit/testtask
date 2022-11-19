<?php

namespace App;

class ImportFileRow
{
    public int $bin;
    public float $amount;
    public string $currency;

    public function __construct(int $bin, float $amount, string $currency)
    {
        $this->bin = $bin;
        $this->amount = $amount;
        $this->currency = $currency;
    }
}
