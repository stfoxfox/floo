<?php
use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Url;
$this->title = 'Камни';

?>

	<div class="content">

        <div class="wrapper index product product-style">

            <div class="intro">
                Камни
            </div>

            

            <!--row for 3 columns-->
            <div class="row row-col">
            <?php foreach ($modificators as $index => $product) {
                $product->file_name = $product->photo;     
            ?>
                <div class="col col_3 basket-catalogItem-id" data-id="<?=$product->id;?>">
                    
                    <div class="main-slider-wr-st">
                        <div data-main-slider class="owl-carousel owl-theme main-slider">
                            <?php
                            foreach ($product->modificatorItemImages as $item) {
                            ?>
                                <div><a class="product-link" href="<?=Url::toRoute(['modificator', 'id' => $product->id])?>"> <img src="<?=(new MyImagePublisher($item))->MyThumbnail(600,600,'file_name')?>" alt="<?= $item->text ?>"></a></div>
                            <?php } ?>
                            
                        </div>
                    </div>
                    <div>
                        
                        <a class="product-link" href="<?=Url::toRoute(['modificator', 'id' => $product->id])?>"> 
                            <span class="title icon"><?=$product->title;?></span>
                        </a>
                        
                    </div>
                    <div class="text-intro text-justify" data-height>
                        <?=$product->description;?>
                    </div>                    
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

    <style>
    @media screen and (min-width: 660px){
    .product .product-link img {
        width: 274px !important;
        margin-bottom: 0px;
    }
}

 
    </style>