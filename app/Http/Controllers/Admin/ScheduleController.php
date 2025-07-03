<?php namespace App\Http\Controllers\Admin;

/**
 * write king star
 */

use App\BoardCategory;
use\App\Http\Controllers\JoshController;
use App\Http\Requests\ConfirmPasswordRequest;
use App\Manager;
use App\Schedule;
use App\ScheduleDetail;
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


class ScheduleController extends JoshController
{

    public function index(){
        $pageParam = $this->getPageParam();
        $search = $this->getParam("search", "");
        view()->share('search', $search);

        $search_key_type = $this->getParam("search_key_type", "schedule.title");
        view()->share("search_key_type",$search_key_type);
        $where = array();
        $model = new Schedule();
        $model = $model->leftjoin('shop', 'shop.id', '=', 'schedule.shop_id');

        $user = Sentinel::getuser();
        $where['shop.user_id'] = $user['id'];
        $whereRaw = "1=1";
        if($search != ''){
            $model = $model->whereRaw("{$search_key_type} LIKE '%".$search."%'");
        }
        $filter_status = $this->getParam("filter_status", "-99");
        if($filter_status *1 != -99){
            $where['schedule.status'] = $filter_status;
        }
        view()->share("filter_status", $filter_status);

        $filter_date = $this->getParam("filter_date", "display");
        view()->share("filter_date", $filter_date);
        $fromDate = $this->getParam("fromDate", "");
        view()->share("fromDate", $fromDate);
        $toDate = $this->getParam("toDate", "");
        view()->share("toDate", $toDate);

        $date_key = "schedule.created_at";
        if($filter_date == "updated"){
            $date_key = "schedule.updated_at";
        }

        if($fromDate != ""){
            $whereRaw .= " AND date({$date_key}) >= '{$fromDate}'";
        }

        if($toDate != ""){
            $whereRaw .= " AND date({$date_key}) <= '{$toDate}'";
        }

        $model = $model->where($where);
        $now = date("Y-m-d");
        $select = "schedule.*, shop.title shop_title, isShopComplete(shop.id, '{$now}') is_complete";
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

        return view('admin/schedule/list');
    }

    public function info($id){
        view()->share("id", $id);
        if($id*1 > 0){
            $info = Schedule::find($id);
            if(!isset($info['id'])){
                return redirect("admin/schedule");
            }
            $where = array();
            $where['schedule_id'] = $id;
            $detail_list = ScheduleDetail::where($where)->get();
            $info['detail_list'] = $detail_list;

        }else{
            $info = new Schedule();
        }
        $user = Sentinel::getuser();
        $shop_list = Shop::getShopList($user['id']);
        view()->share("shop_list", $shop_list);
        view()->share("info", $info);
        return view("admin/schedule/info");
    }

    public function getManagerList(){
        $shop_id = $this->getParam("shop_id", "0");
        $where = array();
        $where['shop_id'] = $shop_id;
        $manager_list = Manager::where($where)->get();
        view()->share("manager_list", $manager_list);
        return view("admin/schedule/manager_list");
    }

    public function setBatchStatus(){
        $ids = $this->getParam("ids", "");
        if($ids == ""){
            return json_encode(array("status"=>"0", "msg"=> __("lang.항목을 선택하여 주십시오.")));
        }
        $status = $this->getParam("status", "0");
        Schedule::whereRaw("FIND_IN_SET(id, '{$ids}')")->update(array("status"=>$status));
        return json_encode(array("status"=>"1"));
    }

    public function ajaxSaveInfo(Request $request){
        $id = $this->getParam("id", "0");
        $info = Schedule::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new Schedule();
            $ret = $this -> getBoClass($info,$request, 'schedule');
            $info = $ret['model'];
            $info['status'] = 1;
        }
        $info['created_at'] = date("Y-m-d H:i:s");
        $info['is_force_end'] = 0;
        $info->save();
        $schedule_id = $info['id'];
        $detail_list = $this->getParam("detail_list", "");
        $ids = "";
        if($detail_list != ""){
            if($detail_list =="-1"){
                $where = array();
                $where['schedule_id'] = $schedule_id;
                ScheduleDetail::where($where)->delete();
            }else{
                $detail_list = json_decode($detail_list, 1);
                foreach($detail_list as $item){
                    $id = $item['id'];
                    $ids .= (""==$ids? "":",").$id;
                }
                $whereRaw = "!FIND_IN_SET(id, '{$ids}') AND schedule_id = {$schedule_id}";
                $model = new ScheduleDetail();
                $model->whereRaw($whereRaw)->delete();

                foreach($detail_list as $item){
                    $id = $item['id'];
                    $ids .= (""==$ids? "":",").$id;
                    if($id*1 < 0){
                        $scheduleDetail = new ScheduleDetail();
                        $scheduleDetail['schedule_id'] = $schedule_id;
                    }else{
                        $scheduleDetail = ScheduleDetail::find($id);
                        if(!isset($scheduleDetail['id'])){
                            continue;
                        }
                    }
                    $scheduleDetail['manager_id'] = $item['manager_id'];
                    $scheduleDetail['schedule_end_at'] = $item['schedule_end_at'];
                    $scheduleDetail['schedule_start_at'] = $item['schedule_start_at'];
                    $scheduleDetail->save();
                }


            }
        }
        return json_encode(array('status'=>1));
    }

    public function setBatchDelete(){
        $ids = $this->getParam("ids", "");
        if($ids == ""){
            return json_encode(array("status"=>"0", "msg"=> __("lang.항목을 선택하여 주십시오.")));
        }
        Schedule::whereRaw("FIND_IN_SET(id, '{$ids}')")->delete();
        return json_encode(array("status"=>"1"));
    }

    public function getCategoryList(){
        $id = $this->getParam("id", "0");
        $shop_id = $this->getParam("shop_id", "0");
        $category_id = 0;
        if($id*1 > 0){
            $schedule_info = Schedule::find($id);
            $category_id = $schedule_info['category_id'];

        }
        $shop_info = Shop::find($shop_id);
        $shop_type = $shop_info['type'];

        $model = new BoardCategory();
        $categoryList = $model->getCategoryChildList(1,$shop_type);
        view()->share("categoryList", $categoryList);
        view()->share("category_id", $category_id);
        return view("admin/schedule/category_list");
    }






}
