<?php

namespace App;

class Calculator
{
    private CurrencyRateProviderContract $ratesProvider;
    private BinProviderContract $binProvider;
    private ImportDataLoaderContract $dataLoader;

    public function __construct(
        BinProviderContract $binProvider,
        CurrencyRateProviderContract $ratesProvider,
        ImportDataLoaderContract $dataLoader
    ) {
        $this->binProvider = $binProvider;
        $this->ratesProvider = $ratesProvider;
        $this->dataLoader = $dataLoader;
    }

    /**
     * @throws CouldNotGetBinInfoException
     * @return float[]
     */
    public function calculateForFile(string $filename): array
    {
        $result = [];
        $rows = $this->dataLoader->load($filename);

        foreach ($rows as $row) {
            $binInfo = $this->binProvider->getBinInfo($row->bin);
            $ratesInfo = $this->ratesProvider->getRatesInfo($row->currency);

            if ($row->currency === 'EUR' || $ratesInfo->rate === 0.0) {
                $amountFixed = $row->amount;
            } else {
                $amountFixed = $row->amount / $ratesInfo->rate;
            }

            if ($binInfo->isEUCountryCode()) {
                $amountFixed *= 0.01;
            } else {
                $amountFixed *= 0.02;
            }

            $result[] = ceil($amountFixed * 100) / 100;
        }

        return $result;
    }
}
