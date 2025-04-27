<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualificationHistory extends Model
{
    use HasFactory;
    public function Qualification(){
        return $this->belongsTo(Qualification::class,'qualification_id');
    }
}
