var Login = {};

$(document).ready(
    function(){
        Login.bindFunctions();
        Login.calculateHeight();
});

Login.bindFunctions = function(){
        $('#signIn').on({
            'click':function(){
                Login.login();
            }
        });
        
        $('#email').on({
            'keyup':function(e){
                if (parseInt(e.which)===13 && !e.shiftKey)
                    $('#password').focus();
            }
        });

        $('#password').on({
            'keyup':function(e){
                if (parseInt(e.which)===13 && !e.shiftKey){
                    $('#email').focus();
                    Login.login();
                }
            }
        });
        
        $(window).resize(function() {
            Login.calculateHeight();
        });
};

Login.calculateHeight = function(){
    var screenWidth = parseFloat($(window).width());
    var screenHeight = parseFloat($(window).height());
    var contentHeight = parseFloat($('#content').height());
    var poweredByWidth = 240;
    var contentMarginTop =  (screenHeight-contentHeight)/3;
    
    var poweredByTop = screenHeight - 70;
    if(poweredByTop<600)
        poweredByTop = 600;
    
    $('#content').css('margin-top', contentMarginTop);
    $('#poweredBy').css('left', (screenWidth-poweredByWidth)/2);
    $('#poweredBy').css('top', poweredByTop);
};

Login.login = function(){
    var email = $('#email').val().trim(); 
    var password = $('#password').val().trim(); 
    if(email!==''){
        if(password!==''){
            var code = Tools.showLoading();
            $.ajax({
                type: "POST",
                url: "/index.php/administrators/login",
                data: {email:(email),password:(password)},
                success: function(response){
                    Tools.removeLoading(code);
                    response = $.parseJSON(response);
                    if(response.status==='ok'){
                        Tools.redirect(response.redirect);
                    }
                    else if(response.status==='error'){
                        if(response.error==='wrongUsernameOrPassword'){
                            Tools.alert(response.errorMessage);
                        }
                        else if(response.error==='wrongInputData'){
                            Tools.alert(response.errorMessage);
                        }
                        else if(response.error==='loggedAsUser'){
                            Tools.alert(response.errorMessage);
                        }
                        else if(response.error==='alreadyLogged'){
                            Tools.redirect(response.redirect);
                        }
                        else if(response.error==='unknown'){
                            Tools.alert(response.errorMessage);
                        }
                        else{
                            Tools.alert(response.errorMessage);
                        }
                    }
                    else{
                        Tools.alert('error obteniendo datos del sitio, verifique su conexión a internet.');
                    }
                },
                error: function(){
                    Tools.removeLoading(code);
                    Tools.alert('error obteniendo datos del sitio, verifique su conexión a internet.');
                }
            });
        }
        else{
            Tools.alert('Ingrese una contraseña',null,null,null,null);
        }
    }
    else{
        Tools.alert('Ingrese un nombre de usuario',null,null,null,null);
    }
};