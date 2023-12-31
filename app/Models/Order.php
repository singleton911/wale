<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at','updated_at'];
    
    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function extraOption(){
        return $this->belongsTo(ExtraOption::class, 'extra_id');
    }

    public function dispute(){
        return $this->hasOne(Dispute::class);
    }

    public function store(){
        return $this->belongsTo(Store::class);
    }

    public function escrow(){
        return $this->hasOne(Escrow::class);
    }

    public function review(){
        return $this->hasOne(Review::class);
    }
}
