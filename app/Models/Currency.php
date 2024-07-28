<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency
{
    public string $id;
    public float $rate;
    public function __construct(string $id, float $rate)
    {
        $this->id = $id;
        $this->rate = $rate;
    }
}
