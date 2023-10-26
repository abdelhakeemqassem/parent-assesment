<?php

namespace App\Http\Filters;

use App\Http\Interfaces\FilterInterface;
use Illuminate\Http\Request;

class StatusFilter implements FilterInterface {
    
    public function filter($data, $request) {
        $statusCode = $request->input('statusCode');

        if ($statusCode) {
            $data = array_filter($data, function($item) use ($statusCode) {
                return $item['statusCode'] == $statusCode; 
            });
        }

        return $data;
    }
}
