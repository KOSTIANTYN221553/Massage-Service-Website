<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Sentinel;

class Note extends Model
{
    protected $table = 'note';

    public $timestamps = false;

    protected $guarded  = ['id'];

}
