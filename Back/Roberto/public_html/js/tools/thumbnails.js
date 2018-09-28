var Carousell = {};
Carousell.left = 0;
Carousell.visibleElements = 3;
Carousell.block = false;
Carousell.imgWidth = 148;
Carousell.quantity = 0;
Carousell.leftLimit = 0;
Carousell.imagesMargin = 9;
Carousell.start = function () {
    Carousell.leftLimit = Carousell.imgWidth * (Carousell.quantity - Carousell.visibleElements);
    if (Carousell.quantity < 4) {
        $("#carousellLeftArrow").css("display", "none");
        $("#carousellRightArrow").css("display", "none");
    }

    $("#carousellLeftArrow").on("click", function () {
        if (Carousell.left > -Carousell.leftLimit) {
            if (!Carousell.block) {
                if (Carousell.left === 0) {
                    $("#carousellRightArrow").animate({'opacity': '1'}, 600);
                }
                Carousell.left -= Carousell.imgWidth;
                Carousell.block = true;
                $("#carouselleImagesContainer").animate({"left": Carousell.left - Carousell.imagesMargin}, 600, function () {
                    Carousell.block = false;
                });
                if (Carousell.left === -Carousell.leftLimit) {
                    $("#carousellLeftArrow").animate({'opacity': '0.35'}, 600);
                }
            }
        }
    });
    $("#carousellRightArrow").on("click", function () {
        if (Carousell.left < 0) {
            if (!Carousell.block) {
                if (Carousell.left === -Carousell.leftLimit) {
                    $("#carousellLeftArrow").animate({'opacity': '1'}, 600);
                }
                Carousell.left += Carousell.imgWidth;
                Carousell.block = true;
                $("#carouselleImagesContainer").animate({"left": Carousell.left}, 500, function () {
                    Carousell.block = false;
                });
                if (Carousell.left === 0) {
                    $("#carousellRightArrow").animate({'opacity': '0.35'}, 600);
                }
            }
        }
    });
};
Carousell.placeFiles = function (files) {
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var url = 'https://img.youtube.com/vi/' + files[i]['url'] + '/mqdefault.jpg';
        if (file.file_type_id == 1) {
            $("#carouselleImagesContainer").append("<div id='MMGalleryItem" + (i + 1) + "' class='MMGalleryItemWrapper'><img class='MMGalleryImage' src='" + files[i]['url'] + "'/></div>");
        } else if (file.file_type_id == 2 || file.file_type_id == 4) {
            $("#carouselleImagesContainer").append("<div id='MMGalleryItem" + (i + 1) + "' class='MMGalleryItemWrapper'><img class='MMGalleryImage' src='" + url + "'/></div>");
        }

    }
    $("#carouselleImagesContainer").width(files.length * (Carousell.imgWidth + 9));
    Carousell.quantity = files.length;
    Carousell.start();
};
