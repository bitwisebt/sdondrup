<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    public function Vendor(){
        return $this->belongsTo(Vendor::class,'billing_id');
    }
    public function Expense(){
        return $this->belongsTo(Expense::class,'expense_id');
    }
}
