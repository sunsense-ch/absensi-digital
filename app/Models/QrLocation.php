<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrLocation extends Model
{
    use HasFactory;

    /**
     * Kolom yang diizinkan untuk diisi secara massal (mass assignment).
     *
     * s
     */
    protected $fillable = [
        'name',
        'code',
        'latitude',
        'longitude',
        'radius',
    ];

public function tokens()
{
    return $this->hasMany(QrToken::class);
}

public function attendances()
{
    return $this->hasMany(Attendance::class);
}
}
