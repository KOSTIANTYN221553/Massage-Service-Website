<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopQuestionReply extends Model
{
    protected $table = 'shop_question_reply';

    protected $guarded  = ['id'];

    public function user(){
        return  $this->hasOne('App\User', 'id', 'user_id');
    }

    public function reply(){
        return $this->hasMany('App\ShopQuestionReply', 'parent_reply_id', 'id');
    }

    static public function getReplyList($board_id){
        $where = array();
        $where['board_id'] = $board_id;
        $where['parent_reply_id'] =0;
        $list = ShopQuestionReply::where($where)->get();
        return $list;
    }

}
