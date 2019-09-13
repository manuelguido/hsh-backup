<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bid;

class Bid extends Model
{
    public $fillable = [
        'email', 'value', 'id', 'actual_value',
    ];

}
