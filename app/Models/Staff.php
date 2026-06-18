<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 
        'staff_no', 
        'department',
        'cadre',
        'email',
        'license_no'
    ];

    /**
     * Get all of the attendance logs recorded for this staff member.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}