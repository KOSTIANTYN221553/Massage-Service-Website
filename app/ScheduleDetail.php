<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleDetail extends Model
{
    protected $table = 'schedule_detail';

    protected $guarded  = ['id'];

    public function manager()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

}
