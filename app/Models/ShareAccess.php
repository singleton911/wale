<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareAccess extends Model
{
    use HasFactory;

    public function sharePermission(){
        return $this->hasMany(SharePermission::class);
    }
}
