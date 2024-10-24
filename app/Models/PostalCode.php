<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostalCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'village_id',
    ];

    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id', 'id');
    }
}