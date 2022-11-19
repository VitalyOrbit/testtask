<?php

namespace App;

interface BinProviderContract
{
    /**
     * @throws CouldNotGetBinInfoException
     */
    public function getBinInfo(int $bin): BinInfo;
}
