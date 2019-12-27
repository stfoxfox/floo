<?php

use yii\db\Migration;

class m170803_023540_add_last_name extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user','last_name',$this->string());
        $this->addColumn('user','birthday',$this->timestamp());
    }

    public function safeDown()
    {
        $this->dropColumn('user','birthday');
        $this->dropColumn('user','last_name');
    }
}
