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


class EbzaBoardController extends JoshController
{
    public function index(){
        $pageParam = $this->getPageParam();
        $search = $this->getParam("search", "");
        view()->share('search', $search);

        $where = array();
        $model = new EbzaBoard();

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

        return view('admin/ebza_board/list');
    }

    public function info($id){
        view()->share("id", $id);
        if($id*1 > 0){
            $info = EbzaBoard::find($id);
            if(!isset($info['id'])){
                return redirect("admin/ebza_board");
            }
        }else{
            $info = new EbzaBoard();
        }
        view()->share("info", $info);
        return view("admin/ebza_board/info");
    }

    public function view($id){
        view()->share("id", $id);
        if($id*1 > 0){
            $info = EbzaBoard::find($id);
            if(!isset($info['id'])){
                return redirect("admin/ebza_board");
            }
        }else{
            return redirect("admin/ebza_board");
        }

        view()->share("info", $info);
        $reply_list = EbzaBoardReply::getReplyList($id);
        view()->share("reply_list", $reply_list);
        $user = Sentinel::getuser();
        view()->share("user", $user);
        return view("admin/ebza_board/view");
    }


    public function ajaxSaveInfo(Request $request){
        $id = $this->getParam("id", "0");
        $info = EbzaBoard::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new EbzaBoard();
            $ret = $this -> getBoClass($info,$request, 'ebza_board');
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
        EbzaBoard::whereRaw("FIND_IN_SET(id, '{$ids}')")->delete();
        return json_encode(array("status"=>"1"));
    }

    public function ajaxSaveReply(Request $request){
        $id = $this->getParam("id", "0");
        $info = EbzaBoardReply::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new EbzaBoardReply();
            $ret = $this -> getBoClass($info,$request, 'ebza_board_reply');
            $info = $ret['model'];
        }
        if($info['id']*1 == 0 && $info['parent_reply_id']*1  ==0){
            $review_info = EbzaBoard::find($info['board_id']);
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
        $reply_info = EbzaBoardReply::find($id);
        if(isset($reply_info['id'])&& $reply_info['parent_reply_id']*1 == 0){
            $board_id = $reply_info['board_id'];
            $board_info = EbzaBoard::find($board_id);
            if($board_info['reply_count'] >= 1){
                $board_info['reply_count'] -= 1;
                $board_info->save();
            }
        }
        $whereRaw = "id = {$id} OR parent_reply_id = {$id}";
        EbzaBoardReply::whereRaw($whereRaw)->delete();
        return json_encode(array('status'=>1));
    }


}
