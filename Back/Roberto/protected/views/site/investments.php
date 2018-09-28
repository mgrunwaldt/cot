<link href="/css/site/investments.css" rel="stylesheet" type="text/css">
<?php if($this->isMobile){ ?>
<link href="/css/site/mobileInvestments.css?v=2" rel="stylesheet" type="text/css">
<?php } ?>
<script type="text/javascript" src="/js/site/investments.js"></script>
<input type='hidden' id='contactArea' value='0'/>
<div class='content'>
    <div class='centeredContent'>
        <div class='highlightImageDiv'>
            <img class='highlightImage' src='/files/site/inversion.jpg'/>
            <div class='infoContainer'>
                <img class='sierrasLogo' src='/files/layouts/contactLogo.png'/>
                <div class='sierrasText'><?php echo WebTexts::getValueByName("Inversion texto imagen"); ?></div>
            </div>
        </div>
        <div class='highlightCaption backgroundColor6'>
            <img class='highlightCaptionImage' src='/files/site/redLogo.png'/>
            <div class='highlightCaptionText'>
                <?php echo WebTexts::getValueByName("Inversion pie imagen"); ?>
            </div>
        </div>
        <div id='description' class='color4'>
            <?php echo WebTexts::getValueByName("Inversion texto descripcion"); ?>
        </div>
        <select id='ranchSelect'>
            <option value='0' selected disabled><?php echo WebTexts::getValueByName("Seleccione una chacra");?></option>
            <?php foreach($ranches as $ranch)
            {
                echo("<option value='".$ranch->id."'>".$ranch->name.'</option>');
            }
            ?>
        </select>
        <img id='map' src='/files/site/inversionMapa.jpg'/>
    </div>
</div>