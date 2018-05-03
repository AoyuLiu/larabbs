<?php

namespace App\Models\Traits;

use Redis;
use Carbon\Carbon;

trait LastActivedAtHelper
{    //缓存相关
    protected $hash_prefix = 'larabbs_last_actived_at_';
    protected $field_prefix = 'user_';

    public function getLastActivedAtAttribute($value)
    {
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());
        $field = $this->getHashField();
        $dateTime = Redis::hGet($hash, $field) ? : $value;

        if($dateTime){
            return new Carbon($dateTime);
        } else {
            return $this->created_at;
        }
    }



    public function recordLastActivedAt()
    {
            // 今日日期 2018-1-12
         $hash  = $this->getHashFromDateString(Carbon::now()->toDateString());
         $field = $this->getHashField();
          //  今日世界 2018 3-12  08:32:12
        $now   = Carbon::now()->toDateTimeString();
        Redis::hSet($hash,$field,$now);
    }

    public function syncUserActivedAt()
    {

        $hash = $this->getHashFromDateString(Carbon::yesterday()->toDateString());
        $dates = Redis::hGetAll($hash);
        foreach ($dates as $user_id => $actived_at) {
            $user_id = str_replace($this->field_prefix,'',$user_id);

            if($user = $this->find($user_id)) {
                $user->last_actived_at = $actived_at;
                $user->save();
            }

        }
        //同步数据后，清理缓存
        Redis::del($hash);
    }

    public function getHashFromDateString($date)
    {
        return $this->hash_prefix.$date;
    }

    public function getHashField()
    {
        return $this->field_prefix. $this->id;
    }

}
