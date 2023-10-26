<?php

namespace App\Http\Controllers;

use App\Http\Filters\BalanceFilter;
use App\Http\Filters\CurrencyFilter;
use App\Http\Filters\FilterContext;
use App\Http\Filters\ProviderFilter;
use App\Http\Filters\StatusFilter;
use Illuminate\Http\Request;
use App\Http\Interfaces\DataSourceInterface;
use App\Http\Interfaces\FilterInterface;
use Exception;

class UserController extends Controller
{
    protected $dataSources;
    protected $filterContext;

    public function __construct(FilterContext $filterContext)
    {
        $this->filterContext = $filterContext;
    }

    public function getUsers(Request $request)
    {
        try {
            $this->initializeDataSources();
            $data = $this->fetchDataFromDataSources();
            $this->addFiltersToContext($request);
            $filteredData = $this->filterContext->filter($data, $request);
            return response()->json([
                'status' => true,
                'message' => 'Data retrived sucessfully',
                'data' => $filteredData ?? []
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Can\'t retrieve data : ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    private function initializeDataSources()
    {
        $this->dataSources = [
            app('DataSourceX'),
            app('DataSourceY'),
            //simply add DataSourceZ here after adding the json for it .
        ];
    }

    private function fetchDataFromDataSources()
    {
        $data = [];

        foreach ($this->dataSources as $dataSource) {
            $data = array_merge($data, $dataSource->getData());
        }

        return $data;
    }

    private function addFiltersToContext(Request $request)
    {
        $this->filterContext->addFilter(new ProviderFilter($request->input('provider')));
        $this->filterContext->addFilter(new StatusFilter($request->input('statusCode')));
        $this->filterContext->addFilter(new BalanceFilter(
            $request->input('balanceMin'),
            $request->input('balanceMax')
        ));
        $this->filterContext->addFilter(new CurrencyFilter($request->input('currency')));
    }
}
