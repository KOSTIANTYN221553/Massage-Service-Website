<?php

namespace App\Http\Controllers;

use Activation;
use App\Advice;
use App\AdviceReply;
use App\Board;
use App\BoardReply;
use App\EbzaBoard;
use App\EbzaBoardReply;
use App\Http\Requests;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\FrontendRequest;
use App\ReviewBoard;
use App\ReviewBoardReply;
use App\Schedule;
use App\Shop;
use App\ShopType;
use App\User;
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


class AdviceController extends JoshController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $pageParam = $this->getPageParam(20);
        $search = $this->getParam("search", "");
        view()->share('search', $search);
        $where = array();
        $model = new Advice();
        $whereRaw = "1=1";
        $model = $model->where($where);
        $select = "*,getUserLevelIcon(user_id) level_icon";
        $model = $model->select(DB::raw($select));
        $model = $model->whereRaw($whereRaw);

        $count = $model->count();

        $model->orderBy("id", "desc");
        $model = $model->skip($pageParam["start"])->take($pageParam["perPageSize"]);
        $list = $model->get();
        $pageParam = $this->setPageParam($pageParam, $count);
        view()->share('pageParam', $pageParam);
        view()->share("list", $list);
        $model = new Board();
        $recent_board_list = $model->getRecentBoardList(0,10);
        view()->share("recent_board_list",$recent_board_list);

        $model = new Advice();
        $notice_list = $model->getNoticeList();
        view()->share("notice_list", $notice_list);
        getCurrentLang();
        view()->share("page_title", __("lang.회원센터")." > ".__("lang.건의사항"));
        return view('advice');
    }

    public function info($id){
        $msg = $this->checkUser();
        if($msg != ""){
            $this->messageBag->add('email', $msg);
            return redirect("/")->withInput()->withErrors($this->messageBag);
        }
        $select = "*,getUserLevelIcon(user_id) level_icon ";
        $info = Advice::select(DB::raw($select))->find($id);
        if(!isset($info['id'])){
            return redirect("advice");
        }
        $info->addViewCount();
        view()->share("info", $info);
        $reply_list = AdviceReply::getReplyList($id);
        view()->share("reply_list", $reply_list);
        $user = Sentinel::getuser();
        view()->share("user", $user);
        $this->getInfoList($id);
        $model = new Board();
        $recent_board_list = $model->getRecentBoardList(0,10);
        view()->share("recent_board_list",$recent_board_list);
        return view('advice_info');
    }


    public function getInfoList($id){
        $pageParam = $this->getPageParam();
        $model = new Advice();
        $where = array();

        $select = "*,getUserLevelIcon(user_id) level_icon";
        $whereRaw = "id<>{$id}";
        $model = $model -> whereRaw($whereRaw);
        $model = $model->where($where);
        $model = $model->select(DB::raw($select));
        $count = $model->count();
        $model->orderBy("id", "desc");
        $model = $model->skip($pageParam["start"])->take($pageParam["perPageSize"]);
        $list = $model->get();
        $pageParam = $this->setPageParam($pageParam, $count);
        view()->share('pageParam', $pageParam);
        view()->share("list", $list);
    }

    public function ajaxSaveReview(Request $request){
        $id = $this->getParam("id", "0");
        $info = Advice::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new Advice();
            $ret = $this -> getBoClass($info,$request, 'advice');
            $info = $ret['model'];
        }

        $user = Sentinel::getuser();
        $info['user_id'] = $user['id'];
        $info['description'] = XSSfilter($info['description']);
        $info->save();
        return json_encode(array('status'=>1));
    }


    public function ajaxSaveReply(Request $request){
        $id = $this->getParam("id", "0");
        $info = AdviceReply::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new AdviceReply();
            $ret = $this -> getBoClass($info,$request, 'advice_reply');
            $info = $ret['model'];
        }
        if($info['id']*1 == 0 && $info['parent_reply_id']*1  ==0){
            $review_info = Advice::find($info['board_id']);
            $review_info['reply_count'] = $review_info['reply_count']+1;
            $review_info->save();
        }

        $user = Sentinel::getuser();
        $info['user_id'] = $user['id'];
        $info['description'] = XSSfilter($info['description']);
        $info->save();
        return json_encode(array('status'=>1));
    }

    public function deleteReply(){
        $id = $this->getParam("id", "0");
        $reply_info = AdviceReply::find($id);
        if(isset($reply_info['id'])&& $reply_info['parent_reply_id']*1 == 0){
            $board_id = $reply_info['board_id'];
            $board_info = Advice::find($board_id);
            if($board_info['reply_count'] >= 1){
                $board_info['reply_count'] -= 1;
                $board_info->save();
            }
        }
        $whereRaw = "id = {$id} OR parent_reply_id = {$id}";
        AdviceReply::whereRaw($whereRaw)->delete();
        return json_encode(array('status'=>1));
    }

    public function write($id){
        if($id*1 == 0){
            $info = new Advice();
        }else{
            $info = Advice::find($id);
            $user = Sentinel::getuser();
            $user_id = $info['user_id'];

            if($user['id']*1 != $user_id){
                return view("no_permission");
            }

            if(!isset($info['id'])){
                return redirect("advice");
            }

        }
        view()->share("id", $id);
        view()->share("info", $info);

        $model = new Board();
        $recent_board_list = $model->getRecentBoardList(0,10);
        view()->share("recent_board_list",$recent_board_list);
        return view('advice_write');
    }



    public function deleteInfo(){
        $id = $this->getParam("id", "0");
        Advice::where(array("id"=>$id))->delete();
        $whereRaw = "board_id = {$id}";
        AdviceReply::whereRaw($whereRaw)->delete();
        return json_encode(array('status'=>1));
    }

}
