<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Violencemeter extends Model
{
    protected $fillable = [
        'name',
        'risk_level',
        'attention_route'
    ];
}
