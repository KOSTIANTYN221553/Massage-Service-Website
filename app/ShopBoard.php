<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ShopBoard extends Model
{
    protected $table = 'shop_board';

    protected $guarded  = ['id'];

    public  function getRecentBoardList($board_type = 0, $size = 10){
        $model = new Board();
        $select = "*";
        $where = array();
        if($board_type*1 > 0){
            $where['board.board_type'] = $board_type;
        }
        $model = $model->where($where);
        $end_date = date("Y-m-d");
        $start_date = getBeforeDay(7,$end_date);
        $model = $model->orderBy(DB::raw("getBoardFavorCount(id,'{$start_date}', '{$end_date}')"), "desc");
        $model = $model->skip(0)->take($size);
        $model = $model->select(DB::raw($select));
        $list = $model->get();
        return $list;
    }

    public function user(){
        return  $this->hasOne('App\User', 'id', 'user_id');
    }

    public function is_favor($user_id){
        $where = array();
        $where['user_id'] = $user_id;
        $where['board_id'] = $this['id'];
        $ret = BoardFavor::where($where)->count();
        return $ret;
    }

    static public function addFavor($id){
        $info = Board::find($id);
        if(isset($info['id'])){
            $info['favor_count'] = $info['favor_count']+1;
            $info->save();
        }
    }

    static public function removeFavor($id){
        $info = Board::find($id);
        if(isset($info['id'])){
            $favor_count = $info['favor_count'];
            if($favor_count >= 1){
                $info['favor_count'] = $info['favor_count']-1;
                $info->save();
            }
        }
    }

    public function addViewCount(){
        $this->view_count = $this->view_count +1;
        $this->save();
    }

    public function getNoticeList($board_type){
        $where = array("is_notice"=>1, "board_type" => $board_type);
        $list = Board::where($where)->skip(0)->take(1)->get();
        return $list;
    }

}
