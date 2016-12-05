<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Supervisor extends Model
{
    protected $table = 'supervisor';
    public $timestamps = false;
}
