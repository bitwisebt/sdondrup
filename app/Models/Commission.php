<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;
    public function University(){
        return $this->belongsTo(University::class,'university_id');
    }
    public function Type(){
        return $this->belongsTo(CommissionType::class,'commission_type_id');
    }
}
