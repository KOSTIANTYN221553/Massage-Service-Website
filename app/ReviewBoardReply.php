<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewBoardReply extends Model
{
    protected $table = 'review_board_reply';

    protected $guarded  = ['id'];

    static public function getReplyList($board_id){
        $where = array();
        $where['board_id'] = $board_id;
        $where['parent_reply_id'] =0;
        $list = ReviewBoardReply::where($where)->get();
        return $list;
    }

    public function user(){
        return  $this->hasOne('App\User', 'id', 'user_id');
    }

    public function reply(){
        return $this->hasMany('App\ReviewBoardReply', 'parent_reply_id', 'id');
    }



}
