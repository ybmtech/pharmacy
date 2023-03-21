<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
 /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'sender_id',
        'message',
    ];

   public function patient(){
    return $this->belongsTo(User::class,'patient_id');
   }

   public function doctor(){
    return $this->belongsTo(User::class,'doctor_id');
   }

}
