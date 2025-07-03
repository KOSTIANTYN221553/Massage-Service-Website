<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Sentinel;

class Schedule extends Model
{
    protected $table = 'schedule';

    protected $guarded  = ['id'];

    public function recentScheduleList($schedule_type){
        $schedule_model = new Schedule();
        $schedule_model = $schedule_model->join("shop", "schedule.shop_id","=","shop.id");
        $schedule_model = $schedule_model->orderBy("schedule.created_at", "desc");
        $now = date("Y-m-d");
        $whereRaw = "isShopComplete(shop.id, '{$now}')  =1 AND shop.type = {$schedule_type}";
        $schedule_model = $schedule_model->whereRaw($whereRaw);
        $schedule_model = $schedule_model->skip(0)->take(18);
        $select = "schedule.*, shop.img";
        $schedule_model = $schedule_model->select(DB::raw($select));
        $list = $schedule_model->get();
        return $list;
    }

    public function recentScheduleListWithTypeList($type_list){
        $ret = array();
        foreach($type_list as $type_item){
            $ret[$type_item['id']] = $this->recentScheduleList($type_item['id']);
        }
        return $ret;
    }

    public function shop(){
        return  $this->hasOne('App\Shop', 'id', 'shop_id');
    }

    public function addViewCount(){
        if(!Sentinel::check()) return;
        $user = Sentinel::getuser();
        if(!ScheduleView::isRead($user['id'], $this->id)){
            $this->view_count = $this->view_count +1;
            $this->save();
            $info = new ScheduleView();
            $info['user_id'] = $user['id'];
            $info['board_id'] = $this->id;
            $info->save();
        }
    }

}
