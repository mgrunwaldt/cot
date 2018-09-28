<?php
if ($this->isMobile) {
    ?><script type="text/javascript" src="/js/tools/MMGalleryMobile.js"></script>
    <link href="/css/tools/MMGalleryMobile.css" rel="stylesheet" type="text/css"/>
<?php } else {
    ?><script type="text/javascript" src="/js/tools/MMGallery.js"></script>
    <link href="/css/tools/MMGallery.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="/css/tools/fullsizable.css" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="/js/tools/jquery.fullsizable.js" type="text/javascript"></script>
<?php } ?>




<div id="MMFiles">
    <div class="MMFilesItem" style="">
        <a class="MMFilesItemImageA" href=""> 
            <img class="MMFilesItemImage" src=""/>
        </a>
    </div>
</div>

<?php
if (!$this->isMobile) {
    $this->renderPartial('/tools/thumbnails', array('files' => $files));
} else {
    ?>
    <div id="MMFilesNumbers"></div>
<?php }
?>
<!--<div id="MMFilesNumbers"></div>
<img id="MMRightArrow" src="/files/saleModels/rightArrow.png" alt="mistral right arrow"/>
<img id="MMLeftArrow" src="/files/saleModels/leftArrow.png" alt="mistral left arrow"/>-->
<input type="hidden" id="MMFilesHidden" value='<?php echo json_encode($files); ?>'/>