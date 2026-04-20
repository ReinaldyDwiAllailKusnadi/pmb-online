<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'address',
        'current_address',
        'district',
        'city',
        'province',
        'home_phone',
        'phone',
        'citizen',
        'birth_place',
        'birth_day',
        'birth_month',
        'birth_year',
        'gender',
        'marital',
        'religion',
        'photo_path',
        'id_card_path',
        'family_card_path',
        'diploma_path',
        'transcript_path',
        'status',
    ];
}