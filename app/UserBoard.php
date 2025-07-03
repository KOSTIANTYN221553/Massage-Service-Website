<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sentinel;

class UserBoard extends Model
{
    protected $table = 'user_board';

    protected $guarded  = ['id'];

    public function user(){
        return  $this->hasOne('App\User', 'id', 'user_id');
    }

    public function getNoticeList(){
        $where = array("is_notice"=>1);
        $list = UserBoard::where($where)->skip(0)->take(1)->get();
        return $list;
    }

    public function addViewCount(){
        if(!Sentinel::check()) return;
        $user = Sentinel::getuser();
        if(!UserBoardView::isRead($user['id'], $this->id)){
            $this->view_count = $this->view_count +1;
            $this->save();
            $info = new UserBoardView();
            $info['user_id'] = $user['id'];
            $info['board_id'] = $this->id;
            $info->save();
        }
    }

}
