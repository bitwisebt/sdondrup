<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'email', 'phone', 'address',
        'bank_name','branch_name', 'account_number','bsb_number', 'account_name',
        'tax_number'
    ];
}
