<?php namespace App\Http\Controllers\Admin;

/**
 * write king star
 */

use\App\Http\Controllers\JoshController;
use App\Http\Requests\ConfirmPasswordRequest;
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


class ShopTypeController extends JoshController
{

    public function index(Request $request){
        $pageParam = $this->getPageParam();
        $search = $this->getParam("search", "");
        view()->share('search', $search);
        if($request->session()->get("is_first")*1==1){
            $date = date("Y-m-d");
            $whereRaw = "((display_start_at <= '{$date}' AND display_end_at >= '{$date}' AND status = 1) OR is_always_display =1 ) AND type = 6 ";
            $notice_info = Notice::whereRaw($whereRaw)->first();
            view()->share("notice_info", $notice_info);
            $request->session()->put("is_first", "0");
        }

        $where = array();
        $model = new ShopType();

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

        return view('admin/shop_type/list');
    }

    public function info($id){
        view()->share("id", $id);
        if($id*1 > 0){
            $info = ShopType::find($id);
            if(!isset($info['id'])){
                return redirect("admin/shop_type");
            }
        }else{
            $info = new ShopType();
        }
        view()->share("info", $info);
        return view("admin/shop_type/info");
    }


    public function ajaxSaveInfo(Request $request){
        $id = $this->getParam("id", "0");
        $info = ShopType::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new ShopType();
            $ret = $this -> getBoClass($info,$request, 'shop_type');
            $info = $ret['model'];
        }
        $info->save();
        return json_encode(array('status'=>1));
    }

    public function setBatchDelete(){
        $ids = $this->getParam("ids", "");
        if($ids == ""){
            return json_encode(array("status"=>"0", "msg"=> __("lang.항목을 선택하여 주십시오.")));
        }
        $ret = ShopType::isDelete($ids);
        if($ret['status']*1 == 0){
            return json_encode($ret);
        }
        ShopType::whereRaw("FIND_IN_SET(id, '{$ids}')")->delete();
        return json_encode(array("status"=>"1"));
    }

}
