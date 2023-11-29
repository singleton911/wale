<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharePermission extends Model
{
    use HasFactory;

    public function shareAccess(){
        return $this->belongsTo(ShareAccess::class);
    }
}
