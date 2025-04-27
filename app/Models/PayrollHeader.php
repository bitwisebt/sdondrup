<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollHeader extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'company_id',
        'pay_period',
        'generate_date',
        'confirm_date',
        'release_date',
        'flag'
    ];
}
