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
    $('.catGallery').slick({
        autoplay: true,
        autoplaySpeed: 1600,
        arrows: true,
        prevArrow: '<img class="slick-prev" src="/files/layouts/leftArrow.png" style="display: inline;height: 50px;position: absolute;margin-top: 160px;margin-left: 10px; z-index:2;" />',
        nextArrow: '<img class="slick-next" src="/files/layouts/rightArrow.png"" style="display: inline;height: 50px;position: relative;margin-top: -194px; float:right; ;margin-right: 10px; z-index:2;"/>'
    });
    /*Index.resize();*/
});
//style="display: inline;height: 50px;position: absolute;margin-top: 160px;margin-left: 10px;"


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
    $(".portfolioSuperiorBarOptions").on({
        "click": function () {
            var id = $(this).attr("id");
            if (id == Index.lastClickedCategory) {
                $("#" + id).removeClass("selectedPortfolioOption");
                Index.showAllProjects();
            } else {
                Index.lastClickedCategory = id;
                var selectedPortfolio = $("#" + id);
                selectedPortfolio.addClass("selectedPortfolioOption");
                selectedPortfolio.siblings().removeClass("selectedPortfolioOption");
                id = id.replace("portfolioOption", "");
                Index.showProjectsOfCategory(id);
            }
        }
    });

    /*$(window).resize(function () {
     Index.resize();
     });*/

    /*$(".projectContainer").on({
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
     });*/

    $('.parallax-window').parallax({imageSrc: '/files/site/parallaxImage.jpg'});
};

Index.showProjectsOfCategory = function (category) {
    $(".projectContainer").each(function () {
        var project = $(this).find(".projectImage");
        var projectCategory = project.attr("category");
        if (projectCategory == category)
            $(this).animate({'opacity':'1'}, 700, function(){
               $(this).show(); 
            });
        else
            $(this).animate({'opacity':'0'}, 700, function(){
               $(this).hide(); 
            });
    });
};

Index.showAllProjects = function () {
    $(".projectContainer").show(2000);
};


/*Index.resize = function () {
 var screenWidth = $(window).width();
 if (screenWidth < 1024)
 screenWidth = 1024;
 var projectWidth = screenWidth / 3;
 var projectHeight = projectWidth / Index.ratio;
 $(".projectContainer").css({"height":projectHeight, "width":projectWidth});
 };*/