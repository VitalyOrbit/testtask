<?php

namespace Tests;

use App\BinInfo;
use App\Calculator;
use App\BinProviderContract;
use App\CurrencyRateInfo;
use App\CurrencyRateProviderContract;
use App\ImportDataLoaderContract;
use App\ImportFileRow;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    /**
     * @dataProvider calculateProvider
     */
    public function testCalculate(
        BinProviderContract $binProvider,
        CurrencyRateProviderContract $rateProvider,
        ImportDataLoaderContract $dataLoader,
        float $expect
    ): void {
        $calculator = new Calculator($binProvider, $rateProvider, $dataLoader);

        $result = $calculator->calculateForFile('somefilename.txt');

        $this->assertEquals($expect, $result[0]);
    }

    public function calculateProvider(): iterable
    {
        yield [
            'binProvider' => $this->createBinProviderMock(true),
            'rateProvider' => $this->createRateProviderMock(0.10),
            'dataLoader' => $this->createDataLoaderMock(45717360, 100.0, 'EUR'),
            'expect' => 1.0,
        ];

        yield [
            'binProvider' => $this->createBinProviderMock(true),
            'rateProvider' => $this->createRateProviderMock(0.0),
            'dataLoader' => $this->createDataLoaderMock(516793, 50.0, 'EUR'),
            'expect' => 0.5,
        ];

        yield [
            'binProvider' => $this->createBinProviderMock(true),
            'rateProvider' => $this->createRateProviderMock(0.26),
            'dataLoader' => $this->createDataLoaderMock(516793, 346.0, 'USD'),
            'expect' => 13.31,
        ];

        yield [
            'binProvider' => $this->createBinProviderMock(true),
            'rateProvider' => $this->createRateProviderMock(0.0),
            'dataLoader' => $this->createDataLoaderMock(516793, 500.0, 'USD'),
            'expect' => 5.0,
        ];

        yield [
            'binProvider' => $this->createBinProviderMock(false),
            'rateProvider' => $this->createRateProviderMock(0.10),
            'dataLoader' => $this->createDataLoaderMock(45717360, 150.0, 'EUR'),
            'expect' => 3.0,
        ];

        yield [
            'binProvider' => $this->createBinProviderMock(false),
            'rateProvider' => $this->createRateProviderMock(0.0),
            'dataLoader' => $this->createDataLoaderMock(516793, 250.0, 'EUR'),
            'expect' => 5.0,
        ];

        yield [
            'binProvider' => $this->createBinProviderMock(false),
            'rateProvider' => $this->createRateProviderMock(0.41),
            'dataLoader' => $this->createDataLoaderMock(516793, 837.0, 'USD'),
            'expect' => 40.83,
        ];

        yield [
            'binProvider' => $this->createBinProviderMock(false),
            'rateProvider' => $this->createRateProviderMock(0.0),
            'dataLoader' => $this->createDataLoaderMock(516793, 400.0, 'USD'),
            'expect' => 8.0,
        ];
    }

    private function createBinProviderMock(bool $isEU): BinProviderContract
    {
        $binProviderMock = $this->createMock(BinProviderContract::class);
        $binInfoMock = $this->createMock(BinInfo::class);
        $binInfoMock->method('isEUCountryCode')->willReturn($isEU);
        $binProviderMock->method('getBinInfo')->willReturn($binInfoMock);

        return $binProviderMock;
    }

    private function createRateProviderMock(float $rate): CurrencyRateProviderContract
    {
        $rateProviderMock = $this->createMock(CurrencyRateProviderContract::class);
        $rateProviderMock->method('getRatesInfo')->willReturn(new CurrencyRateInfo($rate));

        return $rateProviderMock;
    }

    private function createDataLoaderMock(int $bin, float $amount, string $currency): ImportDataLoaderContract
    {
        $dataLoaderMock = $this->createMock(ImportDataLoaderContract::class);
        $dataLoaderMock->method('load')->willReturn(
            [new ImportFileRow($bin, $amount, $currency)]
        );

        return $dataLoaderMock;
    }
}
