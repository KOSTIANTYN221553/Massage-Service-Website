<?php

namespace App\Http\Controllers;

use Activation;
use App\Board;
use App\BoardReply;
use App\EbzaBoard;
use App\EbzaBoardReply;
use App\Http\Requests;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\FrontendRequest;
use App\Notice;
use App\ReviewBoard;
use App\ReviewBoardReply;
use App\Schedule;
use App\Shop;
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


class NoticeController extends JoshController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $pageParam = $this->getPageParam(100);
        $search = $this->getParam("search", "");
        view()->share('search', $search);
        $where = array();
        $model = new Notice();
        $date = date("Y-m-d");
        $whereRaw = "((display_start_at <= '{$date}' AND display_end_at >= '{$date}' AND status = 1 ) OR is_always_display =1  ) AND type != 6 ";
        $model = $model->where($where);
        $select = "*";
        $model = $model->select(DB::raw($select));
        $model = $model->whereRaw($whereRaw);

        $count = $model->count();

        $model->orderBy("id", "desc");
        $model = $model->skip($pageParam["start"])->take($pageParam["perPageSize"]);
        $list = $model->get();
        $pageParam = $this->setPageParam($pageParam, $count);
        view()->share('pageParam', $pageParam);
        view()->share("list", $list);


        $model = new Board();
        $recent_board_list = $model->getRecentBoardList(0,10);
        view()->share("recent_board_list",$recent_board_list);

        $model = new Notice();
        $notice_list = $model->getNoticeList();
        view()->share("notice_list", $notice_list);
        getCurrentLang();
        view()->share("page_title", __("lang.회원센터")." > ".__("lang.공지사항"));

        return view('notice');
    }

    public function info($id){
        $msg = $this->checkUser();
        if($msg != ""){
            $this->messageBag->add('email', $msg);
            return redirect("/")->withInput()->withErrors($this->messageBag);
        }

        $info = Notice::find($id);
        if(!isset($info['id'])){
            return redirect("notice");
        }
        $this->getInfoList($id);

        view()->share("info", $info);
        $user = Sentinel::getuser();
        view()->share("user", $user);
        return view('notice_info');
    }

    public function getInfoList($id){
        $pageParam = $this->getPageParam();
        $search = $this->getParam("search", "");
        view()->share('search', $search);
        $where = array();
        $model = new Notice();
        $date = date("Y-m-d");
        $whereRaw = "((display_start_at <= '{$date}' AND display_end_at >= '{$date}' AND status = 1 ) OR is_always_display =1 )) AND id <> {$id} AND type != 6";
        $model = $model->where($where);
        $select = "*";
        $model = $model->select(DB::raw($select));
        $model = $model->whereRaw($whereRaw);
        $count = $model->count();
        $model->orderBy("id", "desc");
        $model = $model->skip($pageParam["start"])->take($pageParam["perPageSize"]);
        $list = $model->get();
        $pageParam = $this->setPageParam($pageParam, $count);
        view()->share('pageParam', $pageParam);
        view()->share("list", $list);
    }


}
