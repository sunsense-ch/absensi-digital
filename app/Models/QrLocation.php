<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrLocation extends Model
{
    use HasFactory;

public function tokens()
{
    return $this->hasMany(QrToken::class);
}

public function attendances()
{
    return $this->hasMany(Attendance::class);
}
}
