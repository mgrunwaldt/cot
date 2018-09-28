<link href="/css/tools/thumbnails.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/js/tools/thumbnails.js"></script>

<input id="filesQuantity" type="hidden" value="<?php echo count($files);?>"/>
    
<div id="thumbnailsCarousell">
    <img id="carousellLeftArrow" src="/files/site/sliderLeftArrow.png"/>
    <img id="carousellRightArrow" src="/files/site/sliderRightArrow.png"/>
    <div id="carousellVisibleZone">
        
        <?php $containerWidth=count($files)*155;?>
        
        <div id="carouselleImagesContainer" style="width:<?php echo $containerWidth;?>px;">
            
            <?php 
                foreach($files as $file){
                        $url=$file->url;
                    ?>
<!--                    <div class="carousellImgContainer">
                        <img class="MMGalleryImage" src="<?php //echo $url; ?>"/>
                    </div>-->
            <?php 
                }
            ?>
            
        </div>
    </div>
</div>