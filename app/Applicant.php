<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Applicant extends Model
{
    protected $table = 'applicants';
    protected $fillable = [
        'citizen_id',
        'title',
        'fname',
        'lname',
        'title_en',
        'fname_en',
        'lname_en',
        'gender',
        'email',
        'phone',
        'birthdate',
        'staying_with_parent',
        'father',
        'mother',
        'guardian',
        'school',
        'graduation_year',
        'gpa',
        'school_move_in',
        'school_province',
        'address',
        'application_type',
        'quota_type',
        'plan',
        'majors',
        'quota_grade',
        'documents',
        'check_status',
        'submitted',
    ];

    public $timestamps = false;
    // Timestamp has to be disable because it'll throw
    // MongoDB\Driver\Exception\InvalidArgumentException with message
    // 'MongoDB\BSON\UTCDateTime::__construct() expects parameter 1 to be integer, float given'
}
