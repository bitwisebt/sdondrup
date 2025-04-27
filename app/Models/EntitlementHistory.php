<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntitlementHistory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'date',
        'employee_id',
        'basic_pay',
        'allowance',
        'health_contribution',
        'provident_fund',
        'tds'
    ];
}
