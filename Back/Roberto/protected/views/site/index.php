<link href="/css/site/index.css" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="http://cdn.jsdelivr.net/jquery.mixitup/latest/jquery.mixitup.min.js"></script>
<script type="text/javascript" src="/js/site/index.js"></script>
<script src="/js/site/parallax.js"></script>


<div id="cover">
    <div id="coverContainer">
        <div class="centeredContent">
            <img id="coverLogoImage" src="/files/layouts/coverLogo.png" alt="roberto logo blanco"/>
            <div id="coverRow2" class="font1">UN ESTUDIO DE COMUNICACIÓN</div>
            <div id="coverRow3" class="font2">CON NOMBRE PROPIO Y AMOR POR LAS IDEAS</div>    
        </div>
    </div>
</div>
<div id="aboutUsRoberto">
    <div id="aboutUsRobertoContainer">
        <div class="centeredContent">
            <div id="aboutUsRobertoRow1" class="font1">¿QUIÉN ES ROBERTO?</div>
            <div id="aboutUsRobertoRow2" class="font2">ROBERTO ESTUDIO DE COMUNICACIÓN SE ENCARGA DE DESARROLLAR IDENTIDADES DE MARCA,<br/>ESTRATEGIAS DE COMUNICACIÓN, CAMPAÑAS ON Y OFF LINE Y DISEÑO UI/UX. HACEMOS ÉNFASIS EN<br/>CADA PROYECTO PARA DARLE LA MEJOR SOLUCIÓN A CADA CLIENTE.</div>    
        </div>
    </div>
</div>
<!--<div id="buttons" class="shadow">-->

<div id="buttonsContainer" class="parallax-window" data-parallax="scroll" data-image-src="/files/site/parallaxImage.jpg">
    <div class="centeredContent">
        <div id="buttonsCol1" class="buttonsCol">
            <img class="buttons" class="font1" src="/files/layouts/brandingButton.png">
            <div class="titles">BRANDING</div>
        </div>          
        <div id="buttonsCol2" class="buttonsCol">
            <img class="buttons" class="font1" src="/files/layouts/designButton.png">
            <div class="titles">UI | UX DESIGN</div>
        </div>
        <div id="buttonsCol3" class="buttonsCol">
            <img class="buttons" class="font1" src="/files/layouts/campaignsButton.png">
            <div class="titles">CAMPAÑAS</div>
        </div>
        <div id="buttonsCol4" class="buttonsCol">
            <img class="buttons" class="font1" src="/files/layouts/socialMediaButton.png">
            <div class="titles">SOCIAL MEDIA</div>
        </div>
    </div>
</div>

<div id="portfolio" >
    <div id="portfolioContainer">
        <div class="centeredContent">
            <div id="portfolioRow1">
                <div id="portfolioSuperiorBarTitle" class="font1 color6">PORTFOLIO</div>
                <div id="portfolioSuperiorBarSubTitle" class="font1 color7">ORDENAR POR:</div>
                <?php foreach ($categories as $category) { ?>
                    <div id="portfolioOption<?php echo $category->id; ?>" class="portfolioSuperiorBarOptions sort font2 color7" data-sort="myorder:asc"><?php echo $category->name; ?></div>
                <?php } ?>
            </div>
        </div>
        <div id="portfolioRow2">
            <?php foreach ($projects as $project) { ?>
                <a href="/Projects/view/<?php echo $project->id . '/' . HelperFunctions::prepareToLink($project->name); ?>" class="projectContainer mix <?php echo $project->category_id; ?>" category="<?php echo $project->category_id; ?>" data-myorder="0">
                    <img class="projectImage" src="<?php echo $project->previewFile->url; ?>"/>
                    <div class="projectImageOverlay">
                        <div class="projectImageText font1 color5"> <?php echo $project->client; ?></div>
                        <div class="projectImageSubText  font2 color2"> <br/><?php echo $project->name; ?></div>
                        <img class="projectInfoButton" src="/files/layouts/plusButtonProject.png"/>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>
</div>