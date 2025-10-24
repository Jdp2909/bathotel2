<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'species_id',
        'breed_id',
        'age',
        'description',
        'available',
        'image',
    ];

    // Relationships
    public function species()
    {
        return $this->belongsTo(Species::class);
    }
public function pet()
{
    return $this->belongsTo(Pet::class);
}

    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }
}
