<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'drug_id',
        'quantity',
        'price',
        'discount'
    ];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function drug(){
        return $this->belongsTo(Drug::class);
    }
}
