<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Sentinel;

class ReviewBoard extends Model
{
    protected $table = 'review_board';

    protected $guarded  = ['id'];

    public  function getRecentBoardList($shop_type = 0){
        $model = new ReviewBoard();
        $select = "review_board.*";
        //$model = $model->join("shop", "review_board.shop_id","=","shop.id");
        $where = array();
        if($shop_type*1 > 0){
            $where['shop_type'] = $shop_type;
        }
        $now = date("Y-m-d");
        //$whereRaw = "isShopComplete(shop.id, '{$now}') = 1 ";
        $model = $model->where($where);
        //$model = $model->whereRaw($whereRaw);
        $model = $model->orderBy("review_board.created_at", "desc");
        $model = $model->skip(0)->take(12);
        $model = $model->select(DB::raw($select));
        $list = $model->get();
        return $list;
    }

    public  function getFavoriteBoardList($shop_type = 0){
        $model = new ReviewBoard();
        $select = "review_board.*";
        //$model = $model->join("shop", "review_board.shop_id","=","shop.id");
        $where = array();
        if($shop_type*1 > 0){
            $where['shop_type'] = $shop_type;
        }
        $now = date("Y-m-d");
        //$whereRaw = "isShopComplete(shop.id, '{$now}') = 1 ";
        //$model = $model->whereRaw($whereRaw);
        $model = $model->where($where);
        $model = $model->orderBy("review_board.reply_count", "desc");
        $model = $model->skip(0)->take(12);
        $model = $model->select(DB::raw($select));
        $list = $model->get();
        return $list;
    }

    public function shop(){
        return  $this->hasOne('App\Shop', 'id', 'shop_id');
    }
    public function user(){
        return  $this->hasOne('App\User', 'id', 'user_id');
    }

    public function addViewCount(){
        if(!Sentinel::check()) return;
        $user = Sentinel::getuser();
        if(!ReviewBoardView::isRead($user['id'], $this->id)){
            $this->view_count = $this->view_count +1;
            $this->save();
            $info = new ReviewBoardView();
            $info['user_id'] = $user['id'];
            $info['board_id'] = $this->id;
            $info->save();
        }
    }

    public function getNoticeList($shop_type){
        $where = array("is_notice"=>1);
        $whereRaw = "getShopType(shop_id) = {$shop_type}";
        $list = ReviewBoard::where($where)->whereRaw($whereRaw)->skip(0)->take(1)->get();
        return $list;
    }

    public function getCategoryList($shop_type, $whereRaw, $where){
        $where1 = array();
        $where1['board_type'] = 2;
        $where1['type_id'] = $shop_type;
        $whereRaw1 = "parent_id > 0";
        if(isset($where['review_board.category_id'])){
            unset($where['review_board.category_id']);
        }

        $category_model = new BoardCategory();
        $category_model = $category_model->where($where1);
        $category_model = $category_model->whereRaw($whereRaw1);
        $categoryList = $category_model->get();
        $model1 = new ReviewBoard();
        $model1 = $model1->leftjoin('shop', 'shop.id', '=', 'review_board.shop_id');
        $total_cnt = $model1->where($where)->whereRaw($whereRaw)->count();
        $list  = array();
        array_push($list, array('title'=>__('lang.전체'), 'cnt'=>$total_cnt, 'id'=> '0'));
        foreach($categoryList as $item){
            $model1 = new ReviewBoard();
            $model1 = $model1->leftjoin('shop', 'shop.id', '=', 'review_board.shop_id');
            $where['category_id'] = $item['id'];
            $cnt = $model1->where($where)->whereRaw($whereRaw)->count();
            array_push($list, array('title'=> $item['title'], 'cnt'=>$cnt, 'id'=>$item['id']));
        }
        return $list;
    }
}
