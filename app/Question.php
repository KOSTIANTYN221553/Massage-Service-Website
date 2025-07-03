<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Sentinel;
class Question extends Model
{
    protected $table = 'question';

    protected $guarded  = ['id'];


    public function user(){
        return  $this->hasOne('App\User', 'id', 'user_id');
    }

    public function addViewCount(){
        $user = Sentinel::getuser();
        if(!QuestionView::isRead($user['id'], $this->id)){
            $this->view_count = $this->view_count +1;
            $this->save();
            $info = new QuestionView();
            $info['user_id'] = $user['id'];
            $info['board_id'] = $this->id;
            $info->save();
        }
    }

}
