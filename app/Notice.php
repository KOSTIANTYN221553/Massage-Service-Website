<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table = 'notice';

    protected $guarded  = ['id'];

    public function getStatusStr(){
        getCurrentLang();
        if($this->status*1 == 1){
            return __("lang.노출");
        }else{
            return __("lang.비노출");
        }
    }

    public function getDisplayStr(){
        if($this->is_always_display*1 == 1){
            return __("lang.상시노출");
        }else{
            return  $this->display_start_at . ' ~ ' . $this->display_end_at;
        }
    }

    public function getNoticeList(){
        $where = array("is_notice"=>1);
        $whereRaw = "type != 6";
        $list = Notice::where($where)->whereRaw($whereRaw)->skip(0)->take(1)->get();
        return $list;
    }

}
