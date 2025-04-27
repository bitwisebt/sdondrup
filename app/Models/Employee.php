<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $fillable = [
        'company_id',
        'employee_id',
        'name',
        'cid_number',
        'gender',
        'dob',
        'contact_number',
        'email',
        'address',
        'appointment_date',
        'department_id',
        'designation_id',
        'bank_id',
        'tpn',
        'account_number',
        'employee_type_id',
        'status'
    ];
    public function Department(){
        return $this->belongsTo(Department::class,'department_id');
    }
    public function Designation(){
        return $this->belongsTo(Designation::class,'designation_id');
    }
    public function Bank(){
        return $this->belongsTo(Bank::class,'bank_id');
    }
    public function EmployeeType(){
        return $this->belongsTo(EmployeeType::class,'employment_type_id');
    }
}
