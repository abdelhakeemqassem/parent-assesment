<?php

namespace App\Http\Filters;

use App\Http\Interfaces\FilterInterface;
use Illuminate\Http\Request;

class BalanceFilter implements FilterInterface {
    public function filter($data, $request) {
        $balanceMin = $request->input('balanceMin');
        $balanceMax = $request->input('balanceMax');

        if ($balanceMin) {
            $data = array_filter($data, function($item) use ($balanceMin) {
                return $item['amount'] >= $balanceMin;
            });
        }

        if ($balanceMax) {
            $data = array_filter($data, function($item) use ($balanceMax) {
                return $item['amount'] <= $balanceMax;
            });
        }

        return $data;
    }
}
