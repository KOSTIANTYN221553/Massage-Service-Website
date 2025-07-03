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
use App\Question;
use App\QuestionReply;
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


class QuestionController extends JoshController
{


    public function index(){
        $filter_param = ['search_title'];
        $result = checkSQLInject($filter_param);
        if($result){
            return view("sql_inject");
        }
        
        $pageParam = $this->getPageParam(100);
        $search = $this->getParam("search", "");
        view()->share('search', $search);
        $where = array();
        $model = new Question();
        $whereRaw = "1=1";
        $user_id = 0;
        if(Sentinel::check()){
            $user = Sentinel::getuser();
            $user_id = $user['id'];
        }

        $where['user_id'] = $user_id;
        $search_type = $this->getParam("search_type", "");
        view()->share("search_type", $search_type);
        $search_title = $this->getParam("search_title", "");
        view()->share("search_title", $search_title);
        if($search_type != '' && $search_title != ''){
            if($search_type == "reply"){
                $whereRaw .= " AND isContainQuestionReply(id, '{$search_title}') = 1";
            }else if($search_type == 'title&content'){
                $whereRaw .= " AND title LIKE '%{$search_title}%' AND content LIKE '%{$search_title}%'";
            }else{
                $whereRaw .= " AND {$search_type} LIKE '%{$search_title}%'";
            }
        }

        $model = $model->whereRaw($whereRaw);

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

        return view('question');
    }

    public function info($id){
        $info = Question::find($id);
        if(!isset($info['id'])){
            return redirect("question");
        }
        $info->addViewCount();
        view()->share("info", $info);
        $reply_list = QuestionReply::getReplyList($id);
        view()->share("reply_list", $reply_list);
        $user = Sentinel::getuser();
        view()->share("user", $user);
        $this->getInfoList($id);
        $model = new Board();
        $recent_board_list = $model->getRecentBoardList(0,10);
        view()->share("recent_board_list",$recent_board_list);
        return view('question_info');
    }


    public function getInfoList($id){
        $pageParam = $this->getPageParam();
        $model = new Question();
        $where = array();
        $user_id = 0;
        if(Sentinel::check()){
            $user = Sentinel::getuser();
            $user_id = $user['id'];
        }
        $where['user_id'] = $user_id;
        $select = "*";
        $whereRaw = "id<>{$id}";
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

    public function ajaxSaveReview(Request $request){
        $id = $this->getParam("id", "0");
        $info = Question::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new Question();
            $ret = $this -> getBoClass($info,$request, 'question');
            $info = $ret['model'];
        }

        $user = Sentinel::getuser();
        $info['user_id'] = $user['id'];
        $info->save();
        return json_encode(array('status'=>1));
    }


    public function ajaxSaveReply(Request $request){
        $id = $this->getParam("id", "0");
        $info = QuestionReply::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new QuestionReply();
            $ret = $this -> getBoClass($info,$request, 'question_reply');
            $info = $ret['model'];
        }


        $user = Sentinel::getuser();
        $info['user_id'] = $user['id'];
        $info->save();
        return json_encode(array('status'=>1));
    }

    public function deleteReply(){
        $id = $this->getParam("id", "0");
        $whereRaw = "id = {$id} OR parent_reply_id = {$id}";
        QuestionReply::whereRaw($whereRaw)->delete();
        return json_encode(array('status'=>1));
    }

    public function write($id){
        if($id*1 == 0){
            $info = new Question();
        }else{
            $info = Question::find($id);
            if(!isset($info['id'])){
                return redirect("question");
            }
        }
        view()->share("id", $id);
        view()->share("info", $info);

        $model = new Board();
        $recent_board_list = $model->getRecentBoardList(0,10);
        view()->share("recent_board_list",$recent_board_list);
        return view('question_write');
    }



    public function deleteInfo(){
        $id = $this->getParam("id", "0");
        Question::where(array("id"=>$id))->delete();
        $whereRaw = "board_id = {$id}";
        QuestionReply::whereRaw($whereRaw)->delete();
        return json_encode(array('status'=>1));
    }

}
