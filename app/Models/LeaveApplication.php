<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveApplication extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $fillable = [
        'employee_id',
        'leave_id',
        'date',
        'purpose',
        'start',
        'end',
        'days',
        'flag',
        'remarks',
        'appoved_by',
        'appoved_date',
    ];
    public function User(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function Employee(){
        return $this->belongsTo(Employee::class,'employee_id');
    }
    public function Leave(){
        return $this->belongsTo(LeaveConfiguration::class,'leave_id');
    }
}
