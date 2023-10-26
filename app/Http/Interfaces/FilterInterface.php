<?php

namespace App\Http\Interfaces;

interface FilterInterface {
    public function filter($data, $request);
}
