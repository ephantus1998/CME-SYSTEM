<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['cme_id', 'staff_id', 'status'];

    // Link back to the CME session
    public function cme()
    {
        return $this->belongsTo(Cme::class);
    }

    // Link back to the Staff member
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}