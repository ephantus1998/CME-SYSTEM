<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cme extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'date', 'facilitator', 'location'];

    // Define the relationship: One CME has many attendance records
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}