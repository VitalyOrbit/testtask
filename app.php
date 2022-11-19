<?php

$calculator = new App\Calculator(new App\BinProvider(), new App\CurrencyRateProvider(), new App\ImportDataLoader());

try {
    $results = $calculator->calculateForFile($argv[1]);
} catch (App\CouldNotGetBinInfoException $e) {
    die('Could not get card country code');
}

foreach ($results as $result) {
    echo $result . "\n";
}
