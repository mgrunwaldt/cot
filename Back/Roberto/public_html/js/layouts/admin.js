var Admin = {};

$(document).ready(
    function() {   
        Admin.bindFunctions();
        Admin.calculateSizesAndPositionsLoop();
    }
);

Admin.bindFunctions = function(){
    $(window).resize(function() {
        Admin.calculateSizesAndPositions();
    });
    
    $('.menuTitleBar').on({
        'mouseover':function(){
            $(this).find('.menuTitleBarBkg').show();
        },
        'mouseout':function(){
            $(this).find('.menuTitleBarBkg').hide();
        },
        'click':function(){
            Admin.toggleSection($(this));
        }
    });
};

Admin.calculateSizesAndPositionsLoop = function(){
    Admin.calculateSizesAndPositions();
    Tools.delay(2000, Admin.calculateSizesAndPositionsLoop);
};

Admin.calculateSizesAndPositions = function(){
    var topBarHeight = 70;
    var menuWidth = 200;
    var contentFooterHeight = 100;
    var adminDataMargins = 50;
    
    var screenHeight = parseFloat($(window).height());
    var screenWidth = parseFloat($(window).width());
    
    if(screenHeight<600)
        screenHeight = 600;
    if(screenWidth<1000)
        screenWidth = 1000;
    
    var contentHeight = parseFloat($('#content').height());
    var maxHeight = screenHeight;
    if(contentHeight+topBarHeight+contentFooterHeight>screenHeight)
        maxHeight = contentHeight+topBarHeight+contentFooterHeight;
    
    $('#topBarDummy').css('width', screenWidth);
    $('#topBar').css('width', screenWidth);
    $('#adminContainer').css('width', screenWidth);
    $('#menu').css('height', maxHeight-topBarHeight);
    $('#menu').css('height', maxHeight-topBarHeight);
    $('#contentContainer').css('width', screenWidth-menuWidth).css('height', maxHeight-topBarHeight);
    
    var adminTitleLine = $('.adminTitleLine');
    if(adminTitleLine.length>0){
        adminTitleLine.css('width',screenWidth-menuWidth-adminDataMargins-adminDataMargins);
    }
};


Admin.toggleSection = function(menuTitleBarObj){
    var itemsContainerObj = menuTitleBarObj.parent().find('.menuItemsContainer');
    var plusSign = menuTitleBarObj.find('.menuTitlePlusSign');
    if(plusSign.html()==='+'){
        var itemsObj = itemsContainerObj.find('.menuItems');
        var newHeight = parseFloat(itemsObj.height());
        itemsContainerObj.stop().animate({'height':newHeight},300);
        plusSign.html('-');
    }
    else{
        itemsContainerObj.stop().animate({'height':0},300);
        plusSign.html('+');
    }
};