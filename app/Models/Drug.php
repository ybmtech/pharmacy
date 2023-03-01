<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use HasFactory;

      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'supplier_id',
        'manufacturer',
        'quantity',
        'restock_level',
        'price',
        'dosage',
        'side_effect',
        'expire_date',
        'image',
    ];

}
