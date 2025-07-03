<?php namespace App\Http\Controllers\Admin;

/**
 * write king star
 */

use App\Certification;
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


class CertificationController extends JoshController
{

    public function index(){
        $pageParam = $this->getPageParam();
        $search = $this->getParam("search", "");
        view()->share('search', $search);

        $search_key_type = $this->getParam("search_key_type", "shop.title");
        view()->share("search_key_type",$search_key_type);
        $where = array();
        $model = new Certification();
        $model = $model->leftjoin('user', 'user.id', '=', 'certification.user_id');
        $model = $model->leftjoin('shop', 'shop.id', '=', 'certification.shop_id');

        $whereRaw = " 1=1 ";
        if($search != ''){
            $model = $model->whereRaw("{$search_key_type} LIKE '%".$search."%'");
        }
        $filter_status = $this->getParam("filter_status", "-99");
        if($filter_status *1 != -99){
            $where['shop.status'] = $filter_status;
        }
        view()->share("filter_status", $filter_status);

        $filter_date = $this->getParam("filter_date", "display");
        view()->share("filter_date", $filter_date);
        $fromDate = $this->getParam("fromDate", "");
        view()->share("fromDate", $fromDate);
        $toDate = $this->getParam("toDate", "");
        view()->share("toDate", $toDate);

        $date_key = "shop.created_at";
        if($filter_date == "updated"){
            $date_key = "shop.updated_at";
        }

        if($fromDate != ""){
            $whereRaw .= " AND date({$date_key}) >= '{$fromDate}'";
        }

        if($toDate != ""){
            $whereRaw .= " AND date({$date_key}) <= '{$toDate}'";
        }

        $model = $model->where($where);
        $select = "shop.*,user.nickname, shop_type.title shop_type_title";
        $model = $model->select(DB::raw($select));
        $model = $model->whereRaw($whereRaw);

        $count = $model->count();
        $order_key = $this->getParam("order_key", "shop.id");
        $order_val = $this->getParam("order_val", "ASC");
        view()->share("order_key", $order_key);
        view()->share("order_val", $order_val);
        $model->orderBy($order_key, $order_val);
        $model = $model->skip($pageParam["start"])->take($pageParam["perPageSize"]);
        $list = $model->get();
        $pageParam = $this->setPageParam($pageParam, $count);
        view()->share('pageParam', $pageParam);
        view()->share("list", $list);

        return view('admin/shop/shops');
    }

    public function info($id){
        view()->share("id", $id);
        if($id*1 > 0){
            $info = Shop::find($id);
            if(!isset($info['id'])){
                return redirect("admin/shops");
            }
        }else{
            $info = new Shop();
        }
        $shop_type_list = ShopType::all();
        view()->share("shop_type_list", $shop_type_list);
        view()->share("info", $info);
        return view("admin/shop/shop_detail");
    }

    public function setBatchStatus(){
        $ids = $this->getParam("ids", "");
        if($ids == ""){
            return json_encode(array("status"=>"0", "msg"=> __("lang.항목을 선택하여 주십시오.")));
        }
        $status = $this->getParam("status", "0");
        Shop::whereRaw("FIND_IN_SET(id, '{$ids}')")->update(array("status"=>$status));
        return json_encode(array("status"=>"1"));
    }

    public function ajaxSaveInfo(Request $request){
        $id = $this->getParam("id", "0");
        $info = Shop::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new Shop();
            $ret = $this -> getBoClass($info,$request, 'shop');
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
        Shop::whereRaw("FIND_IN_SET(id, '{$ids}')")->delete();
        return json_encode(array("status"=>"1"));
    }




}
