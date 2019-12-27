<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 28/12/2016
 * Time: 01:24
 */

namespace common\models;


use common\models\BaseModels\WorkingHoursBase;

class WorkingHours extends WorkingHoursBase
{



    const TYPE_DELIVERY=0;
    const TYPE_RESTAURANT=1;
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkingDay()
    {
        return $this->hasOne(WorkingDays::className(), ['id' => 'working_day_id']);
    }


    public function getJson(){

//substr("abcdef", -1)
        return array('start'=>substr($this->open_time,0,-3),'stop'=>substr($this->close_time,0,-3));
    }

    public function getString(){

//substr("abcdef", -1)
        return substr($this->open_time,0,-3)."-".substr($this->close_time,0,-3);
    }
}