<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class PassedApplicant extends Model
{
    protected $table = 'passed_applicants';
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
        'school_province',
        'school2',
        'school2_province',
        'gpa',
        'address',
        'application_type',
        'quota_type',
        'plan',
        'majors',
        'quota_grade',
        'documents',
        'check_status',
        'submitted',
        'passed',
    ];

    public $timestamps = false;
    // Timestamp has to be disable because it'll throw
    // MongoDB\Driver\Exception\InvalidArgumentException with message
    // 'MongoDB\BSON\UTCDateTime::__construct() expects parameter 1 to be integer, float given'

}
