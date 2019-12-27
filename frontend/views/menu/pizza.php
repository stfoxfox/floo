<?php
use yii\helpers\Url;
use common\components\MyExtensions\MyImagePublisher;
$this->title = $category->title;

?>

	<div class="content">

        <div class="wrapper index product pizza-style">

            <div class="intro">
                <?= $category->title; ?>
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
                    <div class="text-intro" data-height>
                        <?= $item->description; ?>
                    </div>

                    <div class="controls row">
                        <div class="btn-group number-group">
                            <button data-btn-number type="button" class="btn border btn-number" data-type="minus"></button>
                            <input data-input-number type="text" name="" class="btn border input-number basket-catalogItem-count" value="1" min="1" readonly>
                            <button data-btn-number type="button" class="btn border btn-number" data-type="plus"></button>
                        </div>
                        <div class="rub"><?= empty($item->price_st_st)?'':$item->price_st_st.' руб.'; ?></div>
                        <select data-btn-select class="selectpicker basket-catalogItem-size">
                            <option value="st_st" class="basket-catalogItem-price" data-price="<?= $item->price_st_st ?>">32 см</option>
                            <option value="big_st" class="basket-catalogItem-price" data-price="<?= $item->price_big_st ?>">40 см</option>
                        </select>
                    </div>
                    <div class="set dropup btn-group row">
                        <button class="btn border set-btn" data-toggle="dropdown">
                            Добавить ингредиенты
                        </button>
                        <button class="btn pink set-btn basket-catalogItem-addtocart">
                            в корзину
                        </button>
                        <div class="dropdown-menu" data-dropdown-menu>
                            <button class="close-icon"></button>
                            <div class="scroll" data-scroll>
                                <?php foreach ($item->modificators as $modificator) { ?>
                                <div class="set-list">
                                    <div class="btn-group number-group">
                                        <button data-btn-number type="button" class="btn border btn-number" data-type="minus"></button>
                                        <input data-id="<?=$modificator->id?>" data-input-number type="text" name="" class="btn border input-number basket-modificator-count" value="0" min="0" readonly>
                                        <button data-btn-number type="button" class="btn border btn-number" data-type="plus"></button>
                                    </div>
                                    <div class="set-title"><?= $modificator->title ?></div>
                                </div>
                                <?php } ?>
                            </div>
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