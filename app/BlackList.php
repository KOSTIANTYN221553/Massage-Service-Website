<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlackList extends Model
{
    protected $table = 'blacklist';

    protected $guarded  = ['id'];

}
