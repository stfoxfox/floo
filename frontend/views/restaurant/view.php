<?php
/**
 * @var \common\models\Restaurant $restaurant
 */
use common\components\MyExtensions\MyImagePublisher;
use common\models\WorkingHours;
use yii\helpers\Url;
$this->title = 'САДЫ САЛЬВАДОРА | Контакты';
\frontend\assets\RestaurantAsset::register($this);
$url = $this->assetManager->getPublishedUrl('@frontend/assets/app');
$metroItems = array();
$colorItems= array();
if ($restaurant->metro){
    // $metros = explode("\n", str_replace("\r", "", $restaurant->metro));
    // foreach ($metros as $metro){
    //     $metroObj = explode(";", $metro);
    //     $metroItems[] = $metroObj[0];
    //     $colorItems[]=$metroObj[1];
    // }
    // $returnObj['metro']=$metroItems;
}
/**
 * @var \common\models\WorkingDays[] $WorkingDays
 */
$WorkingDays = $restaurant->getWorkingDays()->with(['workingHours'])->orderBy('weekday')->all();
$restaurantHours= array();
$deliveryHours =array();
foreach ($WorkingDays as $WorkingDay){
    /**
     * @var WorkingHours $workingHour
     */
    foreach ($WorkingDay->workingHours as $workingHour){
        if ($workingHour->type == WorkingHours::TYPE_DELIVERY){
            $deliveryHours[$workingHour->getString()][]= $WorkingDay->getDay() ;///$WorkingDay->getDay().": ".$workingHour->getString();;
        }else{
            $restaurantHours[$workingHour->getString()][]= $WorkingDay->getDay();;
        }
    }
}
$resrHours = array();
foreach ($restaurantHours as $key=>$restaurantHour){
    $resrHours[] = implode(',',$restaurantHour).": ".$key;
}
$delrHours = array();
foreach ($deliveryHours as $key=>$deliveryHour){
    $delrHours[] = implode(',',$deliveryHour).": ".$key;
}
?>    <div class="content restaurant one">


        <div class="wrapper">

            <h2 class="big m-b50">Контакты</h2>

            <div class="row">

                <div class="col col_3">
                    <div class="restaurant-list">
                        <div class="res-sep">
                            <p>


                                <?=implode('<br>',$metroItems)?>

                            </p>
                            <p>м.Новокузнецкая, м.Третьяковская</p>
                            <p>
                               <?=$restaurant->address?>
                            </p>
                            <p>
                            Часы работы:<br>

<?=implode('<br>',$resrHours)?>

                            </p>
                            <p>
                                Доставка:<br>
                                <?=implode('<br>',$delrHours)?>

                            </p>		<p>
                                <?=$restaurant->phone?><br>+7 964 505-79-59	<br> (WhatsApp, Viber, Telegram»)	</p>
                        </div>
                        <?php foreach ($colorItems as $colorItem) {
                            ?>
                            <div style="background:<?=$colorItem?>!important" class="line"></div>
                        <?php
                        } ?>

                    </div>

                    <script>
                        var point_url = "<?=$url?>/img/point.png";
                        function points() {
                            var points = [
                                {geo: <?="[{$restaurant->lat},{$restaurant->lng}]"?>}
                            ]
                            return points;
                        }
                        function center() {
                            return <?="[{$restaurant->lat},{$restaurant->lng}]"?>;
                        }
                        function zoom() {
                            return 15;
                        }
                    </script>

                </div>


                <div class="col col_3c">
                    <div id="map" class="map"></div>
                    <div class="stock row">
                        <?php foreach ($restaurant->promos as $promo) { ?>
                            <a href="<?= Url::toRoute(['/stock/view', 'id' => $promo->id]) ?>"><img src="<?=(new MyImagePublisher($promo))->MyThumbnail(300,142)?>" alt="<?= $restaurant->address . ' ' . $promo->title; ?>"></a>

                        <?php } ?>

                    </div>
                </div>
            </div>

        </div>

    </div>