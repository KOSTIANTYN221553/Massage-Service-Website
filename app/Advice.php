<?php

namespace App;

use Sentinel;
use Illuminate\Database\Eloquent\Model;
use DB;

class Advice extends Model
{
    protected $table = 'advice';

    protected $guarded  = ['id'];


    public function user(){
        return  $this->hasOne('App\User', 'id', 'user_id');
    }

    public function addViewCount(){
        if(!Sentinel::check()) return;
        $user = Sentinel::getuser();
        if(!AdviceView::isRead($user['id'], $this->id)){
            $this->view_count = $this->view_count +1;
            $this->save();
            $info = new AdviceView();
            $info['user_id'] = $user['id'];
            $info['board_id'] = $this->id;
            $info->save();
        }
    }

    public function getNoticeList(){
        $where = array("is_notice"=>1);
        $list = Advice::where($where)->skip(0)->take(1)->get();
        return $list;
    }

}
