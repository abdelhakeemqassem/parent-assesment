<?php

namespace App\Http\Adapters;

use App\Http\Interfaces\DataSourceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DataProviderXAdapter implements DataSourceInterface
{
    protected $statusCode = [];

    public function __construct(){
        $this->statusCode = [
            '1'  => 'authorised',
            '2'  => 'decline',
            '3'  => 'refunded'
        ];
    }

    public function getData() {
        $dataProviderX = File::get(storage_path('DataProviderX.json'));
        $dataX = json_decode($dataProviderX);

        // Adapt the data and filter it within the adapter
        $filteredData = array_map(function($item) {
            return [
                'parentEmail' => $item->parentEmail,
                'amount'      => $item->parentAmount,
                'currency'    => $item->Currency,
                'statusCode'  => $this->statusCode[$item->statusCode],
                'created_at'  => $item->registerationDate,
                'id'          => $item->parentIdentification,
                'provider'    => 'DataProviderX',
            ];
        }, $dataX);

        return $filteredData;
    }
}
