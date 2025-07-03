<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionReply extends Model
{
    protected $table = 'question_reply';

    protected $guarded  = ['id'];

    public function user(){
        return  $this->hasOne('App\User', 'id', 'user_id');
    }

    public function reply(){
        return $this->hasMany('App\QuestionReply', 'parent_reply_id', 'id');
    }

    static public function getReplyList($board_id){
        $where = array();
        $where['board_id'] = $board_id;
        $where['parent_reply_id'] =0;
        $list = QuestionReply::where($where)->get();
        return $list;
    }

}
