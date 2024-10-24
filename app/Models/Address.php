<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'postal_code_id',
        'street',
        'is_primary',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function postalCode()
    {
        return $this->belongsTo(PostalCode::class, 'postal_code_id', 'id');
    }
}