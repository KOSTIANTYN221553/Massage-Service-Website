<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBoardView extends Model
{
    protected $table = 'user_board_view';

    protected $guarded  = ['id'];

    static public function isRead($user_id, $board_id){
        $where = array();
        $where['user_id'] = $user_id;
        $where['board_id'] = $board_id;
        $cnt = UserBoardView::where($where)->count();
        $ret = false;
        if($cnt > 0){
            $ret = true;
        }
        return $ret;
    }

}
