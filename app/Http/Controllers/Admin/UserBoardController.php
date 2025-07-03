<?php namespace App\Http\Controllers\Admin;

/**
 * write king star
 */

use App\Board;
use App\BoardReply;
use App\EbzaBoard;
use App\EbzaBoardReply;
use\App\Http\Controllers\JoshController;
use App\Http\Requests\ConfirmPasswordRequest;
use App\ShopType;
use App\UserBoard;
use App\UserBoardReply;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Mail;
use Reminder;
use Sentinel;
use URL;
use Validator;
use View;
use App\Http\Requests\UserRequest;
use App\Http\Requests\ForgotRequest;
use stdClass;
use App\Mail\ForgotPassword;
use Hash;
use Yajra\DataTables\DataTables;
use App\Shop;
use DB;


class UserBoardController extends JoshController
{
    public function index(){
        $pageParam = $this->getPageParam();
        $search = $this->getParam("search", "");
        view()->share('search', $search);

        $where = array();
        $model = new UserBoard();

        if($search != ''){
            $model = $model->whereRaw(" title LIKE '%".$search."%'");
        }


        $model = $model->where($where);
        $select = "*";
        $model = $model->select(DB::raw($select));


        $count = $model->count();
        $order_key = $this->getParam("order_key", "id");
        $order_val = $this->getParam("order_val", "ASC");


        view()->share("order_key", $order_key);
        view()->share("order_val", $order_val);
        $model->orderBy($order_key, $order_val);

        $model = $model->skip($pageParam["start"])->take($pageParam["perPageSize"]);
        $list = $model->get();
        $pageParam = $this->setPageParam($pageParam, $count);
        view()->share('pageParam', $pageParam);
        view()->share("list", $list);

        return view('admin/user_board/list');
    }

    public function info($id){
        view()->share("id", $id);
        if($id*1 > 0){
            $info = UserBoard::find($id);
            if(!isset($info['id'])){
                return redirect("admin/user_board");
            }
        }else{
            $info = new UserBoard();
        }
        view()->share("info", $info);
        return view("admin/user_board/info");
    }

    public function view($id){
        view()->share("id", $id);
        if($id*1 > 0){
            $info = UserBoard::find($id);
            if(!isset($info['id'])){
                return redirect("admin/user_board");
            }
        }else{
            return redirect("admin/user_board");
        }

        view()->share("info", $info);
        $reply_list = UserBoardReply::getReplyList($id);
        view()->share("reply_list", $reply_list);
        $user = Sentinel::getuser();
        view()->share("user", $user);
        return view("admin/user_board/view");
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

        if(!isset($info['user_id'])){
            $user = Sentinel::getuser();
            $info['user_id'] = $user['id'];
        }
        $info->save();
        return json_encode(array('status'=>1));
    }

    public function setBatchDelete(){
        $ids = $this->getParam("ids", "");
        if($ids == ""){
            return json_encode(array("status"=>"0", "msg"=> __("lang.항목을 선택하여 주십시오.")));
        }
        UserBoard::whereRaw("FIND_IN_SET(id, '{$ids}')")->delete();
        return json_encode(array("status"=>"1"));
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
        $info->save();
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
