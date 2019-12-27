<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 22.10.15
 * Time: 19:11
 */

namespace common\widgets;


use yii\base\Widget;

class MyAllert extends Widget
{


    public $alertTypes = [
        'error'   => 'alert-danger',
        'danger'  => 'alert-danger',
        'success' => 'alert-success',
        'info'    => 'alert-info',
        'warning' => 'alert-warning'
    ];


    public $alertTemplate = '<div class="alert {alert-type} alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>{msg}</div>';






    public function run()
    {

        $session = \Yii::$app->session;
        $flashes = $session->getAllFlashes();

        $alerts= "";

        foreach ($flashes as $type => $data) {
            if (isset($this->alertTypes[$type])) {
                $data = (array) $data;
                foreach ($data as $i => $message) {
                    $alerts .= strtr($this->alertTemplate, [
                        '{msg}' => $message,
                        '{alert-type}'=>$this->alertTypes[$type]
                    ]);


                }

                echo $alerts;

                $session->removeFlash($type);
            }
        }


    }
}