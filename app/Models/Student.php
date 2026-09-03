<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

public function classRoom()
{
    return $this->belongsTo(ClassRoom::class, 'class_id');
}

public function attendances()
{
    return $this->hasMany(Attendance::class);
}
}

