<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteListing extends Model
{
    use HasFactory;

    protected $guraded = ['id'];
    
    public function product(){
        return $this->belongsTo(Product::class);
    }
}