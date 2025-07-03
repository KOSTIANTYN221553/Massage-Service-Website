<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Shop extends Model
{
    protected $table = 'shop';

    protected $guarded  = ['id'];

    static  function getShopList($user_id =0){
        $where = array();
        if($user_id*1 > 0){
            $where['user_id'] = $user_id;
        }
        $select = "*, getScheduleCount(id) schedule_cnt";
        $list = Shop::where($where)->select(DB::raw($select))->get();
        return $list;
    }



    static function getShopTypeList($type = 0){
        $where = array();
        if($type*1 > 0){
            $where['type'] = $type;
        }
        $list = Shop::where($where)->get();
        return $list;
    }

    public function shop_type(){
        return  $this->hasOne('App\ShopType', 'id', 'type');
    }

    public function user(){
        return  $this->hasOne('App\User', 'id', 'user_id');
    }

}
