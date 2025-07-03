<?php

namespace App\Http\Controllers;

use Activation;
use App\Board;
use App\BoardReply;
use App\EbzaBoard;
use App\EbzaBoardReply;
use App\Http\Requests;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\FrontendRequest;
use App\ReviewBoard;
use App\Schedule;
use App\ShopType;
use App\User;
use App\UserBoard;
use App\UserBoardReply;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use File;
use Hash;
use Illuminate\Http\Request;
use Mail;
use Redirect;
use Reminder;
use Validator;
use Sentinel;
use URL;
use View;

use stdClass;
use App\Mail\Contact;
use App\Mail\ForgotPassword ;
use DB;
use App\UserPointLog;


class UserBoardController extends JoshController
{
    public function __construct()
    {
        parent::__construct();
    }


    public function index(){
        $filter_param = ['search_title'];
        $result = checkSQLInject($filter_param);
        if($result){
            return view("sql_inject");
        }
        $pageParam = $this->getPageParam(12);
        $model = new UserBoard();
        $where = array();
        $select = "*, getUserLevelIcon(user_id) level_icon";
        $search_type = $this->getParam("search_type", "");
        view()->share("search_type", $search_type);
        $search_title = $this->getParam("search_title", "");
        view()->share("search_title", $search_title);
        $whereRaw = "1=1";
        if($search_type != '' && $search_title != ''){
            if($search_type == "reply"){
                $whereRaw .= " AND isContainEbzaBoardReply(id, '{$search_title}') = 1";
            }else if($search_type == 'title&content'){
                $whereRaw .= " AND (title LIKE '%{$search_title}%' OR description LIKE '%{$search_title}%')";
            }else{
                $whereRaw .= " AND {$search_type} LIKE '%{$search_title}%'";
            }
        }
        $user_id = $this->getParam("user_id", "0");
        view()->share("user_id", $user_id);
        if($user_id *1 > 0){
            $whereRaw .= " AND user_id = {$user_id}";
        }
        $model = $model->whereRaw($whereRaw);
        $model = $model->where($where);
        $model = $model->select(DB::raw($select));
        $count = $model->count();
        $model = $model->orderBy("id", "DESC");
        $model = $model->skip($pageParam["start"])->take($pageParam["perPageSize"]);
        $list = $model->get();
        $pageParam = $this->setPageParam($pageParam, $count);
        view()->share('pageParam', $pageParam);
        view()->share("list", $list);
        $model = new Board();
        $recent_board_list = $model->getRecentBoardList(0,10);
        view()->share("recent_board_list",$recent_board_list);
        $model = new UserBoard();
        $notice_list = $model->getNoticeList();
        view()->share("notice_list", $notice_list);
        getCurrentLang();
        view()->share("page_title", __("lang.갤러리")." > ".__("lang.유저갤러리"));
        return view('user_board');
    }

    public function info($id){
        $msg = $this->checkUser();
        if($msg != ""){
            $this->messageBag->add('email', $msg);
            return redirect("/")->withInput()->withErrors($this->messageBag);
        }

        $select = "*,getUserLevelIcon(user_id) level_icon";
        $info = UserBoard::select(DB::raw($select))->find($id);
        if(!isset($info['id'])){
            return redirect("user_board");
        }
        view()->share("info", $info);
        $reply_list = UserBoardReply::getReplyList($id);
        view()->share("reply_list", $reply_list);
        $user = Sentinel::getuser();
        view()->share("user", $user);
        $this->getInfoList($id);
        $model = new Board();
        $recent_board_list = $model->getRecentBoardList(0,10);
        view()->share("recent_board_list",$recent_board_list);
        return view('user_board_info');
    }

    public function write($id){
        if($id*1 == 0){
            $info = new UserBoard();
        }else{
            $info = UserBoard::find($id);$user = Sentinel::getuser();
            $user_id = $info['user_id'];

            if($user['id']*1 != $user_id){
                return view("no_permission");
            }

            if(!isset($info['id'])){
                return redirect("user_board");
            }
        }
        view()->share("id", $id);
        view()->share("info", $info);

        $model = new Board();
        $recent_board_list = $model->getRecentBoardList(0,10);
        view()->share("recent_board_list",$recent_board_list);
        return view('user_board_write');
    }

    public function ajaxSaveInfo(Request $request){
        $id = $this->getParam("id", "0");
        $info = UserBoard::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new UserBoard();
            $ret = $this -> getBoClass($info,$request, 'user_board');
            $info = $ret['model'];
        }

        $img = $request->get("img_val","");
        if($img != '' && 0 !== strpos($img, 'http')){
            $img = $this->genImage($img);
            if($img === "-1"){
                return json_encode(array('status'=>"0", "msg"=> __("lang.이미지 파일을 업로드 해주십시오.")));
            }
            $info['img'] = $img;
        }
        if($id*1 == 0){
            $user = Sentinel::getuser();
            $info['user_id'] = $user['id'];
        }
        $info['description'] = XSSfilter($info['description']);
        $info->save();
        return json_encode(array('status'=>1));
    }

    public function deleteInfo(){
        $id = $this->getParam("id", "0");
        $info = UserBoard::find($id);
        if(isset($info['id'])){
            if($info['img'] != ''){
                unlink(realpath($info['img']));
            }
        }
        UserBoard::where(array("id"=>$id))->delete();
        $whereRaw = "board_id = {$id}";
        UserBoardReply::whereRaw($whereRaw)->delete();
        return json_encode(array('status'=>1));
    }


    public function getInfoList($id){
        $pageParam = $this->getPageParam();
        $model = new UserBoard();
        $where = array();
        $select = "*,getUserLevelIcon(user_id) level_icon ";
        $whereRaw = "id<>{$id}";
        $model = $model -> whereRaw($whereRaw);
        $model = $model->where($where);
        $model = $model->select(DB::raw($select));
        $count = $model->count();
        $model = $model->skip($pageParam["start"])->take($pageParam["perPageSize"]);
        $list = $model->get();
        $pageParam = $this->setPageParam($pageParam, $count);
        view()->share('pageParam', $pageParam);
        view()->share("list", $list);
    }

    public function ajaxSaveReply(Request $request){
        $id = $this->getParam("id", "0");
        $info = UserBoardReply::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new UserBoardReply();
            $ret = $this -> getBoClass($info,$request, 'user_board_reply');
            $info = $ret['model'];
        }
        if($info['id']*1 == 0 && $info['parent_reply_id']*1  ==0){
            $review_info = UserBoard::find($info['board_id']);
            $review_info['reply_count'] = $review_info['reply_count']+1;
            $review_info->save();
        }

        $user = Sentinel::getuser();
        $info['user_id'] = $user['id'];
        $info['description'] = XSSfilter($info['description']);
        $info->save();
        if($id*1 == 0){
            $model = new UserPointLog();
            $model->insertUserPoint($user['id']);
        }
        return json_encode(array('status'=>1));
    }

    public function deleteReply(){
        $id = $this->getParam("id", "0");
        $reply_info = UserBoardReply::find($id);
        if(isset($reply_info['id'])&& $reply_info['parent_reply_id']*1 == 0){
            $board_id = $reply_info['board_id'];
            $board_info = UserBoard::find($board_id);
            if($board_info['reply_count'] >= 1){
                $board_info['reply_count'] -= 1;
                $board_info->save();
            }
        }
        $whereRaw = "id = {$id} OR parent_reply_id = {$id}";
        UserBoardReply::whereRaw($whereRaw)->delete();
        return json_encode(array('status'=>1));
    }

}
