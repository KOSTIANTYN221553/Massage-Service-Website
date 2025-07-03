<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class BoardType extends Model
{
    protected $table = 'board_type';

    protected $guarded  = ['id'];

    static function isDelete($ids){
        $whereRaw = "FIND_IN_SET(board_type, '{$ids}')";
        $cnt = Board::whereRaw($whereRaw)->count();
        if($cnt > 0){
            $ret =array("status"=>"0", "msg"=> "게시판이 존재하여 삭제불가합니다.");
            return $ret;
        }
        $ret = array("status" => "1");
        return $ret;
    }

    static function getBoardTypeList(){
        $list = BoardType::get();
        return $list;
    }

}
