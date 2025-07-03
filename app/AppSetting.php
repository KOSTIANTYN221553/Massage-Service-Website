<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppSetting extends Model {

    /*use SoftDeletes;

    protected $dates = ['deleted_at'];*/

    protected $table = 'app_setting';

    protected $guarded = ['id'];

    /*public function blog()
    {
        return $this->hasMany(Blog::class);
    }*/

}
