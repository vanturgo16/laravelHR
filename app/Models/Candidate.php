<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'candidate_name', 
        'candidate_edu', 
        'candidate_birthday', 
        'candidate_exp', 
        'candidate_lastposition', 
        'candidate_appliedposition', 
        'candidate_skills', 
        'candidate_email', 
        'candidate_phone', 
        'candidate_attachment'
    ];
}
