<?php namespace App;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentTaggable\Taggable;
use DB;


class User extends EloquentUser {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	protected $table = 'user';

	/**
	 * The attributes to be fillable from the model.
	 *
	 * A dirty hack to allow fields to be fillable by calling empty fillable array
	 *
	 * @var array
	 */
    use Taggable;

	protected $fillable = [];
	protected $guarded = ['id'];
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	* To allow soft deletes
	*/
	//use SoftDeletes;

    /*protected $dates = ['deleted_at'];

    protected $appends = ['full_name'];
    public function getFullNameAttribute()
    {
        return str_limit($this->first_name . ' ' . $this->last_name, 30);
    }*/

    static  function getShopAccountList($user_id =0){
        $where = array();
        $where['type'] = 70;
        if($user_id*1 > 0){
            $where['id'] = $user_id;
        }
        $list = User::where($where)->get();
        return $list;
    }

    static  function checkUser($info){
        $ret = array("status"=> "1");
        $whereRaw = "email = '{$info['email']}' AND id <> {$info['id']}";
        $count = User::whereRaw($whereRaw)->count();
        if($count*1 > 0){
            $ret['status'] = "0";
            $ret['msg'] = "아이디가 증복되였습니다";
        }
        return $ret;
    }

    public function user_level(){
        return  $this->hasOne('App\UserLevel', 'id', 'level_id');
    }

    public function note_count(){
        $where = array();
        $where['to_user_id'] = $this->id;
        $where['note_status'] = 0;
        $ret = Note::where($where)->count();
        return  $ret;
    }


    public function shop_complete_info(){
        $where = array();
        $where['user_id'] = $this->id;
        $whereRaw = "complete_date IS NOT NULL AND complete_date != '0000-00-00 00:00:00' AND complete_date != ''";
        $info = Shop::where($where)->whereRaw($whereRaw)->orderBy('complete_date')->first();
        if(!isset($info['id'])){
            $info = array();
            $info['diff'] = -1;
            return $info;
        }
        $cur_date = strtotime(date('Y-m-d H:i:s'));
        $complete_time = strtotime($info['complete_date']);
        $diff = $complete_time - $cur_date;
        if($diff < 0){
            $info = array();
            $info['diff'] = -1;
        }else{
            $info['diff'] = $diff;
        }
        return $info;
    }

    public function get_user_write_count_info(){
        $user_id = $this->id;
        $select = " getUserBoardCount('{$user_id}') board_cnt, getUserReplyCount('{$user_id}') reply_cnt, getUserReviewCount('{$user_id}') review_cnt";
        $info = User::select(DB::raw($select))->find($this->id);
        return $info;

    }

    public function isWriteReply(){
        $msg = "";
        $select = "*, getUserReplyCount({$this->id}) reply_cnt";
        $user_info = User::select(DB::raw($select))->find($this->id);
        if($user_info['level_id']*1 <10){
            if($user_info['reply_cnt']*1 > 100){
                $msg = "댓글을 100개 이상 쓸수 없습니다.";
            }
        }else if($user_info['level_id']*1  > 10 && $user_info['level_id']*1  < 16){
            if($user_info['reply_cnt']*1 > 150){
                $msg = "댓글을 150개 이상 쓸수 없습니다.";
            }
        }
        return $msg;
    }
}
