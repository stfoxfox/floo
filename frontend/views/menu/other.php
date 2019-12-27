<?php
use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Url;
$this->title = $category->title;

?>

	<div class="content">

        <div class="wrapper index product product-style">

            <div class="intro">
                <?=$category->title;?>
            </div>
            <div class = "category"></div>

            <?php if (count($category->tags) > 0) {?>
            <div class="sort">
                <a href="<?=Url::to(['', 'alias' => $alias, 'tag' => null])?>" class="<?=$category->tag == null ? 'active' : '';?>">все</a>
                <?php foreach ($category->tags as $key => $tag) {?>
                    <a href="<?=Url::to(['', 'alias' => $alias, 'tag' => $tag->tag])?>" class="<?=$tag->tag == $category->tag ? 'active' : '';?>"><?=$tag->tag?></a>
                <?php }?>
            </div>
            <?php }?>

            <!--row for 3 columns-->
            <div class="row row-col">
            <?php foreach ($category->catalogItems as $index => $item) {?>
                <div class="col col_3 basket-catalogItem-id" data-id="<?=$item->id;?>">
                    <a href="<?=Url::toRoute(['product', 'id' => $item->id])?>" class="product-link">
                        <img src="<?=(new MyImagePublisher($item))->MyThumbnail(600, 600)?>" alt="<?=$item->title?>">
                        <span  class="title icon-<?=$item->css_class;?>"><?=$item->title;?></span>
                    </a>

                    <?php if (!empty($item->price_st_st)) {?>

                    <div class="set dropup btn-group row">
                        <div class="btn border set-btn">
                            <?=$item->price_big_st;?> руб.
                        </div>
                        <a style="text-decoration: none;" href="<?= Url::toRoute(['/menu/product', 'id' => $item->id]) ?>" class="btn pink set-btn">
                            Заказать
                        </a>


                    </div>
                    <?php } else {?>
                        <div class="set row">
                            <div class="set-col">
                                <div class="gr"></div>
                                <div class="btn-group number-group">
                                    <button data-btn-number="" type="button" class="btn border btn-number" data-type="minus"></button>
                                    <input data-input-number="" type="text" name="" class="btn border input-number basket-catalogItem-count" value="1" min="1" readonly="">
                                    <button data-btn-number="" type="button" class="btn border btn-number" data-type="plus"></button>
                                </div>
                            </div>
                            <div class="set-col">
                                <div class="rub"><?=$item->price?> руб.</div>
                                <button class="btn pink small basket-catalogItem-addtocart">
                                    в корзину
                                </button>
                            </div>
                        </div>
                        <?php }?>
                </div>
            
            <?php if ((int) (($index + 4) % 3) == 0) {?>
            </div>

            <!--row for 3 columns-->
            <div class="row row-col">
			<?php }?>
			<?php }?>

            </div>

        </div>

    </div>