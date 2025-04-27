<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    public function Customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function Income(){
        return $this->belongsTo(Income::class,'income_id');
    }
}
