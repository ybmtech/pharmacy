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
        'category_id',
        'manufacturer',
        'quantity',
        'restock_level',
        'availability',
        'price',
        'dosage',
        'side_effect',
        'expire_date',
        'image',
    ];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
    public function category(){
        return $this->belongsTo(DrugCategory::class,'category_id');
    }

    public function supplierName(){
        return ucwords($this->supplier->name);
    }

    public function categoryName(){
        return ucwords($this->category->name);
    }
    
    public function drugName(){
        return ucwords($this->name);
    }
}
