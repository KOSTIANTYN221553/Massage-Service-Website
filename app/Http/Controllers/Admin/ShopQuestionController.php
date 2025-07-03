<?php namespace App\Http\Controllers\Admin;

/**
 * write king star
 */

use App\Board;
use\App\Http\Controllers\JoshController;
use App\Http\Requests\ConfirmPasswordRequest;
use App\Question;
use App\QuestionReply;
use App\ReviewBoard;
use App\ReviewBoardReply;
use App\ShopQuestion;
use App\ShopQuestionReply;
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


class ShopQuestionController extends JoshController
{


    public function index(){
        $pageParam = $this->getPageParam();
        $search = $this->getParam("search", "");
        view()->share('search', $search);

        $where = array();
        $model = new ShopQuestion();
        $user = Sentinel::getuser();

        if($search != ''){
            $model = $model->whereRaw(" title LIKE '%".$search."%'");
        }

        if($user['type']*1 == 70){
            $where['user_id'] = $user['id'];
        }


        $model = $model->where($where);
        $select = "shop_question.*,user.nickname user_nickname";
        $model = $model->join("user", "shop_question.user_id","=","user.id");
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

        return view('admin/shop_question/list');
    }

    public function info($id){
        view()->share("id", $id);
        if($id*1 > 0){
            $info = ShopQuestion::find($id);
            if(!isset($info['id'])){
                return redirect("admin/shop_question");
            }
        }else{
            $info = new ShopQuestion();
        }
        view()->share("info", $info);
        $reply_list = ShopQuestionReply::getReplyList($id);
        view()->share("reply_list", $reply_list);
        $user = Sentinel::getuser();
        view()->share("user", $user);
        return view("admin/shop_question/info");
    }

    public function view($id){
        view()->share("id", $id);
        if($id*1 > 0){
            $info = ShopQuestion::find($id);
            if(!isset($info['id'])){
                return redirect("admin/shop_question");
            }
        }else{
            return redirect("admin/shop_question");
        }

        view()->share("info", $info);
        $reply_list = ShopQuestionReply::getReplyList($id);
        view()->share("reply_list", $reply_list);
        $user = Sentinel::getuser();
        view()->share("user", $user);
        return view("admin/shop_question/view");
    }


    public function ajaxSaveInfo(Request $request){
        $id = $this->getParam("id", "0");
        $info = ShopQuestion::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new ShopQuestion();
            $ret = $this -> getBoClass($info,$request, 'shop_question');
            $info = $ret['model'];
        }
        if($id*1 == 0){
            $user = Sentinel::getuser();
            $info['user_id'] = $user['id'];
        }
        if($info['answer'] != ''){
            $info['status'] = 1;
        }
        $info->save();
        return json_encode(array('status'=>1));
    }

    public function setBatchDelete(){
        $ids = $this->getParam("ids", "");
        if($ids == ""){
            return json_encode(array("status"=>"0", "msg"=> __("lang.항목을 선택하여 주십시오.")));
        }
        ShopQuestion::whereRaw("FIND_IN_SET(id, '{$ids}')")->delete();
        return json_encode(array("status"=>"1"));
    }

    public function ajaxSaveReply(Request $request){
        $id = $this->getParam("id", "0");
        $info = ShopQuestionReply::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new ShopQuestionReply();
            $ret = $this -> getBoClass($info,$request, 'question_reply');
            $info = $ret['model'];
        }


        $user = Sentinel::getuser();
        $info['user_id'] = $user['id'];
        $info->save();
        return json_encode(array('status'=>1));
    }

    public function deleteReply(){
        $id = $this->getParam("id", "0");
        $reply_info = ShopQuestionReply::find($id);
        if(isset($reply_info['id'])&& $reply_info['parent_reply_id']*1 == 0){
            $board_id = $reply_info['board_id'];
            $board_info = ShopQuestion::find($board_id);
            if($board_info['reply_count'] >= 1){
                $board_info['reply_count'] -= 1;
                $board_info->save();
            }
        }
        $whereRaw = "id = {$id} OR parent_reply_id = {$id}";
        ShopQuestionReply::whereRaw($whereRaw)->delete();
        return json_encode(array('status'=>1));
    }

}
