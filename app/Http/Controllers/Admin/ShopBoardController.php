<?php namespace App\Http\Controllers\Admin;

/**
 * write king star
 */

use App\Board;
use App\BoardReply;
use App\BoardType;
use\App\Http\Controllers\JoshController;
use App\Http\Requests\ConfirmPasswordRequest;
use App\ShopBoard;
use App\ShopBoardReply;
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


class ShopBoardController extends JoshController
{


    public function index(){
        $pageParam = $this->getPageParam();
        $search = $this->getParam("search", "");
        view()->share('search', $search);
        $where = array();

        $model = new ShopBoard();

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

        return view('admin/shop_board/list');
    }

    public function info($id){
        view()->share("id", $id);
        if($id*1 > 0){
            $info = ShopBoard::find($id);
            if(!isset($info['id'])){
                return redirect("admin/shop_board");
            }
        }else{
            $info = new ShopBoard();
        }
        view()->share("info", $info);
        return view("admin/shop_board/info");
    }

    public function view($id){
        view()->share("id", $id);
        if($id*1 > 0){
            $info = ShopBoard::find($id);
            if(!isset($info['id'])){
                return redirect("admin/shop_board");
            }
        }else{
            return redirect("admin/shop_board");
        }

        view()->share("info", $info);
        $reply_list = ShopBoardReply::getReplyList($id);
        view()->share("reply_list", $reply_list);
        $user = Sentinel::getuser();
        view()->share("user", $user);
        return view("admin/shop_board/view");
    }


    public function ajaxSaveInfo(Request $request){
        $id = $this->getParam("id", "0");
        $info = ShopBoard::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new ShopBoard();
            $ret = $this -> getBoClass($info,$request, 'shop_board');
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
        $info->save();
        return json_encode(array('status'=>1));
    }

    public function setBatchDelete(){
        $ids = $this->getParam("ids", "");
        if($ids == ""){
            return json_encode(array("status"=>"0", "msg"=> __("lang.항목을 선택하여 주십시오.")));
        }
        $whereRaw = "FIND_IN_SET(id, '{$ids}')";
        $user = Sentinel::getuser();
        if($user['type']*1 == 70){
            $whereRaw .= " AND user_id = {$user['id']}" ;
        }
        $del_list = ShopBoard::whereRaw("FIND_IN_SET(id, '{$ids}')") -> get();
        ShopBoard::whereRaw($whereRaw)->delete();
        foreach($del_list as $board_info){
            if(isset($board_info['id'])){
                if(isset($board_info['id'])){
                    if($board_info['img'] != ''){
                        unlink(realpath($board_info['img']));
                    }
                }
            }
        }
        return json_encode(array("status"=>"1"));
    }

    public function ajaxSaveReply(Request $request){
        $id = $this->getParam("id", "0");
        $info = ShopBoardReply::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new ShopBoardReply();
            $ret = $this -> getBoClass($info,$request, 'shop_board_reply');
            $info = $ret['model'];
        }
        if($info['id']*1 == 0 && $info['parent_reply_id']*1  ==0){
            $review_info = ShopBoard::find($info['board_id']);
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
        $reply_info = ShopBoardReply::find($id);
        if(isset($reply_info['id'])&& $reply_info['parent_reply_id']*1 == 0){
            $board_id = $reply_info['board_id'];
            $board_info = ShopBoard::find($board_id);
            if($board_info['reply_count'] >= 1){
                $board_info['reply_count'] -= 1;
                $board_info->save();
            }
        }
        $whereRaw = "id = {$id} OR parent_reply_id = {$id}";
        ShopBoardReply::whereRaw($whereRaw)->delete();
        return json_encode(array('status'=>1));
    }


}
