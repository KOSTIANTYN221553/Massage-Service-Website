<?php

namespace App\Http\Controllers;

use Activation;
use App\Board;
use App\BoardCategory;
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
use App\UserPointLog;


class ReviewController extends JoshController
{
    public function __construct()
    {
        parent::__construct();
    }


    public function getList($shop_type){
        $filter_param = ['search_title'];
        $result = checkSQLInject($filter_param);
        if($result){
            return view("sql_inject");
        }
        
        $category_id = $this -> getParam("category_id", "0");
        view()->share("category_id", $category_id);

        $pageParam = $this->getPageParam(10);
        $search = $this->getParam("search", "");
        view()->share('search', $search);
        $where = array();
        $where['shop_type']= $shop_type;
        if($category_id != '' && $category_id*1 > 0){
            $where['category_id']= $category_id;
        }
        $model = new ReviewBoard();
        //$model = $model->leftjoin('shop', 'shop.id', '=', 'review_board.shop_id');

        $model = $model->where($where);
        $select = "review_board.*,  getCategoryName(review_board.category_id) categoryName, getUserLevelIcon(review_board.user_id) level_icon";

        $search_type = $this->getParam("search_type", "");
        view()->share("search_type", $search_type);
        $search_title = $this->getParam("search_title", "");
        view()->share("search_title", $search_title);
        $whereRaw = "1=1";
        if($search_type != '' && $search_title != ''){
            if($search_type == "reply"){
                $whereRaw .= " AND isContainReviewBoardReply(review_board.id, '{$search_title}') = 1";
            }else if($search_type == 'title&content'){
                $whereRaw .= " AND (review_board.title LIKE '%{$search_title}%' OR review_board.description LIKE '%{$search_title}%')";
            }else{
                $whereRaw .= " AND {$search_type} LIKE '%{$search_title}%'";
            }
        }
        $user_id = $this->getParam("user_id", "0");
        view()->share("user_id", $user_id);
        if($user_id *1 > 0){
            $whereRaw .= " AND review_board.user_id = {$user_id}";
        }
        $model = $model->select(DB::raw($select));
        if($category_id*1 != 0){
            $where['review_board.category_id'] = $category_id;
        }
        $model = $model->whereRaw($whereRaw);
        $model = $model->where($where);

        $count = $model->count();

        $model->orderBy("id", "desc");
        $model = $model->skip($pageParam["start"])->take($pageParam["perPageSize"]);
        $list = $model->get();
        $pageParam = $this->setPageParam($pageParam, $count);
        view()->share('pageParam', $pageParam);
        view()->share("list", $list);
        $shop_list = Shop::getShopTypeList($shop_type);
        view()->share("shop_list", $shop_list);
        view()->share("shop_type", $shop_type);
        $model = new Board();
        $recent_board_list = $model->getRecentBoardList(0,10);
        view()->share("recent_board_list",$recent_board_list);

        $shop_type_title = getShopTypeTitle($shop_type);
        getCurrentLang();
        view()->share("page_title", __("lang.업소후기")." > ".$shop_type_title);

        view()->share("shop_type_title", $shop_type_title);
        $model = new ReviewBoard();
        $notice_list = $model->getNoticeList($shop_type);
        view()->share("notice_list", $notice_list);

        $model = new ReviewBoard();
        $category_list = $model->getCategoryList($shop_type, $whereRaw, $where);
        view()->share("category_list", $category_list);

        return view('review');
    }

    public function info($id){
        $msg = $this->checkUser();
        if($msg != ""){
            $this->messageBag->add('email', $msg);
            return redirect("/")->withInput()->withErrors($this->messageBag);
        }

        $select = "*,getUserLevelIcon(user_id) level_icon";
        $info = ReviewBoard::select(DB::raw($select))->find($id);
        if(!isset($info['id'])){
            return redirect("review/1");
        }
        $info->addViewCount();
        view()->share("info", $info);
        $reply_list = ReviewBoardReply::getReplyList($id);
        view()->share("reply_list", $reply_list);
        $user = Sentinel::getuser();
        view()->share("user", $user);
        $this->getInfoList($id, isset($info['shop']['type'])?$info['shop']['type']:"0");
        $model = new Board();
        $recent_board_list = $model->getRecentBoardList(0,10);
        view()->share("recent_board_list",$recent_board_list);
        return view('review_info');
    }


    public function getInfoList($id, $shop_type){
        $pageParam = $this->getPageParam();
        $model = new ReviewBoard();
        $model = $model->leftjoin('shop', 'shop.id', '=', 'review_board.shop_id');
        $where = array();
        $where['shop.type']= $shop_type;
        $select = "review_board.*, shop.title shop_title, shop.img shop_img,getUserLevelIcon(review_board.user_id) level_icon";
        $whereRaw = "review_board.id<>{$id}";
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

    public function ajaxSaveReview(Request $request){
        $id = $this->getParam("id", "0");
        $info = ReviewBoard::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new ReviewBoard();
            $ret = $this -> getBoClass($info,$request, 'review_board');
            $info = $ret['model'];
        }

        $user = Sentinel::getuser();
        $info['user_id'] = $user['id'];
        $info->save();
        if($id*1 == 0){
            $model = new UserPointLog();
            $model->addRemoveUserPoint($user['id'],20,1);
        }
        return json_encode(array('status'=>1));
    }


    public function ajaxSaveReply(Request $request){
        $id = $this->getParam("id", "0");
        $info = ReviewBoardReply::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new ReviewBoardReply();
            $ret = $this -> getBoClass($info,$request, 'review_board_reply');
            $info = $ret['model'];
        }
        if($info['id']*1 == 0 && $info['parent_reply_id']*1  ==0){
            $review_info = ReviewBoard::find($info['board_id']);
            $review_info['reply_count'] = $review_info['reply_count']+1;
            $review_info->save();
        }

        $user = Sentinel::getuser();
        $info['user_id'] = $user['id'];
        $info->save();
        if($id*1 == 0){
            $model = new UserPointLog();
            $model->addRemoveUserPoint($user['id'],5,1);
        }
        return json_encode(array('status'=>1));
    }

    public function deleteReply(){
        $id = $this->getParam("id", "0");
        $reply_info = ReviewBoardReply::find($id);
        $user = Sentinel::getuser();
        if(isset($reply_info['id'])&& $reply_info['parent_reply_id']*1 == 0){
            $board_id = $reply_info['board_id'];
            $board_info = ReviewBoard::find($board_id);
            if($board_info['reply_count'] >= 1){
                $board_info['reply_count'] -= 1;
                $board_info->save();
            }
        }
        $whereRaw = "id = {$id} OR parent_reply_id = {$id}";
        ReviewBoardReply::whereRaw($whereRaw)->delete();

        $model = new UserPointLog();
        $model->addRemoveUserPoint($user['id'],5,0);

        return json_encode(array('status'=>1));
    }

    public function write($id, $shop_type){
        if($id*1 == 0){
            $info = new ReviewBoard();
        }else{
            $info = ReviewBoard::find($id);
            $user = Sentinel::getuser();
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
        view()->share("shop_type", $shop_type);
        $model = new Board();
        $recent_board_list = $model->getRecentBoardList(0,10);
        view()->share("recent_board_list",$recent_board_list);

        return view('review_board_write');
    }

    public function ajaxSaveInfo(Request $request){
        $id = $this->getParam("id", "0");
        $info = ReviewBoard::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new ReviewBoard();
            $ret = $this -> getBoClass($info,$request, 'review_board');
            $info = $ret['model'];
        }

        if($id*1 == 0){
            $user = Sentinel::getuser();
            $info['user_id'] = $user['id'];
        }

        $info->save();
        if($id*1 == 0){
            $model = new UserPointLog();
            $model->addRemoveUserPoint($user['id'],20,1);
        }
        return json_encode(array('status'=>1));
    }

    public function deleteInfo(){
        $user = Sentinel::getuser();
        $id = $this->getParam("id", "0");
        ReviewBoard::where(array("id"=>$id))->delete();
        $whereRaw = "board_id = {$id}";
        ReviewBoardReply::whereRaw($whereRaw)->delete();
        $model = new UserPointLog();
        $model->addRemoveUserPoint($user['id'],20,0);
        return json_encode(array('status'=>1));
    }

    public function getCategoryList(){
        $id = $this->getParam("id", "0");
        $shop_type = $this->getParam("shop_type", "0");
        $category_id = 0;
        if($id*1 > 0){
            $review_info = ReviewBoard::find($id);
            $category_id = $review_info['category_id'];
        }

        $model = new BoardCategory();
        $categoryList = $model->getCategoryChildList(2,$shop_type);
        view()->share("categoryList", $categoryList);
        view()->share("category_id", $category_id);
        return view("category_list");
    }
}
