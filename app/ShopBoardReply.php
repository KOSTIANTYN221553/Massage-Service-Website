<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopBoardReply extends Model
{
    protected $table = 'shop_board_reply';

    protected $guarded  = ['id'];

    public function user(){
        return  $this->hasOne('App\User', 'id', 'user_id');
    }

    public function reply(){
        return $this->hasMany('App\ShopBoardReply', 'parent_reply_id', 'id');
    }

    static public function getReplyList($board_id){
        $where = array();
        $where['board_id'] = $board_id;
        $where['parent_reply_id'] =0;
        $list = ShopBoardReply::where($where)->get();
        return $list;
    }

}
