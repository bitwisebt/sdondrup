<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ledger extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $fillable = [
        'year',
        'account_type_id',
        'account_name',
        'balance'
    ];
    public function AccountType(){
        return $this->belongsTo(AccountType::class,'account_type_id');
    }
}
