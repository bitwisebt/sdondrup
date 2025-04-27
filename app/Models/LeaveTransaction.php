<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveTransaction extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'employee_id', 'leave_id',
        'date', 'purpose',
        'start', 'end', 'days'
    ];
    public function Leave()
    {
        return $this->belongsTo(LeaveConfiguration::class, 'leave_id');
    }
    public function Employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
