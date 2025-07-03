<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function genImage($imageData, $dir = 'product'){
        $path = "uploads/".$dir;
        if (!file_exists($path))
            mkdir($path, 0755);
        /*$path .= "/".date('Ymd');
        if (!file_exists($path))
            mkdir($path, 0755);*/

        $path.="/".date('YmdHis').rand(1111, 9999).".png";
        $pos = strpos($imageData, 'data:image');
        if($pos === false){
            return "-1";
        }
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
        file_put_contents(public_path($path), $image);
        return $path;

    }


    protected function getBoClass(Model $model, Request $request, $table = ''){
        $flag = 0;
        $items = $model->getAttributes();

        foreach($items as $key=>$value){
            if(($request->get($key) != null) && ($request->get($key) != '' && $request->get($key) != $value)  ){
                $model[$key] = $request->get($key);
                $flag = 1;
            }
        }

        if(count($items) == 0){
            foreach($request->all() as $key => $value){
                if(Schema::hasColumn($table,$key)){
                    $model[$key] = $value;
                    $flag=1;
                }
            }
        }
        return array('flag'=> $flag, 'model' => $model);
    }


    public function decodeRequestParam(){
        $q =  $this->getParam("q", "");
        $ret = array();
        if($q != ''){
            $ret = urldecode(base64_decode($q));
            $ret = json_decode($ret,1);
        }
        return $ret;
    }

    public function getParam($key, $default){
        if(!isset($_REQUEST[$key])) return $default;
        return $_REQUEST[$key];
    }

    public  function getPageParam($perPageSize = 10,$pageKey = "page"){
        $page =  $this->getParam($pageKey, '1') * 1;
        if($page < 1){
            $page = 1;
        }

        $start = ($page-1)*$perPageSize;
        $pageParam["pageNo"] = $page;
        $pageParam["start"] = $start;
        $pageParam["perPageSize"] = $perPageSize;
        return $pageParam;
    }

    public function assign($key, $value){
        view()->share($key, $value);
    }
    public  function setPageParam($pageParam , $totalCount){
        if(empty($pageParam))
            return array();
        $ret = array();
        $pageNo = $pageParam["pageNo"];
        $ret["pageNo"] = $pageNo;
        $iPageNo =  $pageNo;
        if(($pageNo%10)==0){
            $startStep = ($pageNo/10-1)*10;
        }else{
            $startStep =  $iPageNo - $iPageNo % 10;
        }

        $ret["startStep"] = $startStep;
        $ret["perPageSize"] = $pageParam["perPageSize"];
        $pageCount = ceil($totalCount/$pageParam["perPageSize"]);
        $ret["pageCount"] = $pageCount;
        $ret["startNumber"] = $pageParam["start"];
        return $ret;
    }


    public function getOrderParam($param){
        $ret = array();
        if(isset($param['order'])){
            $ret = json_decode($param['order'],1);
        }
        return $ret;
    }

    protected function setModelOrderParam($model, $order){
        if(is_array($order)){
            foreach($order as $item){
                $key = key($item);
                $model = $model->orderBy($key, $item[$key]);
            }
        }
        return $model;
    }

    protected function setLimit($model, $page, $page_length){
        $model = $model->skip(($page-1)*$page_length)->take($page_length);
        return $model;
    }

}
