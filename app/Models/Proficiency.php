<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proficiency extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'student_id', 'test_id', 'reading', 'writing', 'listening', 'speaking', 'total'
    ];
    public function Test(){
        return $this->belongsTo(Test::class,'test_id');
    }
}
