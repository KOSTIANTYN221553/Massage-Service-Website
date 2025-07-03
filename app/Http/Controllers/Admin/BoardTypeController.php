<?php namespace App\Http\Controllers\Admin;

/**
 * write king star
 */

use App\BoardCategory;
use App\BoardType;
use\App\Http\Controllers\JoshController;
use App\Http\Requests\ConfirmPasswordRequest;
use App\Notice;
use App\ShopType;
use App\VirtualBoardType;
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


class BoardTypeController extends JoshController
{

    public function index(Request $request){
        $pageParam = $this->getPageParam();
        $search = $this->getParam("search", "");
        view()->share('search', $search);

        $where = array();
        $model = new VirtualBoardType();

        if($search != ''){
            $model = $model->whereRaw(" title LIKE '%".$search."%'");
        }

        $model = $model->where($where);
        $model = $model->orderBy("board_type");
        $model = $model->orderBy("id");
        $select = "*";
        $model = $model->select(DB::raw($select));


        $count = $model->count();
        $order_key = $this->getParam("order_key", "board_type");
        $order_val = $this->getParam("order_val", "ASC");

        view()->share("order_key", $order_key);
        view()->share("order_val", $order_val);
        $model->orderBy($order_key, $order_val);

        $model = $model->skip($pageParam["start"])->take($pageParam["perPageSize"]);
        $list = $model->get();
        $pageParam = $this->setPageParam($pageParam, $count);
        view()->share('pageParam', $pageParam);
        view()->share("list", $list);

        return view('admin/board_type/list');
    }

    public function info($id, $board_type){
        view()->share("id", $id);
        if($id*1 > 0){
            if($board_type*1 == 0){
                $info = BoardType::find($id);
            }else{
                $info = ShopType::find($id);
            }

            if(!isset($info['id'])){
                return redirect("admin/board_type");
            }
        }else{
            $info = new BoardType();
        }
        view()->share("info", $info);
        view()->share("board_type", $board_type);
        view()->share("type_id", $id);
        return view("admin/board_type/info");
    }

    public function ajaxBoardCategoryInfo(Request $request){
        $id = $this->getParam("id", "0");
        $info = BoardCategory::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new BoardCategory();
            $ret = $this -> getBoClass($info,$request, 'board_category');
            $info = $ret['model'];
            $info['order_no'] = $info->getOrder();
        }
        $info->save();
        return json_encode(array('status'=>1));
    }

    public function deleteBoardCategory(){
        $id = $this->getParam("id", "0");
        $category = BoardCategory::find($id);
        if(!isset($category['id'])){
            return json_encode(array('status'=>"0", "msg"=>__("lang.정보가 정확하지 않습니다.")));
        }
        $ret = $category->isDelete();
        if($ret['status']*1 == 0){
            return json_encode($ret);
        }
        $category->delCategory($category['id']);
        return json_encode(array('status'=>1));
    }

    public function getCategoryTree(){
        $type_id = $this->getParam("type_id", "0");
        $board_type = $this->getParam("board_type", "0");
        $model = new BoardCategory();
        $list = $model->getCategoryTree($type_id,$board_type);
        view()->share('list', $list);
        return view("admin/board_type/category_list");
    }

    public function update_category(){
        $tree_list = $this->getParam("tree_list", "");
        $tree_list = json_decode($tree_list,1);
        foreach($tree_list as $key => $item){
            $info = BoardCategory::find($item['id']);
            if(isset($info['id'])){
                $info['order_no'] = $key;
                $info['parent_id'] = 0;
                $info->save();
            }
            if(isset($item['children'])){
                foreach($item['children'] as $key2 => $item2){
                    $info1 = BoardCategory::find($item2['id']);
                    if(isset($info1['id'])){
                        $info1['order_no'] = $key2;
                        $info1['parent_id'] = $info['id'];
                        $info1->save();
                    }
                }
            }
        }
        return json_encode(array('status'=>'1'));
    }

    public function ajaxSaveInfo(Request $request){
        $id = $this->getParam("id", "0");
        $info = BoardType::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new BoardType();
            $ret = $this -> getBoClass($info,$request, 'board_type');
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
        $ret = BoardType::isDelete($ids);
        if($ret['status']*1 == 0){
            return json_encode($ret);
        }
        BoardType::whereRaw("FIND_IN_SET(id, '{$ids}')")->delete();
        return json_encode(array("status"=>"1"));
    }

}
