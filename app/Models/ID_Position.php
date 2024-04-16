<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ID_Position extends Model
{
    use HasFactory;
    protected $fillable = [
        'template_id',
        'firstname_x',
        'firstname_y',
        'firstname_fw',
        'firstname_ff',
        'firstname_b',

        'middlename_x',
        'middlename_y',
        'middlename_fw',
        'middlename_ff',
        'middlename_b',

        'lastname_x',
        'lastname_y',
        'lastname_fw',
        'lastname_ff',
        'lastname_b',

        'student_number_x',
        'student_number_y',
        'student_number_fw',
        'student_number_ff',
        'student_number_b',

        'course_x',
        'course_y',
        'course_fw',
        'course_ff',
        'course_b',

        'year_sem_x',
        'year_sem_y',
        'year_sem_fw',
        'year_sem_ff',
        'year_sem_b',

        'contact_form_x',
        'contact_form_y',
        'contact_form_fw',
        'contact_form_ff',
        'contact_form_b',

        'address_x',
        'address_y',
        'address_fw',
        'address_ff',
        'address_b',
        'address_w',
        'address_h',

        'number_x',
        'number_y',
        'number_fw',
        'number_ff',
        'number_b',

        'profile_x',
        'profile_y',
        'profile_w',
        'profile_h',

        'signature_x',
        'signature_y',
        'signature_w',
        'signature_h',
    ];
}
