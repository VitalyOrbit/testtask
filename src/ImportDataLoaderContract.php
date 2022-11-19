<?php

namespace App;

interface ImportDataLoaderContract
{
    /**
     * @return ImportFileRow[]
     */
    public function load(string $filename): array;
}
