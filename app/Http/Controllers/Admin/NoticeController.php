<?php namespace App\Http\Controllers\Admin;

/**
 * write king star
 */

use\App\Http\Controllers\JoshController;
use App\Http\Requests\ConfirmPasswordRequest;
use App\Manager;
use App\Notice;
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


class NoticeController extends JoshController
{

    public function index(Request $request){
        $user = Sentinel::getuser();
        if($user['type']*1 == 70){
            if($request->session()->get("is_first")*1==1){
                $notice_info = Notice::where(array("status"=>1))->first();
                view()->share("notice_info", $notice_info);
                $request->session()->put("is_first", "0");
            }
        }


        $pageParam = $this->getPageParam();
        $search = $this->getParam("search", "");
        view()->share('search', $search);



        $where = array();
        $model = new Notice();

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

        $user = Sentinel::getuser();
        view()->share("user", $user);

        return view('admin/notice/list');
    }

    public function info($id){
        view()->share("id", $id);
        if($id*1 > 0){
            $info = Notice::find($id);
            if(!isset($info['id'])){
                return redirect("admin/notice");
            }
        }else{
            $info = new Notice();
        }
        $user = Sentinel::getuser();
        view()->share("user", $user);
        view()->share("info", $info);
        return view("admin/notice/info");
    }


    public function ajaxSaveInfo(Request $request){
        $id = $this->getParam("id", "0");
        $info = Notice::find($id);

        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new Notice();
            $ret = $this -> getBoClass($info,$request, 'notice');
            $info = $ret['model'];
        }

        $is_always_display = $this->getParam("is_always_display", "0");
        if($is_always_display*1 == 1){
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

        Notice::whereRaw("FIND_IN_SET(id, '{$ids}')")->delete();
        return json_encode(array("status"=>"1"));
    }

    public function setBatchStatus(){
        $ids = $this->getParam("ids", "");
        if($ids == ""){
            return json_encode(array("status"=>"0", "msg"=> __("lang.항목을 선택하여 주십시오.")));
        }
        $status = $this->getParam("status", "0");
        Notice::whereRaw("FIND_IN_SET(id, '{$ids}')")->update(array("status"=>$status));
        return json_encode(array("status"=>"1"));
    }

}
