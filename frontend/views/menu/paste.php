<?php
use yii\helpers\Url;
use common\components\MyExtensions\MyImagePublisher;
$this->title = $category->title;

?>

    <div class="content">

        <ul id="parallax" class="parallax">
            <li class="layer" data-depth="0.04">
                <div class="wrapper">
                    <div class="background _3"></div>
                </div>
            </li>
            <li class="layer" data-depth="0.06">
                <div class="wrapper">
                    <div class="background _1"></div>
                </div>
            </li>
            <li class="layer" data-depth="0.1">
                <div class="wrapper">
                    <div class="background _6"></div>
                </div>
            </li>
        </ul>

        <div class="wrapper index product paste-style">

            <div class="intro">
                Паста
            </div>

            <?php if(count($category->tags) > 0) { ?>
            <div class="sort">
                <a href="<?= Url::to(['', 'alias' => $alias, 'tag' => null]) ?>" class="<?= $category->tag==null?'active':''; ?>">все</a>
                <?php foreach ($category->tags as $key => $tag) { ?>
                    <a href="<?= Url::to(['', 'alias' => $alias, 'tag' => $tag->tag]) ?>" class="<?= $tag->tag==$category->tag?'active':''; ?>"><?= $tag->tag ?></a>
                <?php } ?>
            </div>
            <?php } ?>

            <!--row for 3 columns-->
            <div class="row row-col">
            <?php foreach ($category->catalogItems as $index => $item) { ?>
                <div class="col col_3 basket-catalogItem-id" data-id="<?= $item->id; ?>">
                    <a href="<?= Url::toRoute(['product', 'id' => $item->id]) ?>" class="product-link">
                        <img src="<?=(new MyImagePublisher($item))->MyThumbnail(600,600)?>" alt="<?= $item->title ?>">
                        <span  class="title icon-<?= $item->css_class; ?>"><?= $item->title; ?></span>
                    </a>
                    <div class="text-intro" data-height><?= $item->description; ?></div>

                    <div class="set row">
                        <div class="set-col">

                            <div class="gr"><?= $item->packing_weights ?></div>

                            <div class="btn-group number-group">
                                <button data-btn-number type="button" class="btn border btn-number" data-type="minus"></button>
                                <input data-input-number type="text" name="" class="btn border input-number basket-catalogItem-count" value="1" min="1" readonly>
                                <button data-btn-number type="button" class="btn border btn-number" data-type="plus"></button>
                            </div>

                        </div>

                        <div class="set-col">

                            <div class="rub"><?= empty($item->price)?'':$item->price.' руб.'; ?></div>

                            <button class="btn pink small basket-catalogItem-addtocart">
                                в корзину
                            </button>

                        </div>

                    </div>
                </div>
            <?php if((int)(($index+4) % 3) == 0) { ?>
            </div>

            <!--row for 3 columns-->
            <div class="row row-col">
            <?php } ?>
            <?php } ?>

            </div>

        </div>

    </div>
