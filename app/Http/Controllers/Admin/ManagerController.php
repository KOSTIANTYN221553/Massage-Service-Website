<?php namespace App\Http\Controllers\Admin;

/**
 * write king star
 */

use\App\Http\Controllers\JoshController;
use App\Http\Requests\ConfirmPasswordRequest;
use App\Manager;
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


class ManagerController extends JoshController
{

    public function index(){
        $pageParam = $this->getPageParam();
        $search = $this->getParam("search", "");
        view()->share('search', $search);

        $where = array();
        $model = new Manager();

        if($search != ''){
            $model = $model->whereRaw(" manager.nickname LIKE '%".$search."%'");
        }
        $model = $model->leftjoin('shop', 'shop.id', '=', 'manager.shop_id');
        $user = Sentinel::getuser();
        $where['shop.user_id'] = $user['id'];
        $model = $model->where($where);
        $select = "manager.*, shop.title shop_title";
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

        return view('admin/manager/list');
    }

    public function info($id){
        view()->share("id", $id);
        if($id*1 > 0){
            $info = Manager::find($id);
            if(!isset($info['id'])){
                return redirect("admin/manager");
            }
        }else{
            $info = new ShopType();
        }
        $user = Sentinel::getuser();
        $shop_list = Shop::getShopList($user['id']);
        view()->share("shop_list", $shop_list);
        view()->share("info", $info);
        return view("admin/manager/info");
    }


    public function ajaxSaveInfo(Request $request){
        $id = $this->getParam("id", "0");
        $info = Manager::find($id);

        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new Manager();
            $ret = $this -> getBoClass($info,$request, 'manager');
            $info = $ret['model'];
        }

        $img = $request->get("photo_url_val","");
        if($img != '' && 0 !== strpos($img, 'http')){
            $img = $this->genImage($img);
            if($img === "-1"){
                return json_encode(array('status'=>"0", "msg"=> __("lang.이미지 파일을 업로드 해주십시오.")));
            }
            $info['photo_url'] = $img;
        }

        $info->save();
        return json_encode(array('status'=>1));
    }

    public function setBatchDelete(){
        $ids = $this->getParam("ids", "");
        if($ids == ""){
            return json_encode(array("status"=>"0", "msg"=> __("lang.항목을 선택하여 주십시오.")));
        }
        $del_list = Manager::whereRaw("FIND_IN_SET(id, '{$ids}')") -> get();
        Manager::whereRaw("FIND_IN_SET(id, '{$ids}')")->delete();
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
