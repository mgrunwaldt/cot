var Index = {};
Index.ratio = 333 / 200;
Index.headerColorShown = false;
Index.animation = false;
Index.lastClickedCategory = -1;

$(document).ready(function () {
    Index.bindFunctions();

    $(window).scroll(function () {
        Index.headerAnimation($(this).scrollTop());
    });

    $(function () {
        $('#portfolioRow2').mixItUp();

    });
    
    $("body").animate({"opacity":"1"}, 500, function(){
       $(window).resize(); 
    });
    Index.resize();
    
    $('#buttonsCol1').fadeOut();
    $('#buttonsCol2').fadeOut();
    $('#buttonsCol3').fadeOut();
    $('#buttonsCol4').fadeOut();
});

$(document).scroll(function () {
    var y = $(this).scrollTop();
    if (y > 560) {
        $('#buttonsCol1').fadeIn();  
        $('#buttonsCol2').delay( 75 ).fadeIn(); 
        $('#buttonsCol3').delay( 150 ).fadeIn(); 
        $('#buttonsCol4').delay( 225 ).fadeIn(); 
    }
});//seguis ACA y llegar al efecto que pidieron, buscar propiedad de bounce?

Index.onload = function() {
  Index.resize();
};

Index.headerAnimation = function (x) {
    console.log(x);
    if (x > 50 && !Index.headerColorShown && !Index.animation) {
        Index.animation = true;
        $("#headerColor").stop().animate({"opacity": "1"}, 300, function () {
            Index.animation = false;
            Index.headerColorShown = true;
        });
    } else if (x <= 50 && Index.headerColorShown && !Index.animation) {
        Index.animation = true;
        $("#headerColor").stop().animate({"opacity": "0"}, 300, function () {
            Index.animation = false;
            Index.headerColorShown = false;
        });
    }
};

Index.bindFunctions = function () {
    $('.parallax-window').parallax({imageSrc: '/files/site/parallaxImage.jpg'});

    
    $(".portfolioSuperiorBarOptions").on({
        "click": function () {
            var id = $(this).attr("id");
            id = id.replace("portfolioOption", ""); 
            var selectedId = $(this).attr("id");
            var selectedId = selectedId.replace("portfolioOption", "");
            $(".projectContainer").each(function(){
                if($(this).attr("category") == id){
                    $(this).attr("data-myorder", "1");
                }else{
                    $(this).attr("data-myorder", Math.floor(Math.random()*(10-2+1)+2));
                }
            });
            if (selectedId == Index.lastClickedCategory) {
                $("#portfolioOption" + selectedId).removeClass("selectedPortfolioOption");
                /*Index.showAllProjects();*/
            } else {
                Index.lastClickedCategory = selectedId;
                var selectedPortfolio = $("#portfolioOption" + id);
                selectedPortfolio.addClass("selectedPortfolioOption");
                selectedPortfolio.siblings().removeClass("selectedPortfolioOption");
                selectedId = selectedId.replace("portfolioOption", "");
                /*Index.showProjectsOfCategory(id);*/
            }
        }
    });

    $(window).resize(function () {
        Index.resize();
    });
    $(".projectContainer").on({
        'mouseenter': function () {
            var projectImage = $(this).find(".projectImage");
            var projectImageOverlay = $(this).find(".projectImageOverlay");
            projectImage.stop().animate({"width": "100%", "height": "100%", "margin-top": "-0%", "margin-left": "-0%"}, 200);
            projectImageOverlay.stop().animate({"opacity": "0.9"}, 200);
        },
        'mouseleave': function () {
            var projectImage = $(this).find(".projectImage");
            var projectImageOverlay = $(this).find(".projectImageOverlay");
            projectImage.stop().animate({"width": "108%", "height": "108%", "margin-top": "-4%", "margin-left": "-4%"}, 200);
            projectImageOverlay.stop().animate({"opacity": "0"}, 200);
        }
    });
    
    $('.parallax-window').parallax({imageSrc: '/files/site/parallaxImage.jpg'});
};

Index.showProjectsOfCategory = function (category) {
    $(".projectContainer").each(function () {
        var project = $(this).find(".projectImage");
        var projectCategory = project.attr("category");
        if (projectCategory == category)
            $(this).animate({'opacity': '1'}, 700, function () {
                $(this).show();
            });
        else
            $(this).animate({'opacity': '0'}, 700, function () {
                $(this).hide();
            });
    });
};

Index.showAllProjects = function () {
    $(".projectContainer").show(2000);
};


Index.resize = function () {
    var screenWidth = $(window).width();
    if (screenWidth < 1024)
        screenWidth = 1024;
    var divisor = 4;
    if ($( window ).width() <  1400) {
        divisor = 3;
    }
    var projectWidth = screenWidth / divisor;
    var projectHeight = projectWidth / Index.ratio;
    $(".projectContainer").css({"height": projectHeight, "width": projectWidth});
    $windowHeight = $(window).height();
    $headerHeight = $("#header").height();
    $arrowHeight = $("#scrollArrow").height();
    var coverHeight = $windowHeight - ($headerHeight + $arrowHeight);
    var coverWidth = "100%";
    $("#coverContainer").css({"height": coverHeight, "width": coverWidth});
};