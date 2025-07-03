<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ShopQuestion extends Model
{
    protected $table = 'shop_question';

    protected $guarded  = ['id'];


    public function user(){
        return  $this->hasOne('App\User', 'id', 'user_id');
    }

}
