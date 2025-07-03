<?php namespace App\Http\Controllers\Admin;

/**
 * write king star
 */

use App\Board;
use App\BoardCategory;
use\App\Http\Controllers\JoshController;
use App\Http\Requests\ConfirmPasswordRequest;
use App\ReviewBoard;
use App\ReviewBoardReply;
use App\ShopType;
use App\UserPointLog;
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


class ReviewController extends JoshController
{


    public function index(){
        $category_id = $this -> getParam("category_id", "0");
        view()->share("category_id", $category_id);
        $pageParam = $this->getPageParam();

        $search = $this->getParam("search", "");
        view()->share('search', $search);

        $where = array();
        $model = new ReviewBoard();
        $search_key_type = $this->getParam("search_key_type", "shop.title");
        view()->share("search_key_type",$search_key_type);

        if($search != ''){
            $model = $model->whereRaw(" {$search_key_type} LIKE '%".$search."%'");
        }

        $board_type = $this->getParam("board_type", "0");
        view()->share("board_type", $board_type);
        if($board_type*1 > 0){
            $model = $model->whereRaw("shop_type.id = '{$board_type}'");
        }

        if($category_id != '' && $category_id*1 > 0){
            $where['category_id']= $category_id;
        }

        $model = $model->where($where);
        $model = $model->whereRaw("review_board.shop_id > 0");
        $select = "review_board.*, shop_type.title shop_type_title,user.nickname user_nickname";
        $model = $model->join("shop_type", "review_board.shop_type","=","shop_type.id");
        $model = $model->join("user", "review_board.user_id","=","user.id");

        $model = $model->select(DB::raw($select));


        $count = $model->count();
        $order_key = $this->getParam("order_key", "id");
        $order_val = $this->getParam("order_val", "ASC");

        $shop_type_list = ShopType::getShopTypeList();
        view()->share("shop_type_list", $shop_type_list);

        view()->share("order_key", $order_key);
        view()->share("order_val", $order_val);
        $model->orderBy($order_key, $order_val);

        $model = $model->skip($pageParam["start"])->take($pageParam["perPageSize"]);
        $list = $model->get();

        $pageParam = $this->setPageParam($pageParam, $count);
        view()->share('pageParam', $pageParam);
        view()->share("list", $list);

        return view('admin/review/list');
    }

    public function info($id){
        view()->share("id", $id);
        if($id*1 > 0){
            $info = ReviewBoard::find($id);
            if(!isset($info['id'])){
                return redirect("admin/review");
            }
            $model = new BoardCategory();
            $category_list = $model->getCategoryChildList(2,$info['shop_type']);
            view()->share("category_list", $category_list);
        }else{
            $info = new ReviewBoard();
        }
        $shop_type_list = ShopType::all();
        view()->share("shop_type_list", $shop_type_list);
        view()->share("info", $info);
        return view("admin/review/info");
    }

    public function view($id){
        view()->share("id", $id);
        if($id*1 > 0){
            $info = ReviewBoard::find($id);
            if(!isset($info['id'])){
                return redirect("admin/review");
            }
            $info->addViewCount();
        }else{
            return redirect("admin/review");
        }
        $shop_info = Shop::find($info['shop_id']);
        if(!isset($shop_info['id'])){
            return redirect("admin/review");
        }
        view()->share("shop_info", $shop_info);
        $shop_type_info = ShopType::find($shop_info['type']);
        view()->share("shop_type_info", $shop_type_info);
        view()->share("info", $info);
        $reply_list = ReviewBoardReply::getReplyList($id);
        view()->share("reply_list", $reply_list);
        $user = Sentinel::getuser();
        view()->share("user", $user);
        return view("admin/review/view");
    }


    public function ajaxSaveInfo(Request $request){
        $id = $this->getParam("id", "0");
        $info = ReviewBoard::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new ReviewBoard();
            $ret = $this -> getBoClass($info,$request, 'review_board');
            $info = $ret['model'];
        }
        $user = Sentinel::getuser();
        $info['user_id'] = $user['id'];
        $info->save();
        return json_encode(array('status'=>1));
    }

    public function setBatchDelete(){
        $ids = $this->getParam("ids", "");
        if($ids == ""){
            return json_encode(array("status"=>"0", "msg"=> __("lang.항목을 선택하여 주십시오.")));
        }
        $review_list = ReviewBoard::whereRaw("FIND_IN_SET(id, '{$ids}')")->get();
        ReviewBoard::whereRaw("FIND_IN_SET(id, '{$ids}')")->delete();
        foreach($review_list as $review){
            $user_id = $review['user_id'];
            $model = new UserPointLog();
            $model->addRemoveUserPoint($user_id,20,0);
        }

        return json_encode(array("status"=>"1"));
    }

    public function ajaxSaveReply(Request $request){
        $id = $this->getParam("id", "0");
        $info = ReviewBoardReply::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new ReviewBoardReply();
            $ret = $this -> getBoClass($info,$request, 'review_board_reply');
            $info = $ret['model'];
        }
        if($info['id']*1 == 0 && $info['parent_reply_id']*1  ==0){
            $review_info = ReviewBoard::find($info['board_id']);
            $review_info['reply_count'] = $review_info['reply_count']+1;
            $review_info->save();
        }

        $user = Sentinel::getuser();
        $info['user_id'] = $user['id'];
        $info->save();
        return json_encode(array('status'=>1));
    }

    public function deleteReply(){
        $id = $this->getParam("id", "0");
        $reply_info = ReviewBoardReply::find($id);
        if(isset($reply_info['id'])&& $reply_info['parent_reply_id']*1 == 0){
            $board_id = $reply_info['board_id'];
            $board_info = ReviewBoard::find($board_id);
            if($board_info['reply_count'] >= 1){
                $board_info['reply_count'] -= 1;
                $board_info->save();
            }
        }
        $model = new UserPointLog();
        $model->addRemoveUserPoint($reply_info['user_id'],5,0);
        $whereRaw = "id = {$id} OR parent_reply_id = {$id}";
        ReviewBoardReply::whereRaw($whereRaw)->delete();
        return json_encode(array('status'=>1));
    }

    public function getCategoryList(){
        $shop_type = $this->getParam("shop_type", "0");
        $model = new BoardCategory();
        $categoryList = $model->getCategoryChildList(2,$shop_type);
        view()->share("categoryList", $categoryList);
        view()->share("category_id", "0");
        return view("category_list1");
    }

}
