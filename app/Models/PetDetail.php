<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetDetail extends Model
{
    use HasFactory;

    public function lostPet() {
        return $this->belongsTo(LostPet::class);
    }

    public function foundPet() {
        return $this->belongsTo(FoundPet::class);
    }
}
