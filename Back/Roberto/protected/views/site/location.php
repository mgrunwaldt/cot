<script src="https://maps.googleapis.com/maps/api/js"></script>
<script type='text/javascript' src='/js/site/location.js'></script>
<link href="/css/site/location.css" rel="stylesheet" type="text/css">
<?php if($this->isMobile){ ?>
<link href="/css/site/mobileLocation.css" rel="stylesheet" type="text/css">
<?php } ?>
<input type='hidden' id='contactArea' value='0'/>
<div class='content'>
    <div class='centeredContent'>
        <div class='highlightImageDiv'>
            <img class='highlightImage' src='/files/site/location.jpg'/>
            <div class='infoContainer'>
                <img class='sierrasLogo' src='/files/layouts/contactLogo.png'/>
                <div class='sierrasText'><?php echo WebTexts::getValueByName("Localizacion texto imagen"); ?></div>
            </div>
        </div>
        <div class='highlightCaption backgroundColor6'>
            <img class='highlightCaptionImage' src='/files/site/redLogo.png'/>
            <div class='highlightCaptionText'>
                <?php echo WebTexts::getValueByName("Localizacion pie imagen"); ?>
            </div>
        </div>
        <div class='columnsText color4'>
            <?php echo WebTexts::getValueByName("Localizacion columnas"); ?>
        </div>
        <div id="locationMaps">
            <img id='locationMap' src='/files/site/locationMap.png'/>
            <div id='locationGoogleMap'>
                <div id='map-canvas'></div>
            </div>
        </div>
        <div id='googleMapsDiv' class='backgroundColor2'>
            <div id='googleMapsButton' class='font4'><?php echo WebTexts::getValueByName("Localizacion google maps"); ?></div>
        </div>
        <div class='pairedImages'>
            <img class='leftImg' src='/files/site/locationImg1.jpg'/>
            <img class='rightImg' src='/files/site/locationImg2.jpg'/>
            <img class='leftImg' src='/files/site/locationImg3.jpg'/>
            <img class='rightImg' src='/files/site/locationImg4.jpg'/>
        </div>
    </div>
</div>