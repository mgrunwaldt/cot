<link href="/css/site/index.css" rel="stylesheet" type="text/css"/>
<link href="/css/site/indexMobile.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="slick/slick.css"/>
<script type="text/javascript" src="/js/site/indexMobile.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="/js/site/parallax.js"></script>
<script type="text/javascript" src="slick/slick.min.js"></script>

<div id="cover">
    <div id="coverContainer">
        <div class="centeredContent">
            <img id="coverLogoImage" src="/files/layouts/coverLogo.png" alt="roberto logo blanco"/>
            <div id="coverRow2" class="font1">ALGUN TITULO</div>
            <div id="coverRow3" class="font2">EN ROBERTO HACEMOS QUE LAS MARCAS BLA BLA</div>    
        </div>
    </div>
</div>
<div id="aboutUsRoberto">
    <div id="aboutUsRobertoContainer">
        <div class="centeredContent">
            <div id="aboutUsRobertoRow1" class="font1">¿QUIEN ES ROBERTO?</div>
            <div id="aboutUsRobertoRow2" class="font4">Roberto estudio de comunicación se encarga de la creatividad y planificación estratégica de medios para difundir en los diferentes canales de comunicación, sean tradicionales o alternativos.
                Desarrollamos identidad de marca, estartegia de comunicación campañas on y off line, diseño web y estrategia de pauta.
                Hacemos énfasis en cada proyecto para darle la mejor solución a cada cliente.</div>    
        </div>
    </div>
</div>
<!--<div id="buttons" class="shadow">-->

<div id="buttonsContainer" class="parallax-window" data-parallax="scroll" data-image-src="/files/site/parallaxImage.jpg">
    <div class="centeredContent">
        <div class="catGallery"> 
            <div><img id="brandingCategory" class="catImages" src="/files/layouts/catBranding.png" alt="branding"/></div>
            <div><img id="uiuxCategory" class="catImages" src="/files/layouts/catUiux.png" alt="uiux"/></div>
            <div><img id="campaignsCategory" class="catImages" src="/files/layouts/catCampaigns.png" alt="campaigns"/></div>
            <div><img id="socialMediaCategory" class="catImages" src="/files/layouts/catSocialMedia.png" alt="social media"/></div>
        </div>
    </div>

</div>


<div id="portfolio" >
    <div id="portfolioContainer">
        <div class="centeredContent">
            <div id="portfolioSuperiorBarTitle" class="font1 color6">PORTFOLIO</div>
            <div id="portfolioRow2">
                <?php
                $numItems = count($categories);
                $i = 0;
                foreach ($categories as $category) {
                    ?>
                    <div id="portfolioOption<?php echo $category->id; ?>" class="portfolioSuperiorBarOptions font2 color7"><?php echo $category->name; ?></div>
                    <?php
                    if (!( ++$i === $numItems)) {
                        ?><div id="portfolioOptionsSeparator"></div><?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <div id="portfolioRow3">
<?php foreach ($projects as $project) { ?>
            <a href="/Projects/view/<?php echo $project->id . '/' . HelperFunctions::prepareToLink($project->name); ?>">
                <div class="projectContainer">
                    <img class="projectImage" src="<?php echo $project->previewFile->url; ?>" category="<?php echo $project->category_id; ?>"/>
                    <div class="projectImageOverlay">
                        <div class="projectImageText  font2 color5"> <br /><?php echo $project->name; ?></div>
                    </div>

                </div>
            </a>
<?php } ?>
    </div>
</div>
</div>