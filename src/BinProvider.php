<?php

namespace App;

class BinProvider implements BinProviderContract
{
    private const REMOTE_URL = 'https://lookup.binlist.net';

    public function getBinInfo(int $bin): BinInfo
    {
        $response = file_get_contents(self::REMOTE_URL . '/' . $bin);

        if (!$response) {
            throw new CouldNotGetBinInfoException();
        }

        $decodedData = json_decode($response);

        return new BinInfo($decodedData->country->alpha2);
    }
}
