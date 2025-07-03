<?php

namespace App\Http\Controllers;

use Activation;
use App\Board;
use App\BoardReply;
use App\Http\Requests;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\FrontendRequest;
use App\ReviewBoard;
use App\Schedule;
use App\ShopType;
use App\User;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
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


class HomeController extends JoshController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $schedule_type = $this->getParam("schedule_type", "0");
        $shop_type_list = ShopType::getShopTypeList1();
        if($schedule_type*1 == 0){
            $schedule_type = $shop_type_list[0]['id'];
        }
        $schedule_model = new Schedule();
        //$schedule_recent_list = $schedule_model->recentScheduleList($schedule_type);
        $schedule_recent_list = $schedule_model->recentScheduleListWithTypeList($shop_type_list);
        view()->share("schedule_type",$schedule_type);
        view()->share("schedule_recent_list", $schedule_recent_list);


        foreach($shop_type_list as $key => $shop_type){
            $model = new ReviewBoard();
            $recent_list = $model->getRecentBoardList($shop_type['id']);
            $shop_type_list[$key]['recent_list'] = $recent_list;
            $favorite_list = $model->getFavoriteBoardList($shop_type['id']);
            $shop_type_list[$key]['favorite_list'] = $favorite_list;
        }
        view()->share("shop_type_list", $shop_type_list);

        $board_type_list = getHomeBoardTypeList();
        $board_type_list1 = array();
        foreach($board_type_list as $key => $item){
            $ele = array();
            $ele['title'] = $item;
            $model = new Board();
            $ele['list'] = $model->getRecentBoardList($key);
            array_push($board_type_list1,$ele);
        }
        view()->share("board_type_list",$board_type_list1);
        $model = new Board();
        $recent_board_list = $model->getRecentBoardList(0,10);
        view()->share("recent_board_list",$recent_board_list);
        return view('index');
    }

    public function login_user(){
        return view("login_user");
    }

    public function setLang(Request $request){
        $lang = $request->input("lang","vn");
        $session = $request->session();
        $session->put("lang", $lang);
        App::setLocale($lang);
        return json_encode(array("status"=>"1","msg"=>"성공하였습니다."));
    }





}
