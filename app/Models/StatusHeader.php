<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusHeader extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'student_id', 'status_id', 'date','status'
    ];
    
    public function Status(){
        return $this->belongsTo(Status::class,'status_id');
    }
    public function Registration(){
        return $this->belongsTo(Student::class,'student_id');
    }
}
