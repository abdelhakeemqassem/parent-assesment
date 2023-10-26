<?php

namespace App\Providers;

use App\Http\Interfaces\DataSourceInterface;
use App\Http\Adapters\DataProviderXAdapter;
use App\Http\Adapters\DataProviderYAdapter;
use Illuminate\Support\ServiceProvider;

class DataServiceProvider extends ServiceProvider
{
    public function register()
    {
        $dataSourceNames = ['X', 'Y'];
        foreach ($dataSourceNames as $name) {
            // Bind DataProviderAdapter to the DataSource interface with a unique name
            $this->app->bind('DataSource' . $name, function () use ($name) {
                $adapterClassName = 'App\\Http\\Adapters\\DataProvider' . $name . 'Adapter';
                return new $adapterClassName();
            });
        }
    }
}
