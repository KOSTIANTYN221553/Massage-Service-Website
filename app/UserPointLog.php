<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;


class UserPointLog extends Model
{
    protected $table = 'user_point_log';

    protected $guarded  = ['id'];
    public $timestamps = false;

    public function insertUserPoint($userId){
        $select = " *, getUserReplyCount('{$userId}') replyCount";
        $model = new User();
        $userInfo = $model->select(DB::raw($select))->find($userId);
        $replyCnt = $userInfo['replyCount'];
        if($replyCnt >=5){
            $where = array();
            $where['user_id'] = $userId;
            $whereRaw = "1=1";
            $model = new UserPointLog();
            $model = $model->where($where)->whereRaw($whereRaw);
            $info = $model -> first();
            if(!isset($info['id'])){
                $info = new UserPointLog();
                $info['user_id'] = $userId;
                $info['add_point'] = 1;
                $info['log_date'] = date("Y-m-d H:i:s");
                $info['cur_cnt'] = $replyCnt ;
                $info->save();
                $userInfo['user_point'] = $userInfo['user_point'] + 1;
                $userInfo->save();
            }
        }

    }

    public function addRemoveUserPoint($userId,$point, $is_add = 1){
        $select = "*,getUserBoardCount('{$userId}') board_cnt, getUserReviewCount('{$userId}') review_cnt, getUserReplyCount('{$userId}') reply_cnt ";
        $userInfo = User::select(DB::raw($select))->find($userId);
        if($is_add*1 == 1){
            $userInfo['user_point']= $userInfo['user_point'] + $point;
        }else{
            $userInfo['user_point']= $userInfo['user_point'] - $point >= 0 ?$userInfo['user_point'] - $point: 0;
        }
        $userInfo->save();
        $this->updateUserLevel_force($userInfo['id']);

    }

    public function updateUserLevel($userInfo, $is_add){
        $level_id = $userInfo['level_id'];
        if($level_id*1 == 1){
            $pre_level_id = 1;
        }else{
            $pre_level_id = $level_id-1;
        }

        if($level_id*1 == 21){
            $next_level_id = 21;
        }else{
            $next_level_id = $level_id + 1;
        }

        $level_info = array();
        if($is_add*1 == 1){
            if($next_level_id*1  != $level_id*1){
                $level_info = UserLevel::find($next_level_id);
            }
        }else if($is_add*1 == 0){
            if($pre_level_id*1  != $level_id*1){
                $level_info = UserLevel::find($level_id);
            }
        }
        if(isset($level_info['id'])){
            $period = $level_info['period'];
            $need_point = $level_info['need_point'];
            $review_cnt = $level_info['review_cnt'];
            $board_cnt = $level_info['board_cnt'];
            $reply_cnt = $level_info['reply_cnt'];
            if($level_id*1 == 1 && $is_add*1 == 0){
                $need_point = 0;
            }
            if(
                $period <= getDayDiff1('', $userInfo['created_at']) &&
                $need_point <= $userInfo['user_point'] &&
                $review_cnt <= $userInfo['review_cnt'] &&
                $board_cnt <= $userInfo['board_cnt'] &&
                $reply_cnt <= $userInfo['reply_cnt'] && $is_add*1 == 1
            ){
                $userInfo['level_id'] = $next_level_id;
                $userInfo->save();
            }elseif(
                ($need_point > $userInfo['user_point'] ||
                $review_cnt > $userInfo['review_cnt'] ||
                $board_cnt > $userInfo['board_cnt'] ||
                $reply_cnt > $userInfo['reply_cnt'] )&& $is_add*1 == 0){

                $userInfo['level_id'] = $pre_level_id;

                $userInfo->save();
            }
        }

    }

   public function updateUserLevel_force($user_id){
        $select = "*, getUserBoardCount(id) board_cnt, getUserReviewCount(id) review_cnt, getUserReplyCount(id) reply_cnt";
        $user_info = User::select(DB::raw($select))->find($user_id);
        if(!isset($user_info['id'])){
            return;
        }
        if($user_info['level_id']*1 == 21) return;
       if($user_info['level_id']*1 == 1) return;
        $need_point = $user_info['user_point'];
        $whereRaw = "need_point <= {$need_point} AND id < 21 AND review_cnt <= {$user_info['review_cnt']} AND board_cnt <= {$user_info['board_cnt']} AND reply_cnt <= {$user_info['reply_cnt']}";
        $level_info = UserLevel::whereRaw($whereRaw)->orderBy("id", "desc")->first();
        if(isset($level_info['id'])&& $level_info['id'] != $user_info['level_id']*1){
            $user_info['level_id'] = $level_info['id'];
            unset($user_info['board_cnt']);
            unset($user_info['review_cnt']);
            unset($user_info['reply_cnt']);
            $user_info->save();
        }

   }

   public function checkUserLevel($user_id, $level_id){
       if($level_id*1 == 21) return true;
       if($level_id*1 == 0) return true;
       if($level_id*1 == 1) return true;
       $select = "*, getUserBoardCount(id) boardCount, getUserReplyCount(id) replyCount, getUserReviewCount(id) reviewCount ";
       $user_info = User::select(DB::raw($select))->find($user_id);
       $level_info = UserLevel::find($level_id);
       if(!isset($level_info['id']) || !isset($user_info['id'])) return false;
       $ret = false;
       if(
           $level_info['need_point']*1 <= $user_info['user_point']*1 &&
           $level_info['review_cnt']*1 <= $user_info['reviewCount']*1 &&
           $level_info['board_cnt']*1 <= $user_info['boardCount']*1 &&
           $level_info['reply_cnt']*1 <= $user_info['replyCount']*1
       ){
            $ret = true;
       }
       return $ret;

   }


}
