<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'doctor_id',
        'booking_date',
        'booked_date',
        'status'
    ];

    public function doctor(){
        return $this->belongsTo(User::class,'doctor_id');
    }

    public function patient(){
        return $this->belongsTo(User::class,'user_id');
    }
}
