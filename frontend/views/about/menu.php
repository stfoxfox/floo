<?php

use yii\helpers\Url;
$this->title = 'Меню ресторана';

\frontend\assets\AboutAsset::register($this);
?>
	<div class="content about-wr">

        <div class="wrapper index about">


            <h1 class="title">пронто</h1>

            <h2 class="big for-mobile">Меню ресторана</h2>

            <div class="sort m-b50">
                <a href="<?= Url::toRoute(['index', 'id' => null]) ?>">о компании</a>
                <a href="<?= Url::toRoute(['menu', 'id' => null]) ?>" class="active">меню ресторана</a>
                <a href="<?= Url::toRoute(['partners', 'id' => null]) ?>">партнерам</a>
                <a href="<?= Url::toRoute(['reviews', 'id' => null]) ?>">отзывы</a>
                <a href="<?= Url::toRoute(['vacancies', 'id' => null]) ?>">вакансии</a>
                <a href="<?= Url::toRoute(['contacts', 'id' => null]) ?>">контакты</a>
            </div>
            

        </div>

    </div>