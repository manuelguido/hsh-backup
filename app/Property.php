<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Property;

class Property extends Model
{
    public $fillable = [
        'title', 'description', 'address', 'city', 'province', 'country', 'imagen', 'price', 
    ];

    public function getImageAttribute()
    {
       return $this->img1;
    }

}
