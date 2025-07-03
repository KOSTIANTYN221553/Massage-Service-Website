<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Sentinel;

class Board extends Model
{
    protected $table = 'board';

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
        if(!Sentinel::check()) return;
        $user = Sentinel::getuser();
        if(!BoardView::isRead($user['id'], $this->id)){
            $this->view_count = $this->view_count +1;
            $this->save();
            $info = new BoardView();
            $info['user_id'] = $user['id'];
            $info['board_id'] = $this->id;
            $info->save();
        }
    }

    public function getNoticeList($board_type){
        $where = array("is_notice"=>1, "board_type" => $board_type);
        $list = Board::where($where)->skip(0)->take(1)->get();
        return $list;
    }

    public function getCategoryList($board_type, $whereRaw, $where){
        $where1 = array();
        $where1['board_type'] = 0;
        $where1['type_id'] = $board_type;
        $whereRaw1 = "parent_id > 0";
        if(isset($where['category_id'])){
            unset($where['category_id']);
        }

        $category_model = new BoardCategory();
        $category_model = $category_model->where($where1);
        $category_model = $category_model->whereRaw($whereRaw1);
        $categoryList = $category_model->get();
        $model1 = new Board();
        $total_cnt = $model1->where($where)->whereRaw($whereRaw)->count();
        $list  = array();
        array_push($list, array('title'=>__('lang.전체'), 'cnt'=>$total_cnt, 'id'=> '0'));
        foreach($categoryList as $item){
            $model1 = new Board();
            $where['category_id'] = $item['id'];
            $cnt = $model1->where($where)->whereRaw($whereRaw)->count();
            array_push($list, array('title'=> $item['title'], 'cnt'=>$cnt, 'id'=>$item['id']));
        }
        return $list;
    }

}
