<?php

namespace App\Http\Adapters;

use App\Http\Interfaces\DataSourceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DataProviderYAdapter implements DataSourceInterface
{
    protected $statusCode = [];

    public function __construct(){
        $this->statusCode = [
            '100'  => 'authorised',
            '200'  => 'decline',
            '300'  => 'refunded'
        ];
    }

    public function getData() {
        $dataProviderY = File::get(storage_path('DataProviderY.json'));
        $dataY = json_decode($dataProviderY);

        // Adapt the data and filter it within the adapter
        $filteredData = array_map(function($item) {
            return [
                'parentEmail' => $item->email,
                'amount'      => $item->balance,
                'currency'    => $item->currency,
                'statusCode'  => $this->statusCode[$item->status],
                'created_at'  => $item->created_at,
                'id'          => $item->id,
                'provider'    => 'DataProviderY',
            ];
        }, $dataY);

        return $filteredData;
    }
}
