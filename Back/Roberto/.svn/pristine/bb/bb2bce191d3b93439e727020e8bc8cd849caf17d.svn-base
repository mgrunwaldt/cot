
var MMAdminContactMessages = {};
MMAdminContactMessages.editMode = false;
MMAdminContactMessages.contactMessag = {};

    
$(document).ready(
    function(){
        MMAdminContactMessages.editMode = $('#selectedContactMessagId').length>0;
        if($('#savePositions').length>0){
            $('#adminPositions').sortable();

            $('#savePositions').on({
                'click':function(){
                    MMAdminContactMessages.savePositions();
                }
            });
        }
        else{
            if($('#addContactMessag').length>0){
                $('#addContactMessag').on({
                    'click':function(){
                        if(MMAdminContactMessages.editMode)
                            MMAdminContactMessages.save();
                        else
                            MMAdminContactMessages.add();
                    }
                });
            }

            if(MMAdminContactMessages.editMode){
                $('#deleteContactMessag, #deleteContactMessagTrash').on({
                    'click':function(){
                        var id = parseInt($('#selectedContactMessagId').val());
                        if(id!==0)
                            if(confirm($('#confirmationText').val()))
                                MMAdminContactMessages.remove(id);
                    }
                });
                MMAdminContactMessages.searchThroughTableBinds();
                MMAdminContactMessages.checkSelectedContactMessag();
            }
            else{
                if($('#active').length>0)
                    $('#active').attr('class','adminCheckboxChecked');
            }    

            
        }
});

MMAdminContactMessages.add = function(){
    MMAdminContactMessages.updateContactMessagData();
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/ContactMessages/add',
        data:{'contactMessag':(MMAdminContactMessages.contactMessag)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.removeLoading(loadCode);
                Tools.alert(response.message,1,function(){Tools.redirect('/ContactMessages/viewEdit/'+response.id);});
            }
            else if(response.status==='error'){
                Tools.alert(response.errorMessage);
                Tools.removeLoading(loadCode);
            }
            else{
                Tools.alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
                Tools.removeLoading(loadCode);
            }
        },
        error: function(){
            Tools.alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
            Tools.removeLoading(loadCode);
        }
    });
};
    
MMAdminContactMessages.save = function(){
    MMAdminContactMessages.updateContactMessagData();
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/ContactMessages/save',
        data:{'contactMessag':(MMAdminContactMessages.contactMessag)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.removeLoading(loadCode);
                Tools.alert(response.message,1,function(){Tools.redirect('/ContactMessages/viewEdit/'+MMAdminContactMessages.contactMessag.id);});
            }
            else if(response.status==='error'){
                Tools.alert(response.errorMessage);
                Tools.removeLoading(loadCode);
            }
            else{
                Tools.alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
                Tools.removeLoading(loadCode);
            }
        },
        error: function(){
            Tools.alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
            Tools.removeLoading(loadCode);
        }
    });
};

MMAdminContactMessages.savePositions = function(){
    var contactMessagIds = new Array();
    $('.adminPosition').each(function() {
        contactMessagIds[contactMessagIds.length] = $(this).attr('id');
    });
    
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/ContactMessages/savePositions',
        data:{'contactMessagIds':(contactMessagIds)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.alert(response.message);
            }
            else if(response.status==='error'){
                Tools.alert(response.errorMessage);
            }
            else{
                Tools.alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
            }
            Tools.removeLoading(loadCode);
        },
        error: function(){
            Tools.alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
            Tools.removeLoading(loadCode);
        }
    });
};



    
MMAdminContactMessages.remove = function(id){
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/ContactMessages/delete',
        data:{'id':(id)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.removeLoading(loadCode);
                Tools.alert(response.message,1,function(){Tools.redirect('/ContactMessages/viewEdit');});
            }
            else if(response.status==='error'){
                Tools.alert(response.errorMessage);
                Tools.removeLoading(loadCode);
            }
            else{
                Tools.alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
                Tools.removeLoading(loadCode);
            }
        },
        error: function(){
            Tools.alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
            Tools.removeLoading(loadCode);
        }
    });
};
    
MMAdminContactMessages.updateContactMessagData = function(){
    var selectedContactMessagId = parseInt($('#selectedContactMessagId').val());
    if(!isNaN(selectedContactMessagId) && selectedContactMessagId!==0)
        MMAdminContactMessages.contactMessag.id = selectedContactMessagId
    else if($('#contactMessagId').length>0)
        MMAdminContactMessages.contactMessag.id = $('#contactMessagId').val();
    else
        MMAdminContactMessages.contactMessag.id = 0;
    MMAdminContactMessages.contactMessag.name = $('#name').val();
    MMAdminContactMessages.contactMessag.reply_address = $('#reply_address').val();
    MMAdminContactMessages.contactMessag.phone = $('#phone').val();
    MMAdminContactMessages.contactMessag.about = $('#about').val();
    MMAdminContactMessages.contactMessag.message = $('#message').val();
    MMAdminContactMessages.contactMessag.area = $('#area').val();
};
    
MMAdminContactMessages.checkSelectedContactMessag = function(){
    var id = parseInt($('#contactMessagId').val());
    if(!isNaN(id) && id!==0){
        $('#selectedContactMessagId').val(id);
        MMAdminContactMessages.loadContactMessag(id);
    }
};
    
MMAdminContactMessages.loadContactMessag = function(id){
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/ContactMessages/getArray',
        data:{'id':(id)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                MMAdminContactMessages.setContactMessag(response.contactMessag);
            }
            else{
                Tools.alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
            }
            Tools.removeLoading(loadCode);
        },
        error: function(){
            Tools.alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
            Tools.removeLoading(loadCode);
        }
    });
};
    
MMAdminContactMessages.setContactMessag = function(contactMessag){
    MMAdminContactMessages.contactMessag = contactMessag;
    $('#id').val(contactMessag.id);
    $('#name').val(contactMessag.name);
    $('#reply_address').val(contactMessag.reply_address);
    $('#phone').val(contactMessag.phone);
    $('#about').val(contactMessag.about);
    $('#message').val(contactMessag.message);
    $('#area').val(contactMessag.area);
};
        

        



            
//------------------------------------------------------------------------------
//---------------------------SearchThroughTables--------------------------------
//------------------------------------------------------------------------------



MMAdminContactMessages.searchThroughTableBinds = function(){

   $('#selectedContactMessagId').on({
       'change':function(){
            var id = $(this).val();
            if(!isNaN(id) && id!==0)
                MMAdminContactMessages.loadContactMessag(id);
        }
   });
};