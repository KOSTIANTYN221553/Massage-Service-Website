<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ShopType extends Model
{
    protected $table = 'shop_type';

    protected $guarded  = ['id'];

    static function isDelete($ids){
        $whereRaw = "FIND_IN_SET(type, '{$ids}')";
        $cnt = Shop::whereRaw($whereRaw)->count();
        if($cnt > 0){
            $ret =array("status"=>"0", "msg"=> "업소가 존재하여 삭제불가합니다.");
            return $ret;
        }
        $ret = array("status" => "1");
        return $ret;
    }

    static function getShopTypeList(){
        $list = ShopType::get();
        return $list;
    }

    static function getShopTypeList1(){
        $list = ShopType::get();
        $ret_list = array();
        $prev_id = 0;
        foreach($list as $item){
            if(mb_strpos($item['title'],'주점') !== false){
                $prev_id = $item['id'];
                array_push($ret_list, $item);
            }
        }

        foreach($list as $item){
            if($item['id']*1 != $prev_id*1){
                array_push($ret_list, $item);
            }
        }
        return $ret_list;
    }

}
