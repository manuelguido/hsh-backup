<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subasta extends Model
{

    public $table = 'subastas';

    public $fillable = [
        'begin_date', 'end_date', 'property_id', 'open_date', 'close_date', 'initial_value', 'is_closed',
    ];
    
    public function getModel()
    {
       return $this;
    }
}
