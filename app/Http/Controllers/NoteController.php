<?php namespace App\Http\Controllers;

/**
 * write king star
 */

use App\Advice;
use App\AdviceReply;
use App\Board;
use\App\Http\Controllers\JoshController;
use App\Http\Requests\ConfirmPasswordRequest;
use App\Note;
use App\ReviewBoard;
use App\ReviewBoardReply;
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



class NoteController extends JoshController
{

    public function note_send_dlg_content(){
        $user_id = $this->getParam("user_id", "0");
        $user_info = User::find($user_id);
        view()->share("user_info", $user_info);
        view()->share("user_id", $user_id);
        return view("dlg/note_send_dlg_content");
    }

    public function ajaxSaveInfo(Request $request){
        $id = $this->getParam("id", "0");
        $user = Sentinel::getuser();
        $info = Note::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new Note();
            $ret = $this -> getBoClass($info,$request, 'note');
            $info = $ret['model'];
        }

        if($id*1 == 0){
            $info['send_user_id'] = $user['id'];
            $info['send_nickname'] = $user['nickname'];
            $info['send_date'] = date('Y-m-d H:i:s');
        }
        $info->save();
        return json_encode(array('status'=>1));
    }


    public function note_del(){
        $id = $this->getParam("id", "0");
        Note::where(array("id"=>$id))->delete();
        return json_encode(array('status'=>1));
    }

    public function getUserInfo(){
        $user_id = $this->getParam("user_id", "0");
        $user_info = User::find($user_id);
        view()->share("user_info", $user_info);
        return view("dlg/user_info_dlg_content");
    }

    public function note_list(){
        $user_id = $this->getParam("user_id", "0");
        $where = array();
        $where['send_user_id'] = $user_id;
        $model = new Note();
        $model = $model->where($where);
        $model = $model->orderBy("note_status");
        $model = $model->orderBy("send_date", "desc");
        $from_list = $model->get();
        view()->share("from_list", $from_list);
        $model = new Note();
        $where = array();
        $where['to_user_id'] = $user_id;
        $model = $model->where($where);
        $model = $model->orderBy("note_status");
        $model = $model->orderBy("send_date", "desc");
        $to_list = $model->get();
        view()->share("to_list", $to_list);
        return view("dlg/note_dlg_content");
    }

    public function note_list1(){
        $user_id = $this->getParam("user_id", "0");
        $where = array();
        $where['send_user_id'] = $user_id;
        $model = new Note();
        $model = $model->where($where);
        $model = $model->orderBy("note_status");
        $model = $model->orderBy("send_date", "desc");
        $from_list = $model->get();
        view()->share("from_list", $from_list);
        $model = new Note();
        $where = array();
        $where['to_user_id'] = $user_id;
        $model = $model->where($where);
        $model = $model->orderBy("note_status");
        $model = $model->orderBy("send_date", "desc");
        $to_list = $model->get();
        view()->share("to_list", $to_list);
        return view("dlg/note_dlg_content1");
    }

    public function view(){
        $id = $this->getParam("id", "0");
        $info = Note::find($id);
        if(isset($info['id'])){
            $user = Sentinel::getuser();
            if($user['id']*1 == $info['to_user_id']*1){
                if($info['note_status']*1 == 0){
                    $info['read_date'] = date("Y-m-d H:i:s");
                    $info['note_status'] = "1";
                    $info->save();
                }
            }

        }
        view()->share("info", $info);
        return view("dlg/note_view_dlg_content");
    }
}
