<?php
use App\Product;
use App\User;
use App\ShopType;
use App\BoardType;



if(!function_exists("shopTitleBreak")){
    function shopTitleBreak($title){
        $title_a = explode("/", $title);
        $ret = "";
        foreach($title_a as $item){
            $ret .= ($ret == "" ? "":"<br>").$item;
        }
        return $ret;
    }
}

if(!function_exists("XSSfilter")){
    function XSSfilter($str)
        {
            $filstr = "script,onselect,onrowsinserted,confirm,document,cookie"; // 필터링 할 문자열
            if($filstr != "") {
                $otag = explode (",", $filstr);

                for($i=0; $i < count($otag); $i++) {
                    $ele = $otag[$i];
                    $ele = trim($ele);
                    $str = str_replace($ele, "_".$ele."_",$str);
                }
        }
            return $str;
        }
}

if(!function_exists("clearXSS")){
    function clearXSS($str){
        $avatag = "p,br"; 
        $str = eregi_replace("<", "$lt;", $str);
        $str = eregi_replace(">", "$gt;", $str);
        $str = eregi_replace("\0", "", $str);

        // 허용할 태그를 지정한 경우
        if($avatag != "") {
            $otag = explode(",",$avatag);

            // 허용할 태그 원상태로 변환
            for($i = 0; $i < count($otag); $i++) {
                $ele = $otag[$i];
                $ele = trim($ele);
                $str = eregi_replace("&lt;".$ele." ", "<".$ele." ", $str);
                $str = eregi_replace("&lt;".$ele."$gt;", "<".$ele.">", $str);
                $str = eregi_replace(" ".$ele."&gt;"," ".$ele.">", $str);
                $str = eregi_replace($ele."//&gt;".$ele."/>", $str);
                $str = eregi_replace("&lt;//".$ele, "</".$ele, $str);
            }
        }
        return $str;
    }
        
}

if(!function_exists("sql_inj")){
    function sql_inj($str){
        $str = mb_strtolower($str);
        $pattern = "and | exec| insert| select| delete| update| count|select*|select *| chr| mid|master|truncate|char|declare|;| or |+|>|<|& |SLEEP | ‘ |//!|//|-|(|)|#|=";
        $arr = explode("|", $pattern);
        array_push($arr,"|");
        foreach($arr as $item){
            $item = trim($item);
            $pos = strpos($str, $item);
            if($pos !== false){
                return true;
            }
        }
        return false;
    }
}

if(!function_exists("checkSQLInject")){
    function checkSQLInject($filter_arr){
        foreach($filter_arr as $item){
            $val = "";
            if(isset($_REQUEST[$item])){
                $val = $_REQUEST[$item];
            }
            if($val != ""){
                $ret = sql_inj($val);
                if($ret === true){
                    return true;
                }
            }
        }
        return false;
    }
}
if(!function_exists("getBoardCategoryTypeName")){
    function getBoardCategoryTypeName($board_type){
        getCurrentLang();
        $ret = __('미정');
        $arr = array(__('lang.게시판'),__('lang.업소스케쥴'),__("lang.업소후기"));
        if(isset($arr[$board_type])){
            $ret = $arr[$board_type];
        }
        return $ret;
    }
}

if(!function_exists("getScheduleStatus")){
    function getScheduleStatus($status, $is_complete = 1){
        getCurrentLang();
        $ret = __("lang.미정");
        if($is_complete*1 == 0){
            $ret = __("lang.광고해제");
            return $ret;
        }

        $arr = array(__("lang.광고해제"), __("lang.광고중"));
        if($arr[$status]){
            $ret = $arr[$status];
        }

        return $ret;
    }
}

if(!function_exists("getUserPointFromBoardType")){
    function getUserPointFromBoardType($board_type, $is_reply=0){
        $point_arr = array(
            array("type"=>'8', "board"=> 400, "reply"=>10),
            array("type"=>'1', "board"=> 10, "reply"=>2),
            array("type"=>'2', "board"=> -10, "reply"=>2),
            array("type"=>'3', "board"=> 10, "reply"=>5),
            array("type"=>'4', "board"=>5, "reply"=>5),
            array("type"=>'5', "board"=> 10, "reply"=>2),
            array("type"=>'6', "board"=> 10, "reply"=>2),
            array("type"=>'7', "board"=> 20, "reply"=>5),
        );

        $ret = 0;
        foreach($point_arr as $point){
            if($point['type']*1 == $board_type){
                if($is_reply*1 == 0){
                    $ret = $point['board'];
                }else{
                    $ret = $point['reply'];
                }
            }
        }
        return $ret;
    }
}

if(!function_exists('uchat_array2data')) {
    function uchat_array2data($arr) {
        $arr['time'] = time();
        ksort($arr);
        $arr = array_filter($arr);
        $arr['hash'] = md5(implode($arr['token'], $arr));
        unset($arr['token']);
        foreach ($arr as $k => &$v){ $v = $k.' '.urlencode($v); }
        return implode("|", $arr);
    }
}


if(!function_exists("getMsgTimeStr")){
    function getMsgTimeStr($date){
        return substr($date, 0,10);

    }
}

if(!function_exists("getMsgTimeStr1")){
    function getMsgTimeStr1($date){
        $datetime1 = date('Y-m-d H:i:s');
        $datetime2 = $date;
        if(date("Y-m-d", strtotime($date)) == date("Y-m-d")){
            return date("H:i", strtotime($date));
        }else{
            return date("m-d H:i", strtotime($date));
        }
    }
}

if(!function_exists("getLoginUserInfo")){
    function getLoginUserInfo(){
        $ret = array();
        if(Sentinel::check()){
            $user = Sentinel::getuser();
            $ret = $user;
        }
        return $ret;
    }
}

if(!function_exists("getLoginUserId")){
    function getLoginUserId(){
        $ret = 0;
        if(Sentinel::check()){
            $user = Sentinel::getuser();
            $ret = $user['id'];
        }
        return $ret;
    }
}

if(!function_exists("getQuestionStatusStr")){
    function getQuestionStatusStr($status){
        getCurrentLang();
        $ret  =__('lang.미정');
        $arr = array(__("lang.답변대기"),__("lang.답변완료"));
        if(isset($arr[$status])){
            $ret = $arr[$status];
        }
        return $ret;
    }
}

if(!function_exists("getNoticeTypeStr")){
    function getNoticeTypeStr($type){
        getCurrentLang();
        $ret  =__('lang.미정');
        $arr = array("1"=>__("lang.이용안내"),"2"=>__("lang.제휴"),"3"=>__("lang.결제"),"4"=>__("lang.이벤트"),"5"=>__("lang.기타"));
        if(isset($arr[$type])){
            $ret = $arr[$type];
        }
        return $ret;
    }
}

if(!function_exists("getShopTypeList")){
    function getShopTypeList(){
        $list = ShopType::getShopTypeList();
        return $list;
    }
}

if(!function_exists("getShopTypeTitle")){
    function getShopTypeTitle($id){
        $info = ShopType::find($id);
        return $info['title'];
    }
}

if(!function_exists("getHomeBoardTypeList")){
    function getHomeBoardTypeList(){
        getCurrentLang();
        $arr = array("1"=>__("lang.자유게시판"),"2"=>__("lang.질문답변"));
        return $arr;
    }
}

if(!function_exists("getBoardTypeList")){
    function getBoardTypeList(){
        $board_type_list = BoardType::orderBy("order_num")->get();
        $arr = array();
        foreach($board_type_list as $key =>$item){
            $arr[$item['id']] = $item['title'];
        }
        return $arr;
    }
}

if(!function_exists("getBoardTypeStr")){
    function getBoardTypeStr($key){
        $ret = "";
        $info = BoardType::find($key);
        if(isset($info['id'])){
            $ret = $info['title'];
        }

        return $ret;
    }
}

if(!function_exists("getUserGenderStr")){
    function getUserGenderStr($status){
        getCurrentLang();
        $ret = "";
        $arr = array("1"=>__("lang.남성"), "2"=>__("lang.여성"));
        if(isset($arr[$status])){
            $ret = $arr[$status];
        }
        return $ret;
    }
}

if(!function_exists("getUserStatusStr")){
    function getUserStatusStr($status){
        getCurrentLang();
        $ret = "";
        $arr = array("1"=>__("lang.활성"), "91"=>__("lang.탈퇴"), "99"=>__("lang.강퇴"));
        if(isset($arr[$status])){
            $ret = $arr[$status];
        }
        return $ret;
    }
}

if(!function_exists("getUserTypeStr")){
    function getUserTypeStr($key){
        getCurrentLang();
        $ret = "";
        $arr = array("99"=>__("lang.관리자"), "1"=>__("lang.일반고객"), "70"=>__("lang.업주"));
        if(isset($arr[$key])){
            $ret = $arr[$key];
        }
        return $ret;
    }
}

if(!function_exists("getUserInfoJsonInput")){
    function getUserInfoJsonInput($id){
        $html = "";
        $info = User::find($id);
        if($info['id']){
            $html = json_encode($info);
        }
        $html = "<input type = 'hidden' name = 'user_info_json' value = '".$html."'/>";
        return $html;
    }
}

if(!function_exists("getBrandUploadTitle")){
    function getBrandUploadTitle($condition){
        $ret = "";
        $stateArr = array("uploaded by seller", "edited by admin");
        if(isset($stateArr[$condition])){
            $ret = $stateArr[$condition];
        }
        return $ret;
    }
}

if(!function_exists("rand_str")){
    function rand_str($length = 32, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890')
    {
        // Length of character list
        $chars_length = (strlen($chars) - 1);

        // Start our string
        $string = $chars{rand(0, $chars_length)};

        // Generate random string
        for ($i = 1; $i < $length; $i = strlen($string))
        {
            // Grab a random character from our list
            $r = $chars{rand(0, $chars_length)};

            // Make sure the same two characters don't appear next to each other
            if ($r != $string{$i - 1}) $string .=  $r;
        }
        // Return the string
        return $string;
    }

}

if(!function_exists("getSellerProductCount")){
    function getSellerProductCount($seller_id){
        return Product::where(array("seller_id"=>$seller_id))->count();
    }
}

if(!function_exists("find_in_set")){
    function find_in_set($str, $str_list){
        return in_array($str, explode(",", $str_list));
    }
}

if(!function_exists("getSavedSearchPrice")){
    function getSavedSearchPrice($conditions){
        $ret = "";
        if(!isset($conditions)) return $ret;
        $conditions_a = explode(",", $conditions);
        $ret = $conditions_a[0];
        if(count($conditions_a)>1){
            $ret .= "~".$conditions_a[1];
        }
        return $ret;
    }
}


if(!function_exists("getProductConditionTitles")){
    function getProductConditionTitles($conditions){
        $ret = "";
        if(!isset($conditions)) return $ret;
        $stateArr = array("new", "used");
        $conditions_a = explode(",", $conditions);
        foreach($conditions_a as $item){
            if(isset($stateArr[$item])){
                $ret .=  (""==$ret? "":",").$stateArr[$item];
            }
        }

        return $ret;
    }
}

if(!function_exists("getProductConditionTitle")){
    function getProductConditionTitle($condition){
        $ret = "";
        $stateArr = array("new", "unused");
        if(isset($stateArr[$condition])){
            $ret = $stateArr[$condition];
        }
        return $ret;
    }
}

if(!function_exists("getOrderDiscountState")){
    function getOrderDiscountState($state){
        $ret = "";
        $stateArr = array("none", "user proposal", "agree", "seller proposal", "cancel");
        if(isset($stateArr[$state])){
            $ret = $stateArr[$state];
        }
        return $ret;
    }
}

if(!function_exists("getOrderState")){
    function getOrderState($state){
        $ret = "";
        $stateArr = array("unpaid", "prepare", "delivery", "check", "complete");
        if(isset($stateArr[$state])){
            $ret = $stateArr[$state];
        }
        return $ret;
    }
}

if(!function_exists("getOrderStateClass")){
    function getOrderStateClass($state){
        $ret = "";
        $stateArr = array("label-warning", "label-info", "label-info", "label-danger", "label-success");
        if(isset($stateArr[$state])){
            $ret = $stateArr[$state];
        }
        return $ret;
    }
}

if(!function_exists("newOrderNo")){
    function newOrderNo($user_id){
        $ret = date('YmdHis');
        $ret = $ret .$user_id .rand(1111, 9999);
        return $ret;
    }
}

if(!function_exists("convertStdClassToArray")){
    function convertStdClassToArray($class){
        $classStr = json_encode($class);
        $ret = json_decode($classStr,1);
        return $ret;
    }
}

if(!function_exists("encryptShipAddress")){
    function encryptShipAddress($address){
        if($address == '') return;
        $prefix = substr($address,0,2);
        $suffix = substr($address, -2,2);
        return $prefix."xxxxxxxx".$suffix;
    }
}

if(!function_exists('convertArrayGroupArray')){
    function convertArrayGroupArray($array, $disKey) {
        if (count($array) == 0)
            return array();

        $curKeyValue = $array[0][$disKey];
        $retEleArray = array();
        $retArray = array();

        foreach ($array as $item) {
            if ($curKeyValue == $item[$disKey]) {
                $retEleArray[] = $item;
            } else {
                $retArray[] = $retEleArray;
                $retEleArray = array();
                $retEleArray[] = $item;
                $curKeyValue = $item[$disKey];
            }
        }

        if (count($retEleArray) > 0) {
            $retArray[] = $retEleArray;
        }

        return $retArray;
    }
}

if(!function_exists('convertArrayGroupArray1')){
    function convertArrayGroupArray1($array, $disKey) {
        if (count($array) == 0)
            return array();

        $curKeyValue = $array[0][$disKey];
        $retEleArray = array();
        $retArray = array();

        foreach ($array as $item) {
            if ($curKeyValue == $item[$disKey]) {
                $retEleArray[] = $item;
            } else {
                $retArray[] = array('list' => $retEleArray, 'key' =>$curKeyValue);
                $retEleArray = array();
                $retEleArray[] = $item;
                $curKeyValue = $item[$disKey];
            }
        }

        if (count($retEleArray) > 0) {
            $retArray[] = array('list' =>$retEleArray,  'key' =>$curKeyValue);
        }

        return $retArray;
    }
}


if(!function_exists('convertAttrToArray')) {
    function convertAttrToArray($class)
    {
        $classStr = json_encode($class);
        $ret = json_decode($classStr, 1);
        return $ret;
    }
}

if(!function_exists('getBannerCategoryTitle')){
    function getBannerCategoryTitle($category_id){
        $ret = '-';
        switch($category_id){
            case "0":
                $ret = 'Top Banner';
                break;
            case "1":
                $ret = 'Daily Deal';
                break;
            case "2":
                $ret = 'Middle Top Banner';
                break;
            case "3":
                $ret = 'Middle Bottom Banner';
                break;
            case "4":
                $ret = 'Bottom Banner';
                break;
        }
        return $ret;
    }
}


if (!function_exists('makeUploadFileName')) {
    function makeUploadFileName()
    {
        $datetime = date('YmdHis');
        $datetime = $datetime . rand(1111, 9999);
        return $datetime;
    }
}

if(!function_exists('getAttrTypeName')){
    function getAttrTypeName($attr_type){
        $ret = '-';
        switch($attr_type){
            case "0":
                $ret = 'text';
                break;
            case "1":
                $ret = 'select';
                break;
            case "2":
                $ret = 'checkbox';
                break;
            case "3":
                $ret = 'radio';
                break;
        }
        return $ret;
    }
}

if (!function_exists('correctImgPath')) {
    function correctImgPath($path)
    {
        if($path == ""){
            return url("assets/images/default_no_image.jpg");
        }
        if (0 !== strpos($path, 'http')) { // 첫시작이 아니면
            return url($path);
        }
        return $path;
    }
}

if (!function_exists('correctImgPath1')) {
    function correctImgPath1($path)
    {
        if(!isset($path)) return "";
        if (0 !== strpos($path, 'http')) { // 첫시작이 아니면
            return url($path);
        }
        return $path;
    }
}


if (!function_exists('correctImgProductPath')) {
    function correctImgProductPath($path)
    {
        if($path == ""){
            return url("assets/images/default-product.png");
        }
        if (0 !== strpos($path, 'http')) { // 첫시작이 아니면
            return url($path);
        }
        return $path;
    }
}

if (!function_exists('utf8_strcut')) {
    function utf8_strcut($str, $size, $suffix = '...')
    {
        $substr = substr($str, 0, $size * 2);
        $multi_size = preg_match_all('/[\x80-\xff]/', $substr, $multi_chars);

        if ($multi_size > 0)
            $size = $size + intval($multi_size / 3) - 1;

        if (strlen($str) > $size) {
            $str = substr($str, 0, $size);
            $str = preg_replace('/(([\x80-\xff]{3})*?)([\x80-\xff]{0,2})$/', '$1', $str);
            $str .= $suffix;
        }

        return $str;
    }
}

if(!function_exists('getCurrentLang')){
    function getCurrentLang(){
        $lang = session("lang","vn");
        \Illuminate\Support\Facades\App::setLocale($lang);
    }
}


