<?php

namespace App\Http\Controllers;

use Activation;
use App\Board;
use App\BoardCategory;
use App\BoardFavor;
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
use App\UserPointLog;
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


class BoardController extends JoshController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index($board_type){
        $filter_param = ['search_title'];
        $result = checkSQLInject($filter_param);
        if($result){
            return view("sql_inject");
        }
        $category_id = $this -> getParam("category_id", "0");
        view()->share("category_id", $category_id);

        $pageParam = $this->getPageParam(20);
        $search = $this->getParam("search", "");
        view()->share('search', $search);
        $where = array();
        $where['board_type']= $board_type;
        $model = new Board();
        $whereRaw = "1=1";
        $model = $model->where($where);
        $select = "*,getUserLevelIcon(user_id) level_icon";
        $model = $model->select(DB::raw($select));

        if($category_id*1 != 0){
            $where['category_id'] = $category_id;
        }

        $search_type = $this->getParam("search_type", "");
        view()->share("search_type", $search_type);
        $search_title = $this->getParam("search_title", "");
        view()->share("search_title", $search_title);
        if($search_type != '' && $search_title != ''){
            if($search_type == "reply"){
                $whereRaw .= " AND isContainBoardReply(id, '{$search_title}') = 1";
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
        $count = $model->count();
        $model->orderBy("id", "desc");
        $model = $model->skip($pageParam["start"])->take($pageParam["perPageSize"]);
        $list = $model->get();
        $pageParam = $this->setPageParam($pageParam, $count);
        view()->share('pageParam', $pageParam);
        view()->share("list", $list);
        view()->share('board_type_str', __("lang.".getBoardTypeStr($board_type)));
        view()->share("board_type", $board_type);
        $model = new Board();
        $recent_board_list = $model->getRecentBoardList(0,10);
        view()->share("recent_board_list",$recent_board_list);

        $model = new Board();
        $notice_list = $model->getNoticeList($board_type);
        view()->share("notice_list", $notice_list);
        getCurrentLang();
        view()->share("page_title", __("lang.커뮤니티")." > ".__("lang.".getBoardTypeStr($board_type)));


        $model = new Board();
        $category_list = $model->getCategoryList($board_type, $whereRaw, $where);
        view()->share("category_list", $category_list);

        return view('board');
    }

    public function info($id){

        $msg = $this->checkUser();
        if($msg != ""){
            $this->messageBag->add('email', $msg);
            return redirect("/")->withInput()->withErrors($this->messageBag);
        }

        $select = "*,getUserLevelIcon(user_id) level_icon";
        $info = Board::select(DB::raw($select))->find($id);
        if(!isset($info['id'])){
            return redirect("board/1");
        }
        $info->addViewCount();
        view()->share("info", $info);
        $reply_list = BoardReply::getReplyList($id);
        view()->share("reply_list", $reply_list);
        $user = Sentinel::getuser();
        view()->share("user", $user);
        $this->getInfoList($id, $info['board_type']);

        $is_favor = $info->is_favor($user['id']);
        view()->share("is_favor", $is_favor);
        $model = new Board();
        $recent_board_list = $model->getRecentBoardList(0,10);
        view()->share("recent_board_list",$recent_board_list);
        return view('board_info');
    }

    public function setFavorBoard(){
        $board_id = $this->getParam("board_id", "0");
        $user = Sentinel::getuser();
        $user_id = $user['id'];
        $where = array();
        $where['board_id'] = $board_id;
        $where['user_id'] = $user_id;
        $favorInfo = BoardFavor::where($where)->first();
        if(isset($favorInfo['id'])){
            BoardFavor::where($where)->delete();
            Board::removeFavor($board_id);
        }else{
            $favorInfo = new BoardFavor();
            $favorInfo['board_id'] = $board_id;
            $favorInfo['user_id'] = $user_id;
            $favorInfo->save();
            Board::addFavor($board_id);
        }

        return json_encode(array("status"=>"1"));
    }

    public function getInfoList($id, $board_type){
        $pageParam = $this->getPageParam();
        $search = $this->getParam("search", "");
        view()->share('search', $search);
        $where = array();
        $where['board_type']= $board_type;
        $model = new Board();
        $whereRaw = "id <> {$id}";
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
    }

    public function ajaxSaveReview(Request $request){
        $id = $this->getParam("id", "0");
        $user = Sentinel::getuser();
        $info = Board::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new Board();
            $ret = $this -> getBoClass($info,$request, 'board');
            $info = $ret['model'];
        }


        $info['user_id'] = $user['id'];
        $img = $request->get("img_val","");
        if($img != '' && 0 !== strpos($img, 'http')){
            $img = $this->genImage($img);
            if($img === "-1"){
                return json_encode(array('status'=>"0", "msg"=> __("lang.이미지 파일을 업로드 해주십시오.")));
            }
            $info['img'] = $img;
        }

        $info->save();
        if($id*1 == 0){
            $model = new UserPointLog();
            $userPoint =getUserPointFromBoardType($info['board_type'],0);
            $model->addRemoveUserPoint($user['id'],$userPoint ,1);
        }
        return json_encode(array('status'=>1));
    }


    public function ajaxSaveReply(Request $request){
        $id = $this->getParam("id", "0");
        $user = Sentinel::getuser();
        if($id*1 == 0){
            $msg = $user->isWriteReply();
            if($msg != ""){
                return json_encode(array('status'=>0, 'msg'=>$msg));
            }
        }
        $info = BoardReply::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new BoardReply();
            $ret = $this -> getBoClass($info,$request, 'board_reply');
            $info = $ret['model'];
        }
        if($info['id']*1 == 0 && $info['parent_reply_id']*1  ==0){
            $review_info = Board::find($info['board_id']);
            $review_info['reply_count'] = $review_info['reply_count']+1;
            $review_info->save();
        }


        $info['user_id'] = $user['id'];
        $info['description'] = XSSfilter($info['description']);
        $info->save();
        if($id*1 == 0){
            $model = new UserPointLog();
            $userPoint =getUserPointFromBoardType($review_info['board_type'],1);
            $model->addRemoveUserPoint($user['id'],$userPoint ,1);
        }
        return json_encode(array('status'=>1));
    }

    public function deleteReply(){
        $id = $this->getParam("id", "0");
        $user = Sentinel::getuser();
        $reply_info = BoardReply::find($id);
        if(isset($reply_info['id'])&& $reply_info['parent_reply_id']*1 == 0){
            $board_id = $reply_info['board_id'];
            $board_info = Board::find($board_id);
            if($board_info['reply_count'] >= 1){
                $board_info['reply_count'] -= 1;
                $board_info->save();
            }
        }
        $whereRaw = "id = {$id} OR parent_reply_id = {$id}";
        BoardReply::whereRaw($whereRaw)->delete();
        $model = new UserPointLog();
        $userPoint =getUserPointFromBoardType($board_info['board_type'],1);
        $model->addRemoveUserPoint($user['id'],$userPoint ,0);
        return json_encode(array('status'=>1));
    }

    public function write($id, $board_type){
        if($id*1 == 0){
            $info = new Board();
        }else{
            $info = Board::find($id);
            $user = Sentinel::getuser();
            $user_id = $info['user_id'];

            if($user['id']*1 != $user_id){
                return view("no_permission");
            }

            if(!isset($info['id'])){
                return redirect("board");
            }
        }
        view()->share("id", $id);
        view()->share("info", $info);

        $model = new Board();
        $recent_board_list = $model->getRecentBoardList(0,10);
        view()->share("recent_board_list",$recent_board_list);
        view()->share("board_type", $board_type);
        return view('board_write');
    }

    public function ajaxSaveInfo(Request $request){
        $id = $this->getParam("id", "0");
        $board_type = $this->getParam("board_type", "0");
        $user = Sentinel::getuser();
        if($id*1 ==0 && $board_type*1 == 8){
            $where = array();
            $where['user_id'] = $user['id'];
            $where['board_type'] = $board_type;
            $cnt = Board::where($where)->count();
            if($cnt >= 1){
                $ret = array();
                $ret['status'] = 0;
                $ret['msg'] = "가입인사게시판은 한개 이상 제한됩니다.";
                return json_encode($ret);
            }
        }
        $info = Board::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new Board();
            $ret = $this -> getBoClass($info,$request, 'board');
            $info = $ret['model'];
        }

        if($id*1 == 0){

            $info['user_id'] = $user['id'];
        }

        $img = $request->get("img_val","");
        if($img != '' && 0 !== strpos($img, 'http')){
            $img = $this->genImage($img);
            if($img === "-1"){
                return json_encode(array('status'=>"0", "msg"=> __("lang.이미지 파일을 업로드 해주십시오.")));
            }
            $info['img'] = $img;
        }
        $info['description'] = XSSfilter($info['description']);
        $info->save();

        if($id*1 == 0){
            $model = new UserPointLog();
            $userPoint =getUserPointFromBoardType($board_type,0);
            $model->addRemoveUserPoint($user['id'],$userPoint ,1);
        }

        return json_encode(array('status'=>1));
    }

    public function deleteInfo(){
        $user = Sentinel::getuser();
        $id = $this->getParam("id", "0");
        $board_info = Board::find($id);
        if(isset($board_info['id'])){
            if($board_info['img'] != ''){
                unlink(realpath($board_info['img']));
            }
        }
        Board::where(array("id"=>$id))->delete();
        $whereRaw = "board_id = {$id}";
        BoardReply::whereRaw($whereRaw)->delete();
        if(isset($board_info['id'])){
            $model = new UserPointLog();
            $userPoint =getUserPointFromBoardType($board_info['board_type'],0);
            $model->addRemoveUserPoint($user['id'],$userPoint ,0);
        }

        return json_encode(array('status'=>1));
    }

    public function getCategoryList(){
        $id = $this->getParam("id", "0");
        $type_id = $this->getParam("board_type", "0");
        $category_id = 0;
        if($id*1 > 0){
            $info = Board::find($id);
            $category_id = $info['category_id'];
        }


        $model = new BoardCategory();
        $categoryList = $model->getCategoryChildList(0,$type_id);

        view()->share("categoryList", $categoryList);
        view()->share("category_id", $category_id);
        return view("category_list");
    }

}
