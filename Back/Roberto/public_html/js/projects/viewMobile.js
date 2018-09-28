var View = {};
View.files;
View.gallery;
View.menuOpen = false;

$(document).ready(function(){
    $("#headerColor").css("opacity","1");
    
    $('.projectGallery').slick({
        autoplay: true,
        autoplaySpeed: 2500,
        prevArrow: '<img class="slick-prev" src="/files/layouts/leftArrow.png" style="display: block;height: 35px;position: absolute;margin-left: 12px; z-index:2; bottom: 12px;"/>',
        nextArrow: '<img class="slick-next" src="/files/layouts/rightArrow.png"" style="display: block;height: 35px;position: relative; float:right; ;margin-right: 18px; z-index:2; bottom: 46px;"/>',
    });
    
    $("#coverMenuIcon").click(function () {
        View.toggleContact();
    });
});

View.getFiles = function(){
    View.files = $.parseJSON($("#filesForJS").html());
};

View.toggleContact = function () {
    if (!View.menuOpen) {
        $("#header").stop().animate({"height": "273px"}, 800);
    
        View.menuOpen = true;
    } else {
        $("#header").stop().animate({"height": "48px"}, 800);
        View.menuOpen = false;
    }
};