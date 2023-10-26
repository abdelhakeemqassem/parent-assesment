<?php

namespace App\Http\Filters;

use App\Http\Interfaces\FilterInterface;
use Illuminate\Http\Request;

class FilterContext {
    private $filters = [];

    public function addFilter(FilterInterface $filter) {
        $this->filters[] = $filter;
    }

    public function filter($data, Request $request) {
        foreach ($this->filters as $filter) {
            $data = $filter->filter($data, $request);
        }
        return $data;
    }
}
