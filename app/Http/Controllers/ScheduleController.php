<?php

namespace App\Http\Controllers;

use Activation;
use App\Board;
use App\BoardCategory;
use App\BoardReply;
use App\Http\Requests;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\FrontendRequest;
use App\ReviewBoard;
use App\Schedule;
use App\ScheduleDetail;
use App\ShopType;
use App\User;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use File;
use Hash;
use Illuminate\Http\Request;
use Mail;
use Redirect;
use Reminder;
use Validator;
use Sentinel;
use URL;
use View;
use stdClass;
use App\Mail\Contact;
use App\Mail\ForgotPassword ;
use DB;


class ScheduleController extends JoshController
{
    public function __construct()
    {
        parent::__construct();
    }


    public function index($shop_type){
        $category_id = $this -> getParam("category_id", "0");
        view()->share("category_id", $category_id);
        $search = $this->getParam("search", "");
        view()->share('search', $search);
        $where = array();
        $where['shop.type']= $shop_type;
        $model = new Schedule();
        $model = $model->leftjoin('shop', 'shop.id', '=', 'schedule.shop_id');
        $now = date("Y-m-d");
        $whereRaw = "schedule.status = 1 AND isShopComplete(shop.id, '{$now}') = 1";
        $model = $model->where($where);
        $select = "schedule.*, shop.title shop_title, shop.img shop_img, getCategoryName(schedule.category_id) categoryName, shop.user_id";
        $model = $model->select(DB::raw($select));
        if($category_id*1 != 0){
            $whereRaw .= " AND schedule.category_id = {$category_id}";
        }
        $model = $model->whereRaw($whereRaw);

        $model->orderBy("updated_at", "desc");
        $list = $model->get();
        view()->share("list", $list);

        view()->share("shop_type", $shop_type);
        $model = new Board();
        $recent_board_list = $model->getRecentBoardList(0,10);
        view()->share("recent_board_list",$recent_board_list);
        $shop_type_title = getShopTypeTitle($shop_type);
        getCurrentLang();
        view()->share("page_title", __("lang.업소스케쥴")." > ".$shop_type_title);
        view()->share("shop_type_title", $shop_type_title);

        $model = new BoardCategory();
        $category_list = $model->getCategoryList('1', $shop_type);
        view()->share("category_list", $category_list);

        return view('schedule');
    }

    public function info($id){
        $msg = $this->checkUser();
        if($msg != ""){
            $this->messageBag->add('email', $msg);
            return redirect("/")->withInput()->withErrors($this->messageBag);
        }
        $info = Schedule::find($id);
        if(!isset($info['id'])){
            return redirect("schedule");
        }
        $info->addViewCount();
        $where = array();
        $where['schedule_id'] = $id;
        $detail_list = ScheduleDetail::where($where)->get();
        $info['detail_list'] = $detail_list;
        view()->share("info", $info);

        $this->getInfoList($id, isset($info['shop']['type'])?$info['shop']['type']:"0");
        $model = new Board();
        $recent_board_list = $model->getRecentBoardList(0,10);
        view()->share("recent_board_list",$recent_board_list);
        return view('schedule_info');
    }

    public function getInfoList($id, $shop_type){
        $pageParam = $this->getPageParam();
        $model = new Schedule();
        $model = $model->leftjoin('shop', 'shop.id', '=', 'schedule.shop_id');
        $where = array();
        $where['shop.type']= $shop_type;
        $select = "schedule.*, shop.title shop_title, shop.img shop_img";
        $whereRaw = "schedule.id<>{$id}";
        $model = $model -> whereRaw($whereRaw);
        $model = $model->where($where);
        $model = $model->select(DB::raw($select));
        $count = $model->count();
        $model = $model->skip($pageParam["start"])->take($pageParam["perPageSize"]);
        $list = $model->get();
        $pageParam = $this->setPageParam($pageParam, $count);
        view()->share('pageParam', $pageParam);
        view()->share("list", $list);
    }

    public function schedule_force_complete(Request $request){
        $user = Sentinel::getuser();
        $shop_type = $request->input("shop_type","0");
        $category_id = $request->input("category_id","0");
        $select = "schedule.id";
        $whereRaw = "shop.user_id = {$user['id']} AND shop.type = {$shop_type}";
        if($category_id != "0"){
            $whereRaw .= " AND schedule.category_id = {$category_id}";
        }
        $id_list = Schedule::join("shop","schedule.shop_id","=","shop.id")->whereRaw($whereRaw)->select(DB::raw($select))->get();
        if(count($id_list) == 0){
            return json_encode(array("status"=>"0","msg"=>__("lang.정보가 정확하지 않습니다.")));
        }
        foreach($id_list as $item){
            Schedule::whereRaw("id={$item['id']}")->update(array("is_force_end"=>"1"));
        }
        return json_encode(array("status"=>"1","msg"=>"성공하였습니다."));
    }


}
