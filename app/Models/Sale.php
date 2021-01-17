<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sale extends Model
{
    use HasFactory;

    public function cards(){
        return $this->belongsTo(card::class);
    }

    public function user(){
        return $this->belongsTo(user::class);
    }

}