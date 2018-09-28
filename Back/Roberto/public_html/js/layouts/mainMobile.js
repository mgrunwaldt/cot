var Main = {};
Main.administrator = 0;
Main.isMobile = false;
Main.menuOpen = false;
Main.headerHeight = 0;

$(document).ready(
        function () {
            if ($('#isMobile').length > 0)
                Main.isMobile = true;


            if (!Main.isMobile) {
                Tools.delay(500, Main.resize);
                $(window).resize(function () {
                    Main.resize();
                });
            }
            Main.bindFunctions();
            
        }
);


Main.resize = function () {
};

Main.bindFunctions = function () {   
    $("#coverMenuIcon").on({
        'mouseclick': function () {
            $(this).stop().animate({"opacity": "0"}, 800);
        }
    });
    $("#contactSend").click(function () {
        Main.sendContact();
    });
    $('#contactMessage').keyup(function (e) {
        if (e.keyCode == 13)
        {
            Main.sendContact();
        }
    });
    $("#coverMenuIcon").click(function () {
        Main.toggleContact();
    });

    $("#aboutMenu").on({
        "click": function () {
            Main.scrollToAbout();
        }
    });
    $("#portfolioMenu").on({
        "click": function () {
            Main.scrollToPortfolio();
        }
    });
     $("#contactMenu").on({
        "click": function () {
            Main.scrollToContact();
        }
    });

    Main.contactPlaceholders();
};

Main.scrollToAbout = function () {
    $('html, body').animate({
        scrollTop: $("#aboutUsRobertoContainer").offset().top - Main.headerHeight
    }, 400);
};

Main.scrollToPortfolio = function () {
    $('html, body').animate({
        scrollTop: $("#portfolioContainer").offset().top - Main.headerHeight
    }, 400);
};

Main.scrollToContact = function () {
    $('html, body').animate({
        scrollTop: $("#footerContainer").offset().top
    }, 400);
};

Main.scrollToSection = function scrollTo(hash) {
    location.hash = "#" + hash;
}

Main.toggleContact = function () {
    if (!Main.menuOpen) {
        $("#coverMenuIcon").attr('src', "/files/layouts/menuIconOpen.png");
        $("#headerSuperiorDesplegableMenu").stop().animate({"height": "225px"}, 800);
        $("#coverLogoImage").stop().animate({"opacity": "0"}, 800);
        
        Main.menuOpen = true;
    } else {
        $("#coverMenuIcon").attr('src', "/files/layouts/menuIcon.png");
        $("#headerSuperiorDesplegableMenu").stop().animate({"height": "0px"}, 800);
        $("#coverLogoImage").stop().animate({"opacity": "1"}, 800);
        Main.menuOpen = false;
    }
};

Main.sendContact = function () {
    var message = {};
    message.name = $("#contactName").val().trim();
    message.email = $("#contactEmail").val().trim();
    message.message = $("#contactMessage").val().trim();
    if (message.name.length > 0 && message.name !== "Nombre") {
        if (message.email.length > 0 && message.email !== "Email") {
            if (Tools.validateEmail(message.email)) {
                if (message.message.length > 0 && message.message !== "Escríbanos...") {
                    message.area = $("#contactArea").val();
                    var code = Tools.showLoading();
                    $.ajax({
                        url: '/ContactMessages/send',
                        type: 'POST',
                        data: {message: message},
                        success: function (response) {
                            Tools.removeLoading(code);
                            response = $.parseJSON(response);
                            if (response.status == "ok") {
                                Tools.alert(response.message);
                                Main.cleanContact();
                                Main.toggleContact();
                            } else {
                                Tools.alert(response.errorMessage);
                            }
                        },
                        error: function () {
                            Tools.removeLoading(code);
                            Tools.alert($("#internetError").val());
                        }
                    });
                } else {
                    Tools.alert("Debe ingresar un mensaje.");
                }
            } else {
                Tools.alert("El e-mail debe ser válido.");
            }
        } else {
            Tools.alert("Debe ingresar un e-mail.");
        }
    } else {
        Tools.alert("Debe ingresar un nombre.");
    }
};

Main.cleanContact = function () {
    $("#contactName").val("Nombre");
    $("#contactEmail").val("Email");
    $("#contactMessage").val("Escríbanos...");
};

Main.contactPlaceholders = function () {
    $("#contactName").on({
        "focus": function () {
            Tools.checkInputTextFocus($(this), "Nombre");
        },
        "blur": function () {
            Tools.checkInputTextBlur($(this), "Nombre");
        }
    });
    $("#contactEmail").on({
        "focus": function () {
            Tools.checkInputTextFocus($(this), "Email");
        },
        "blur": function () {
            Tools.checkInputTextBlur($(this), "Email");
        }
    });
    $("#contactMessage").on({
        "focus": function () {
            Tools.checkInputTextFocus($(this), "Escríbanos...");
        },
        "blur": function () {
            Tools.checkInputTextBlur($(this), "Escríbanos...");
        }
    });
};
