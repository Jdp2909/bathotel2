<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adoption extends Model
{
     protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'pet_id',
        'reason',
        'status',
    ];
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}

