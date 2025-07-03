<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model {

    /*use SoftDeletes;

    protected $dates = ['deleted_at'];*/

    protected $table = 'banner';

    protected $guarded = ['id'];

   /* public function blog()
    {
        return $this->belongsTo(Blog::class);
    }*/

}
