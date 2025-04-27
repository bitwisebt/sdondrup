<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearLeave extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function Employee(){
        return $this->belongsTo(Employee::class,'employee_id');
    }
    public function Leave(){
        return $this->belongsTo(LeaveConfiguration::class,'leave_id');
    }
}
