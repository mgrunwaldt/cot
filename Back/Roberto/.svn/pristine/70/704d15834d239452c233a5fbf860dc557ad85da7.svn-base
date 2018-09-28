var ChangePassword = {};
    
$(document).ready(
    function(){
        $('#changeAdministratorPassword').on({
            'click':function(){
                ChangePassword.changePassword();
            }
        });
});
    
ChangePassword.changePassword = function(){
    var oldPassword = $('#oldPassword').val();
    var newPassword = $('#newPassword').val();
    var newPasswordRepeat = $('#newPasswordRepeat').val();
    
    if(oldPassword.trim().length>0){
        if(newPassword.trim().length>0){
            if(newPassword.trim()===newPassword){
                if(newPassword.trim().length>5){
                    if(newPassword.trim()!==oldPassword.trim()){
                        if(newPassword===newPasswordRepeat){
                            var loadCode = Tools.showLoading();
                            $.ajax({
                                type: 'POST',
                                url: '/Administrators/changePassword',
                                data:{'oldPassword':(oldPassword),'newPassword':(newPassword),'newPasswordRepeat':(newPasswordRepeat)},
                                success: function(response){
                                    Tools.removeLoading(loadCode);
                                    response = $.parseJSON(response);
                                    if(response.status==='ok'){
                                        $('#oldPassword').val('');
                                        $('#newPassword').val('');
                                        $('#newPasswordRepeat').val('');
                                        Tools.alert(response.message,1,function(){Tools.redirect('/Administrators/viewIndex/');});
                                    }
                                    else if(response.status==='error'){
                                        Tools.alert(response.errorMessage);
                                    }
                                    else{
                                        alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
                                    }
                                },
                                error: function(){
                                    Tools.removeLoading(loadCode);
                                    alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
                                }
                            });
                        }
                        else{
                            Tools.alert('Las contraseñas no coinciden.');
                        }
                    }
                    else{
                        Tools.alert('La contraseña nueva no puede ser igual a la anterior.');
                    }
                }
                else{
                    Tools.alert('La contraseña debe tener al menos 6 caracteres.');
                }
            }
            else{
                Tools.alert('No se pueden utilzar espacios en la contraseña.');
            }
        }
        else{
            Tools.alert('Ingrese una nueva contraseña.');
        }
    }
    else{
        Tools.alert('Ingrese su contraseña anterior.');
    }
};