<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeEntitlement extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $fillable = [
        'employee_id',
        'basic_pay',
        'allowance',
        'health_contribution',
        'provident_fund',
        'tds'
    ];
    public function Employee(){
        return $this->belongsTo(Employee::class,'employee_id');
    }
}
