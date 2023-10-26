<?php

namespace App\Http\Filters;

use App\Http\Interfaces\FilterInterface;
use Illuminate\Http\Request;

class CurrencyFilter implements FilterInterface {
    public function filter($data, $request) {
        $currency = $request->input('currency');

        if ($currency) {
            $data = array_filter($data, function($item) use ($currency) {
                return $item['currency'] == $currency; 
            });
        }

        return $data;
    }
}
