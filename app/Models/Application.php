<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'qualification_id',
        'education_year',
        'english_test',
        'employement_status',
        'flag',
    ];
    public function Qualification(){
        return $this->belongsTo(Qualification::class,'qualification_id');
    }
}
