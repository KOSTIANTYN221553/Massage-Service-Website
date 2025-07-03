<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewBoardView extends Model
{
    protected $table = 'review_board_view';

    protected $guarded  = ['id'];

    static public function isRead($user_id, $board_id){
        $where = array();
        $where['user_id'] = $user_id;
        $where['board_id'] = $board_id;
        $cnt = ReviewBoardView::where($where)->count();
        $ret = false;
        if($cnt > 0){
            $ret = true;
        }
        return $ret;
    }

}
