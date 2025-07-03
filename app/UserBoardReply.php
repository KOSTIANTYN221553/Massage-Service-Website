<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBoardReply extends Model
{
    protected $table = 'user_board_reply';

    protected $guarded  = ['id'];

    public function user(){
        return  $this->hasOne('App\User', 'id', 'user_id');
    }

    public function reply(){
        return $this->hasMany('App\UserBoardReply', 'parent_reply_id', 'id');
    }

    static public function getReplyList($board_id){
        $where = array();
        $where['board_id'] = $board_id;
        $where['parent_reply_id'] =0;
        $list = UserBoardReply::where($where)->get();
        return $list;
    }

}
