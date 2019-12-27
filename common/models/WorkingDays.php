<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 28/12/2016
 * Time: 01:22
 */

namespace common\models;


use common\models\BaseModels\WorkingDaysBase;

class WorkingDays extends WorkingDaysBase
{


    const DAY_MON=1;
    const DAY_TUE=2;
    const DAY_WEN=3;
    const DAY_TRU=4;
    const DAY_FRI=5;
    const DAY_SAT=6;
    const DAY_SUN=7;

    const STATUS_NOT_SET = 0;
    const STATUS_24_OPEN = 1;
    const STATUS_CLOSED = 2;
    const STATUS_HAS_HOURS = 3;



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurant()
    {
        return $this->hasOne(Restaurant::className(), ['id' => 'restaurant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkingHours()
    {
        return $this->hasMany(WorkingHours::className(), ['working_day_id' => 'id']);
    }


    public function getDeliveryHours(){

        if($this->id ){

            if ($deliveryHours=$this->getWorkingHours()->where(['type'=>WorkingHours::TYPE_DELIVERY])->one()){


                return [
                    'hours'=>
                        [
                            'start'=>substr($deliveryHours->open_time, 0, -3),
                            'stop'=>substr($deliveryHours->close_time, 0, -3),

                        ]
                ];

            }

        }


        return [
            'hours'=>
                [
                    'start'=>'',
                    'stop'=>'',

                ]
        ];
    }
    public function getRestaurantHours(){

        if($this->id ){

            if ($deliveryHours=$this->getWorkingHours()->where(['type'=>WorkingHours::TYPE_RESTAURANT])->one()){


                return [
                    'hours'=>
                        [
                            'start'=>substr($deliveryHours->open_time, 0, -3),
                            'stop'=>substr($deliveryHours->close_time, 0, -3),

                        ]
                ];

            }

        }


        return [
            'hours'=>
                [
                    'start'=>'',
                    'stop'=>'',

                ]
        ];
    }


    public function getDay(){

        switch ($this->weekday){

            case self::DAY_MON:{

                return "Пн";
            }
            case self::DAY_TUE:{

                return "Вт";
            }
            case self::DAY_WEN:{

                return "Ср";
            }
            case self::DAY_TRU:{

                return "Чт";
            }
            case self::DAY_FRI:{

                return "Пт";
            }
            case self::DAY_SAT:{

                return "Сб";
            }
            case self::DAY_SUN:{

                return "Вс";
            }
        }
    }

}