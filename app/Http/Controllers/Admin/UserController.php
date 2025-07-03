<?php namespace App\Http\Controllers\Admin;

/**
 * write king star
 */

use\App\Http\Controllers\JoshController;
use App\Http\Requests\ConfirmPasswordRequest;
use App\Manager;
use App\ShopType;
use App\User;
use App\UserLevel;
use App\UserPointLog;
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


class UserController extends JoshController
{

    public function index(){
        $pageParam = $this->getPageParam(100);
        $search = $this->getParam("search", "");
        view()->share('search', $search);
        $filter_status = $this->getParam("filter_status", "0");
        view()->share('filter_status', $filter_status);

        $filter_type = $this->getParam("filter_type", "0");
        view()->share('filter_type', $filter_type);

        $where = array();
        if($filter_type*1 != 0){
            $where['type'] = $filter_type;
        }

        if($filter_status *1 != 0){
            $where['status'] = $filter_status;
        }
        $model = new User();

        $search_key_type = $this->getParam("search_key_type", "email");
        if($search != ''){
            $model = $model->whereRaw(" {$search_key_type} LIKE '%".$search."%'");
        }
        view()->share("search_key_type", $search_key_type);

        $whereRaw = " id > 1 ";

        $model = $model->where($where);
        $select = "*";
        $model = $model->select(DB::raw($select));
        $model = $model->whereRaw($whereRaw);

        $count = $model->count();
        $order_key = $this->getParam("order_key", "id");
        $order_val = $this->getParam("order_val", "ASC");

        view()->share("order_key", $order_key);
        view()->share("order_val", $order_val);
        $model->orderBy($order_key, $order_val);

        $model = $model->skip($pageParam["start"])->take($pageParam["perPageSize"]);
        $list = $model->get();
        $pageParam = $this->setPageParam($pageParam, $count);
        view()->share("totalCount", $count);
        view()->share('pageParam', $pageParam);
        view()->share("list", $list);

        return view('admin/user/list');
    }

    public function info($id){
        view()->share("id", $id);
        if($id*1 > 0){
            $info = User::select(DB::raw("*, getUserBoardCount(id) board_cnt, getUserBoardReplyCount(id) reply_cnt "))->find($id);
            if(!isset($info['id'])){
                return redirect("admin/user");
            }
        }else{
            $info = new ShopType();
        }
        view()->share("info", $info);

        $user_level_list = UserLevel::get();
        view()->share("user_level_list", $user_level_list);
        return view("admin/user/info");
    }


    public function ajaxSaveInfo(Request $request){
        $id = $this->getParam("id", "0");
        $info = User::find($id);
        $password = $this->getParam("password", "");
        if(isset($info['id'])){
            $old_level_id = $info['level_id'];
            $this->getBoClass($info, $request);
        }else{
            $info = new User();
            $ret = $this -> getBoClass($info,$request, 'user');
            $info = $ret['model'];
            $info['user_point'] = 100;
            $info['visit_cnt'] = 0;
            $info['level_id'] = 1;
            $level_id = $info['level_id'];
        }

        if($password == ""){
            $password = $info['password'];
        }else{
            $password = Hash::make($password);;
        }

        $info['password'] = $password;


        $ret = User::checkUser($info);
        if($ret['status']*1 == 0){
            return json_encode($ret);
        }
        $img = $request->get("photo_url_val","");
        if($img != '' && 0 !== strpos($img, 'http')){
            $img = $this->genImage($img);
            if($img === "-1"){
                return json_encode(array('status'=>"0", "msg"=> __("lang.이미지 파일을 업로드 해주십시오.")));
            }
            $info['photo_url'] = $img;
        }

        $level_id = $this->getParam("level_id", "0");
        $model = new UserPointLog();
        if(!$model->checkUserLevel($info['id'], $level_id)){
           return json_encode(array("status"=>0, "msg"=>__("lang.계급기준이 만족하지 않으므로 계급을 갱신할수 없습니다.")));
        }
        $info->save();
        $model = new UserPointLog();
        $model->updateUserLevel_force($info['id']);
        return json_encode(array('status'=>1));
    }

    public function setBatchDelete(){
        $ids = $this->getParam("ids", "");
        if($ids == ""){
            return json_encode(array("status"=>"0", "msg"=> __("lang.항목을 선택하여 주십시오.")));
        }
        $del_list = User::whereRaw("FIND_IN_SET(id, '{$ids}')") -> get();
        User::whereRaw("FIND_IN_SET(id, '{$ids}')")->delete();
        foreach($del_list as $board_info){
            if(isset($board_info['id'])){
                if(isset($board_info['id'])){
                    if($board_info['photo_url'] != ''){
                        unlink(realpath($board_info['photo_url']));
                    }
                }
            }
        }
        return json_encode(array("status"=>"1"));
    }

}
