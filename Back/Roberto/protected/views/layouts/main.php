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
        <?php foreach ($this->pageImages as $pageImage) { ?>
            <meta property="og:image" content="<?php echo $pageImage; ?>" />
        <?php } ?>

        <title><?php echo $this->pageTitle; ?></title>
        <link href="/css/reset.css" rel="stylesheet" type="text/css">
        <link href="/css/main.css" rel="stylesheet" type="text/css">
        <link href="/css/layouts/main.css?v=2" rel="stylesheet" type="text/css">

        <script src="/js/jquery/jquery.js"></script>
        <script src="/js/jquery/jquery-ui.js"></script>
        <script type="text/javascript" src="/js/tools.js"></script>
        <script type="text/javascript" src="/js/layouts/main.js"></script>
    </head>

    <body class="font1">
        <input type="hidden" id="nameError" value="Debe ingresar nombre"/>
        <input type="hidden" id="emailError" value="Debe ingresar email"/>
        <input type="hidden" id="phoneError" value="Debe ingresar telefono"/>
        <input type="hidden" id="aboutError" value="Debe ingresar asunto"/>
        <input type="hidden" id="messageError" value="Debe ingresar mensaje"/>
        <input type="hidden" id="internetError" value="Error internet"/>
        <input type="hidden" id="invalidEmail" value="Email invalido"/>
        
        <?php
        echo $content;
        ?> 
        <div id="header" >
            <div id="headerContainer">
                <div id="headerColor"></div>
                <div class="centeredContent">
                    <div id="headerSuperiorMenu" class="font1">
                        <img id="headerSuperiorMenuImage" src="/files/layouts/headerFooterLogo.png" alt="logo blanco footer" onclick="window.location.href='/index.php'"> 
                        <div id="headerSuperiorMenuCol4" class="headerMenuOptions font6 color2" href="contact">CONTACTO</div>
                        <div id="headerSuperiorMenuCol3" class="headerMenuOptions font6 color2" href="portfolio">TRABAJOS</div>
                        <div id="headerSuperiorMenuCol2" class="headerMenuOptions font6 color2" href="about">NOSOTROS</div>
                        
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div id="footerDummy"></div>
        <div id="footer">
            <div id="footerContainer">
                <div class="centeredContent">
                    <div id="footerCol1">
                        <div class="footerRow1 font1 color2">MONTEVIDEO - URUGUAY</div>
                        <div class="footerRow2 font2 color2">Eduardo Acevedo 1023</div>
                        <div class="footerRow3 font2 color2">Tel.: (+598) 99 875 994 <br /><br /> nacho@roberto.uy</div>

                    </div>
                    <img id="footerLogoImage" src="/files/layouts/footerImage.png" alt="roberto logo blanco"/>
                    <div id="footerCol3">
                        <input type="text" id="contactName" class="contactInput font3" value="Nombre"/>
                        <input type="text" id="contactEmail" class="contactInput font3" value="Email"/>
                        <textarea id="contactMessage" class="contactInput font3">Escríbanos...</textarea>
                        <div id="contactSend" class="font1 grow">
                            ENVIAR
                        </div>
                    </div>
                </div>
            </div>
            <div id="footerInferiorBar">
                <img id="footerInferiorBarCol1" src="/files/layouts/headerFooterLogo.png" alt="logo blanco footer"> 
                <div id="footerInferiorBarCol2" class="footerInferiorBarOptions font5 color2" href="about">About Us</div>
                <div id="footerInferiorBarCol3" class="font5 color2">|</div>
                <div id="footerInferiorBarCol4" class="footerInferiorBarOptions font5 color2" href="portfolio">Portfolio</div>
                <div id="footerInferiorBarCol5" class="font4 color2">Roberto.uy © 2016. All rights reserved.</div>
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
                    <div id="alertMessageAceptarWrapper"><div id="alertMessageAceptar" class="normalButton">Aceptar</div></div>
                </div>
            </div>
        </div>
    </body>
</html>