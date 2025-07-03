<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class BoardCategory extends Model
{
    protected $table = 'board_category';

    protected $guarded  = ['id'];

    public function isDelete(){
        $ret = array();
        $ret['status'] = '1';
        return  $ret;
    }

    public function getCategoryTree($type_id, $board_type){
        $where = array();
        $where['type_id'] = $type_id;
        $where['board_type'] = $board_type;
        $where['parent_id'] = 0;
        $parentList = BoardCategory::where($where)->orderBy('order_no')->get();
        foreach($parentList as $key => $item){
            $where = array();
            $where['parent_id'] = $item['id'];
            $where['board_type'] = $board_type;
            $childList = BoardCategory::where($where)->orderBy('order_no')->get();
            $parentList[$key]['childList'] = $childList;
        }
        return $parentList;

    }

    public function getOrder(){
        $where = array();
        $where['parent_id'] = 0;
        $where['board_type'] = $this->board_type;
        $where['type_id'] = $this->type_id;

        $info = BoardCategory::where($where)->orderBy("order_no", "desc")->first();
        if(!isset($info['id'])){
            return "0";
        }else{
            return $info['order_no']+1;
        }
    }

    public function getCategoryList($board_type, $type_id){
        // $board_type 0-게시판,1 -업소종류, 2-업소후기
        $now = date("Y-m-d");
        $sql = "SELECT getBoardCategoryCount(0,{$board_type},{$type_id},'{$now}') cnt FROM board_category   LIMIT 1";
        $info = DB::select($sql);
        $total_cnt = 0;
        if(count($info) > 0){
            $total_cnt = $info[0]->cnt;
        }

        $where = array();

        $where['board_type'] = $board_type;

        $where['type_id'] = $type_id;
        $whereRaw = "parent_id > 0";
        $select = "*,getBoardCategoryCount(id,{$board_type},{$type_id},'{$now}') cnt";

        $categoryList = BoardCategory::where($where)->whereRaw($whereRaw)->select(DB::raw($select))->orderBy("order_no")->get();
        $list  = array();
        array_push($list, array('title'=>__('lang.전체'), 'cnt'=>$total_cnt, 'id'=> '0'));
        foreach($categoryList as $item){
            array_push($list, array('title'=> $item['title'], 'cnt'=>$item['cnt'], 'id'=>$item['id']));
        }
        return $list;

    }

    public function getCategoryChildList($board_type, $type_id){
        // $board_type 0-게시판,1 -업소종류
        $where = array();
        $where['board_type'] = $board_type;
        $where['type_id'] = $type_id;
        $whereRaw = "parent_id > 0";
        //$select = "*,getBoardCategoryCount(id,{$board_type},{$type_id}) cnt";
        $now = date("Y-m-d");
        $select = "*,getBoardCategoryCount(id,{$board_type},{$type_id},'{$now}') cnt";

        $categoryList = BoardCategory::where($where)->whereRaw($whereRaw)->select(DB::raw($select))->orderBy("order_no")->get();
        $list  = array();
        foreach($categoryList as $item){
            array_push($list, array('title'=> $item['title'], 'cnt'=>$item['cnt'], 'id'=>$item['id']));
        }
        return $list;

    }

    public function delCategory($id){
        Board::where(array("category_id"=>$id))->delete();
        BoardCategory::where(array("id"=>$id))->delete();
        $child_list = BoardCategory::where(array("parent_id"=>$id))->get();
        foreach($child_list as $child){
            Board::where(array("category_id"=>$child['id']))->delete();
            $child->delete();
        }
    }
}
