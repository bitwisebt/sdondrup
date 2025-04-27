<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyPreferance extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'study_id','university_id','course_name','start'
    ];
    public function University(){
        return $this->belongsTo(University::class,'university_id');
    }
    
}
