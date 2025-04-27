<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $fillable = [
        'user_id',
        'registration_date',
        'cid_number',
        'name',
        'gender',
        'contact_number',
        'email',
        'passport_number',
        'issue_date',
        'expiry_date',
        'marital_status',
        'present_address',
        'status',
        'study_id',
        'super_agent_id',
        'sub_agent_id',
        'type',
        'created_by'
    ];
    public function AssignTo(){
        return $this->belongsTo(User::class,'created_by');
    }
    public function StudyPreferance(){
        return $this->belongsTo(StudyPreferance::class,'study_id');
    }
    public function SuperAgent(){
        return $this->belongsTo(Agent::class,'super_agent_id');
    }
    public function SubAgent(){
        return $this->belongsTo(Agent::class,'sub_agent_id');
    }
}
