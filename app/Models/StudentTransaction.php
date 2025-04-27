<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentTransaction extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'student_id', 'status_id', 'status'
    ];
    
    public function Status(){
        return $this->belongsTo(Status::class,'status_id');
    }
    public function Student(){
        return $this->belongsTo(Student::class,'student_id');
    }
}
