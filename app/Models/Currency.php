<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency
{
    private string $id;
    private float $rate;
    public function __construct(string $id, float $rate)
    {
        $this->id = $id;
        $this->rate = $rate;
    }
    public function getRate()
    {
        return $this->rate;
    }
    public function getId()
    {
        return $this->id;
    }
}
