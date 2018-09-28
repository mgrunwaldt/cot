<!doctype html>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="es" />
	<link rel="shortcut icon" href="/favicon.ico">
	<link rel="icon" sizes="16x16 32x32 64x64" href="/favicon.ico">
	<link rel="icon" type="image/png" sizes="196x196" href="/favicon-192.png">
	<link rel="icon" type="image/png" sizes="160x160" href="/favicon-160.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96.png">
	<link rel="icon" type="image/png" sizes="64x64" href="/favicon-64.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16.png">
	<link rel="apple-touch-icon" href="/favicon-57.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/favicon-114.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/favicon-72.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/favicon-144.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/favicon-60.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/favicon-120.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/favicon-76.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/favicon-152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/favicon-180.png">
	<meta name="msapplication-TileColor" content="#FFFFFF">
	<meta name="msapplication-TileImage" content="/favicon-144.png">
	<meta name="msapplication-config" content="/browserconfig.xml">
        <meta property="og:title" content="<?php echo $this->pageTitle; ?>" />
        <meta property="og:description" content="<?php echo $this->pageDescription; ?>" />
        <?php foreach($this->pageImages as $pageImage){ ?>
        <meta property="og:image" content="<?php echo $pageImage; ?>" />
        <?php } ?>
        <meta name=viewport content="width=device-width, initial-scale=1">
        
        <title><?php echo $this->pageTitle; ?></title>
        <link href="/css/reset.css" rel="stylesheet" type="text/css">
        <link href="/css/main.css" rel="stylesheet" type="text/css">
        <link href="/css/layouts/main.css" rel="stylesheet" type="text/css">
        <link href="/css/layouts/mobile.css" rel="stylesheet" type="text/css">
        <script src="/js/jquery/jquery.js"></script>
        <script src="/js/jquery/jquery-ui.js"></script>
        <script type="text/javascript" src="/js/tools.js"></script>
        <script type="text/javascript" src="/js/layouts/main.js"></script>
        <script type="text/javascript" src="/js/layouts/mobile.js"></script>
    </head>

    <body class="font1">
            <input type="hidden" id="nameError" value="<?php echo WebTexts::getValueByName("Debe ingresar nombre"); ?>"/>
            <input type="hidden" id="emailError" value="<?php echo WebTexts::getValueByName("Debe ingresar email"); ?>"/>
            <input type="hidden" id="phoneError" value="<?php echo WebTexts::getValueByName("Debe ingresar telefono"); ?>"/>
            <input type="hidden" id="aboutError" value="<?php echo WebTexts::getValueByName("Debe ingresar asunto"); ?>"/>
            <input type="hidden" id="messageError" value="<?php echo WebTexts::getValueByName("Debe ingresar mensaje"); ?>"/>
            <input type="hidden" id="internetError" value="<?php echo WebTexts::getValueByName("Error internet"); ?>"/>
            <input type="hidden" id="invalidEmail" value="<?php echo WebTexts::getValueByName("Email invalido"); ?>"/>
            
            <input type="hidden" id="isMobile" value="1"/>
            <div id="headerDummy"></div>
            <div id="menuDiv" class="backgroundColor2">
                <div id="menuWrapper">        
                    <a href='/Site/viewLocation'>
                        <div class="mobileMenuItem"><?php echo WebTexts::getValueByName("Localizacion"); ?></div>
                    </a>
                    <a href="/Site/viewSpirit">
                        <div class="mobileMenuItem"><?php echo WebTexts::getValueByName("Espiritu"); ?></div>
                    </a>
                    <a href="/Site/viewServices">
                        <div class="mobileMenuItem"><?php echo WebTexts::getValueByName("Servicios"); ?></div>
                    </a>
                    <a href="/Site/viewInvestment">
                        <div class="mobileMenuItem" style="border-bottom:none;"><?php echo WebTexts::getValueByName("Inversion"); ?></div>
                    </a>
                </div>
            </div>
            <?php 
                echo $content;
            ?>
            <div id="footerDummy"></div>
            <div id="header" class="color3">
                <div class="centeredContent">
                    <img id="headerMenuIcon" src="/files/layouts/mobileMenuIcon.png"/>
                    <a href="/Site/index">
                        <img id="headerMenuLogo" src="/files/layouts/logo.png"/>
                    </a>
                    <div id="headerContactInfoButton" class="color2 backgroundColor5 font3"><?php echo WebTexts::getValueByName("Contacto"); ?></div>
                </div>
            </div>
                
            <div id="footer" class="backgroundColor2 color2 font3">
                <div id="footerContainer" class="centeredContent">
                    <div id="footerCol1">
                        <div class="footerRow1">Alejandro Schroeder 6558</div>
                        <div class="footerRow2">Montevideo | Uruguay</div>
                    </div>
                    <div id="footerCol3">
                        <div class="footerRow1">Tel: 2604 2078</div>
                        <div class="footerRow2">Cel: +598 99 51 71 81 - +598 94 40 89 79</div>
                    </div>
                </div>
            </div>
            
            
            <div id="contactDiv" class="backgroundColor5">
                <img id="contactLogo" src="/files/layouts/contactLogo.png"/>
                <input type="text" id="contactName" class="contactInput font3" placeholder="<?php echo WebTexts::getValueByName("Nombre"); ?>"/>
                <input type="text" id="contactEmail" class="contactInput font3" placeholder="<?php echo WebTexts::getValueByName("Email"); ?>"/>
                <input type="text" id="contactPhone" class="contactInput font3" placeholder="<?php echo WebTexts::getValueByName("Telefono"); ?>"/>
                <input type="text" id="contactAbout" class="contactInput font3" placeholder='<?php echo WebTexts::getValueByName("Asunto"); ?>'/>
                <textarea id="contactMessage" class="contactInput font3" placeholder='<?php echo WebTexts::getValueByName("Mensaje"); ?>'></textarea>
                <div id="contactSend" class="font2">
                    <?php echo WebTexts::getValueByName("Enviar"); ?>
                    <img id="contactSendImg" src="/files/layouts/contactSend.png"/>
                </div>
            </div>
            <div id="loaderFixedContainer">
                <div id="loaderDivContainer">
                    <div class="blackOpacity"></div>
                    <div id="loaderDiv">
                        <img src="/files/loader.gif" width="40" height="40"/>
                    </div>
                </div>
            </div>
            <div id="alertMessageFixedContainer">
                <div id="alertMessageDivContainer">
                    <div class="whiteOpacity"></div>
                    <div id="alertMessageDiv">
                        <div id="alertMessageLogoDiv">
                            <img id="alertMessageLogo" src="/files/layouts/logo.png"/>
                        </div>
                        <div id="alertCloseButton" class="alertMessageCloseMessage">X</div>
                        <div id="alertMessageMessage"></div>
                        <div id="alertMessageAceptarWrapper"><div id="alertMessageAceptar" class="normalButton"><?php echo WebTexts::getValueByName("Aceptar"); ?></div></div>
                    </div>
                </div>
            </div>
        </body>
</html>