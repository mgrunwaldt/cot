<link href="/css/site/services.css" rel="stylesheet" type="text/css">
<?php if($this->isMobile){ ?>
<link href="/css/site/mobileServices.css?v=2" rel="stylesheet" type="text/css">
<?php } ?>
<input type='hidden' id='contactArea' value='0'/>
<div class='content'>
    <div class='centeredContent'>
        <div class='highlightImageDiv'>
            <img class='highlightImage' src='/files/site/servicios.jpg'/>
            <div class='infoContainer'>
                <img class='sierrasLogo' src='/files/layouts/contactLogo.png'/>
                <div class='sierrasText'><?php echo WebTexts::getValueByName("Servicio texto imagen"); ?></div>
            </div>
        </div>
        <div class='highlightCaption backgroundColor6'>
            <img class='highlightCaptionImage' src='/files/site/redLogo.png'/>
            <div class='highlightCaptionText'>
                <?php echo WebTexts::getValueByName("Servicio pie imagen"); ?>
            </div>
        </div>
        <div class='columnsText color4'>
            <?php echo WebTexts::getValueByName("Servicio columnas"); ?>
        </div>
        <div class="redHighlights">
            <div class="redHighlight leftHighlight backgroundColor2">
                <img class="redHighlightLogo" src="/files/layouts/contactLogo.png"/>
                <?php echo WebTexts::getValueByName("Servicio recuadro izq"); ?>
            </div>
            <div class="redHighlight leftHighlight backgroundColor2" <?php if(!$this->isMobile) echo 'style="margin-left:2%;"'; ?>>
                <img class="redHighlightLogo" src="/files/layouts/contactLogo.png"/>
                <?php echo WebTexts::getValueByName("Servicio recuadro der"); ?>
            </div>
        </div>
        <div class='pairedImages'>
            <div class='leftImg'>
                <img class="bottomImg" src='/files/site/servicioImg1.jpg'/>
                <div class="imageInfo">
                    <img class="imageLogo" src="/files/layouts/contactLogo.png"/>
                    <div class="infoText"><?php echo WebTexts::getValueByName("Servicio foto 1"); ?></div>
                </div>
            </div>
            <div class='rightImg'>
                <img class="bottomImg" src='/files/site/servicioImg2.jpg'/>
                <div class="imageInfo">
                    <img class="imageLogo" src="/files/layouts/contactLogo.png"/>
                    <div class="infoText"><?php echo WebTexts::getValueByName("Servicio foto 2"); ?></div>
                </div>
            </div>
            <div class='leftImg'>
                <img class="bottomImg" src='/files/site/servicioImg3.jpg'/>
                <div class="imageInfo">
                    <img class="imageLogo" src="/files/layouts/contactLogo.png"/>
                    <div class="infoText"><?php echo WebTexts::getValueByName("Servicio foto 3"); ?></div>
                </div>
            </div>
            <div class='rightImg'>
                <img class="bottomImg" src='/files/site/servicioImg4.jpg'/>
                <div class="imageInfo">
                    <img class="imageLogo" src="/files/layouts/contactLogo.png"/>
                    <div class="infoText"><?php echo WebTexts::getValueByName("Servicio foto 4"); ?></div>
                </div>
            </div>
        </div>
        <div id="wineTitle" class="backgroundColor2">
            <?php echo WebTexts::getValueByName("Servicio titulo vino"); ?>
        </div>
        <img id="wineImg" src="/files/site/servicioImg5.jpg"/>
        
        <img id="brownLogo" src="/files/site/brownLogo.png"/>
        <div id="wineSubtitle" class="color4">
             <?php echo WebTexts::getValueByName("Servicio subtitulo vino"); ?>
        </div>
        <div id="wineText" class="color4">
             <?php echo WebTexts::getValueByName("Servicio texto vino"); ?>
        </div>
        <img id="familyLogo" src="/files/site/familiaDeicas.jpg"/>
    </div>
</div>