<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LostPet extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function petDetail() {
        return $this->hasOne(PetDetail::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
