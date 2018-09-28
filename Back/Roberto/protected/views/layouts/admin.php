<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="es"  xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="es" />
        
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon"> 
        
        <link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700' rel='stylesheet' type='text/css'>
        
	<link href="/css/reset.css" rel="stylesheet" type="text/css"/>
        <link href="/css/jqueryUI.css" rel="stylesheet" type="text/css"/> 
        <link href="/css/main.css" rel="stylesheet" type="text/css"/>
        <link href="/css/layouts/admin.css" rel="stylesheet" type="text/css"/>  
        
        <script src="/js/jquery/jquery.js"></script>
        <script src="/js/jquery/jquery-ui.js"></script>
        
        <script type="text/javascript" src="/js/tools.js"></script>   
        <script type="text/javascript" src="/js/layouts/admin.js"></script>
        
        <link href="/css/Menu.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="/js/Menu.js"></script>
        
        <title><?php echo $this->pageTitle; ?></title>
        <meta name="description" content="<?php echo $this->pageDescription; ?>">
        <meta property="og:title" content="<?php echo $this->pageTitle; ?>">
        <meta property="og:description" content="<?php echo $this->pageDescription; ?>">
        <?php 
            foreach($this->pageImages as $pageImagePath){
        ?>
                <meta property="og:image" content="<?php echo $pageImagePath; ?>">
        <?php
            }
        ?>
</head>

<body class="font1">	
    <div id="topBarDummy"></div>
    <div id="adminContainer">
        <div id="menu" class="backgroundColor3 color2">
            <div id="menuTitles">
                <div class="menuSection">
                    <div class="menuTitleBar">
                        <div class="menuTitleBarBkg"></div>
                        <div class="menuTitleBarContainer">
                            <div class="menuTitleIconContainer">
                                <img class="menuTitleIcon" src="/files/layouts/newsIcon.png" alt="moon ideas categories categorías icon" width="25px" />
                            </div>
                            <a href="/Categories/viewMain">
                                <div class="menuTitleText">Categorias</div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="menuSection">
                    <div class="menuTitleBar">
                        <div class="menuTitleBarBkg"></div>
                        <div class="menuTitleBarContainer">
                            <div class="menuTitleIconContainer">
                                <img class="menuTitleIcon" src="/files/layouts/newsIcon.png" alt="moon ideas categories categorías icon" width="25px" />
                            </div>
                            <a href="/Projects/viewMain">
                                <div class="menuTitleText">Proyectos</div>
                            </a>
                        </div>
                    </div>
                </div>
                <!--<div class="menuSection">
                    <div class="menuTitleBar">
                        <div class="menuTitleBarBkg"></div>
                        <div class="menuTitleBarContainer">
                            <div class="menuTitleIconContainer">
                                <img class="menuTitleIcon" src="/files/layouts/newsIcon.png" alt="moon ideas categories categorías icon" width="25px" />
                            </div>
                            <a href="/Highlights/viewMain">
                                <div class="menuTitleText">Destacados</div>
                            </a>
                        </div>
                    </div>
                </div>-->
                
            </div>
            
        </div>
        <div id="contentContainer" class="backgroundColor4">
            <div id="content">
                <?php echo $content; ?>
            </div>
            <div id="contentFooter" class="backgroundColor7 color1">
                <div id="poweredBy">
                    <img id="moonLogo" src="/files/layouts/moonLogoLight.png">
                    <div id="poweredByText" class="font2 color2">Powered by:</div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="topBar" class="backgroundColor7">
        <div id="topBarLogoContainer">
            <img id="topBarLogo" src="/files/layouts/coverLogo.png">
        </div>
        <div id="accountOptions" >
            <a id="topBarEmail" class="color2" href="/Administrators/viewEdit/<?php echo($this->administrator->id);?>"><?php echo($this->administrator->email);?></a>
            <a id="myProfile" href="/Administrators/viewEdit/<?php echo($this->administrator->id);?>">Mi perfil</a>
            <a id="logout" href="/Site/logout">Cerrar sesión</a>
        </div>
    </div>
    
    
    <div id="loaderFixedContainer">
        <div id="loaderDivContainer">
            <div class="blackBkg50"></div>
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
                        <div id="alertMessageAceptarWrapper"><div id="alertMessageAceptar" class="normalButton"/>Aceptar</div>
                    </div>
                </div>
            </div>
</body>
</html>



 