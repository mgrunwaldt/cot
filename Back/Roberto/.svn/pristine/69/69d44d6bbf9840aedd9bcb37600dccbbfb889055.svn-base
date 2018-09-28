var Administrators = {};
Administrators.editMode = false;
Administrators.administrator = {};

Administrators.administrator.administratorFiles = new Array();
Administrators.administratorFilesManager = {};
    
$(document).ready(
    function(){
        Administrators.editMode = $('#selectedAdministratorId').length>0;
    
        $('#addAdministrator').on({
            'click':function(){
                if(Administrators.editMode)
                    Administrators.save();
                else
                    Administrators.add();
            }
        });

        if(Administrators.editMode){
            $('#deleteAdministrator').on({
                'click':function(){
                    var id = parseInt($('#selectedAdministratorId').val());
                    if(id!==0)
                        if(confirm($('#confirmationText').val()))
                            Administrators.remove(id);
                }
            });
            Administrators.searchThroughTableBinds();
            Administrators.checkSelectedAdministrator();
            
            $('#resetPassword').on({
                'click':function(){
                    var id = parseInt($('#selectedAdministratorId').val());
                    if(id!==0)
                        if(confirm('¿Está seguro que desea resetar la contraseña?'))
                            Administrators.resetPassword(id);
                }
            });
        }
            
        Administrators.administratorFilesManager = FileManager.newInstance('administratorFiles','administratorFiles',true,new Array());
        Administrators.administratorFilesManager.start();
});

Administrators.add = function(){
    Administrators.updateAdministratorData();
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/Administrators/add',
        data:{'administrator':(Administrators.administrator)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.alert(response.message,1,function(){Tools.redirect('/index.php/administrators/viewEdit/'+response.id);});
            }
            else if(response.status==='error'){
                Tools.alert(response.errorMessage);
            }
            else{
                alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
            }
            Tools.removeLoading(loadCode);
        },
        error: function(){
            Tools.removeLoading(loadCode);
            alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
        }
    });
};
Administrators.resetPassword = function(id){
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/Administrators/resetPassword',
        data:{'id':(id)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.alert(response.message);
            }
            else if(response.status==='error'){
                Tools.alert(response.errorMessage);
            }
            else{
                alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
            }
            Tools.removeLoading(loadCode);
        },
        error: function(){
            Tools.removeLoading(loadCode);
            alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
        }
    });
};
    
Administrators.save = function(){
    Administrators.updateAdministratorData();
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/Administrators/save',
        data:{'administrator':(Administrators.administrator)},
        success: function(response){
            Tools.removeLoading(loadCode);
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.alert(response.message,1,function(){Tools.redirect('/index.php/administrators/viewEdit/'+Administrators.administrator.id);});
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
};
    
Administrators.remove = function(id){
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/Administrators/delete',
        data:{'id':(id)},
        success: function(response){
            Tools.removeLoading(loadCode);
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.alert(response.message,1,function(){Tools.refresh();});
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
};
    
Administrators.updateAdministratorData = function(){
    var selectedAdministratorId = parseInt($('#selectedAdministratorId').val());
    if(!isNaN(selectedAdministratorId) && selectedAdministratorId!==0)
        Administrators.administrator.id = selectedAdministratorId
    else if($('#administratorId').length>0)
        Administrators.administrator.id = $('#administratorId').val();
    else
        Administrators.administrator.id = 0;
    Administrators.administrator.email = $('#email').val();
    Administrators.administrator.name = $('#name').val();
    Administrators.administrator.last_name = $('#last_name').val();
    Administrators.administrator.phone = $('#phone').val();
    Administrators.administrator.administrator_role_id = $('#administrator_role_id').val();
    Administrators.administrator.active = Tools.getValueFromCheckbox($('#active'));
    Administrators.administrator.administratorFiles = Administrators.getAdministratorFiles();
};
    
Administrators.checkSelectedAdministrator = function(){
    var id = parseInt($('#administratorId').val());
    if(!isNaN(id) && id!==0){
        $('#selectedAdministratorId').val(id);
        Administrators.loadAdministrator(id);
    }
};
    
Administrators.loadAdministrator = function(id){
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/Administrators/getArray',
        data:{'id':(id)},
        success: function(response){
            Tools.removeLoading(loadCode);
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Administrators.setAdministrator(response.administrator);
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
};
    
Administrators.setAdministrator = function(administrator){
    Administrators.administrator = administrator;
    $('#id').val(administrator.id);
    $('#email').val(administrator.email);
    $('#name').val(administrator.name);
    $('#last_name').val(administrator.last_name);
    $('#phone').val(administrator.phone);
    $('#administrator_role_id').val(administrator.administrator_role_id);
    if(parseInt(administrator.active)===1)
        $('#active').attr('class','adminCheckboxChecked');
    else
        $('#active').attr('class','adminCheckbox');
    Administrators.addAdministratorFiles();
};
        

        

            
//------------------------------------------------------------------------------
//------------------------------AdministratorFiles------------------------------
//------------------------------------------------------------------------------

Administrators.getAdministratorFiles = function(){
    Administrators.administrator.administratorFiles = Administrators.administratorFilesManager.getFiles();
    return Administrators.administrator.administratorFiles;
};

Administrators.addAdministratorFiles = function(){
    Administrators.administratorFilesManager.updateFiles(Administrators.administrator.administratorFiles);
};


            
//------------------------------------------------------------------------------
//---------------------------SearchThroughTables--------------------------------
//------------------------------------------------------------------------------



Administrators.searchThroughTableBinds = function(){

   $('#selectedAdministratorId').on({
       'change':function(){
            var id = $(this).val();
            if(!isNaN(id) && id!==0)
                Administrators.loadAdministrator(id);
        }
   });
};