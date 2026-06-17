<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'staff_no', 'department'];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}