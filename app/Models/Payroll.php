<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payroll extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'employee_id',
        'date',
        'pay_period',
        'basic_pay',
        'allowance',
        'health_contribution',
        'provident_fund',
        'tds',
        'adjustment',
        'deductions',
        'flag'
    ];
    public function Employee(){
        return $this->belongsTo(Employee::class,'employee_id');
    }
}
