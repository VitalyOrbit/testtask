<?php

namespace App;

class ImportDataLoader implements ImportDataLoaderContract
{
    public function load(string $filename): array
    {
        $rawData = file_get_contents($filename);
        $result = [];

        foreach (explode("\n", $rawData) as $row) {
            if (empty($row)) {
                break;
            }

            $decodedRowData = array_values(json_decode($row, true));

            $result[] = new ImportFileRow(
                (int) $decodedRowData[0],
                (float) $decodedRowData[1],
                $decodedRowData[2]
            );
        }

        return $result;
    }
}
