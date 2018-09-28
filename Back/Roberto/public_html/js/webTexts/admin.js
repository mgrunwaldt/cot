
var MMAdminWebTexts = {};
MMAdminWebTexts.editMode = false;
MMAdminWebTexts.webText = {};

    
$(document).ready(
    function(){
        MMAdminWebTexts.editMode = $('#selectedWebTextId').length>0;
        if($('#savePositions').length>0){
            $('#adminPositions').sortable();

            $('#savePositions').on({
                'click':function(){
                    MMAdminWebTexts.savePositions();
                }
            });
        }
        
        if($('#addWebText').length>0){
            $('#addWebText').on({
                'click':function(){
                    if(MMAdminWebTexts.editMode)
                        MMAdminWebTexts.save();
                    else
                        MMAdminWebTexts.add();
                }
            });
        }

        if(MMAdminWebTexts.editMode){
            $('#deleteWebText').on({
                'click':function(){
                    var id = parseInt($('#selectedWebTextId').val());
                    if(id!==0)
                        if(confirm($('#confirmationText').val()))
                            MMAdminWebTexts.remove(id);
                }
            });
            MMAdminWebTexts.searchThroughTableBinds();
            MMAdminWebTexts.checkSelectedWebText();
        }
        
        
});

MMAdminWebTexts.add = function(){
    MMAdminWebTexts.updateWebTextData();
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/WebTexts/add',
        data:{'webText':(MMAdminWebTexts.webText)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
               Tools.removeLoading(loadCode);
               Tools.alert(response.message,1,function(){Tools.redirect('/index.php/webTexts/viewEdit/'+response.id);});
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
    
MMAdminWebTexts.save = function(){
    MMAdminWebTexts.updateWebTextData();
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/WebTexts/save',
        data:{'webText':(MMAdminWebTexts.webText)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.removeLoading(loadCode);
                Tools.alert(response.message,1,function(){Tools.redirect('/index.php/webTexts/viewEdit/'+MMAdminWebTexts.webText.id);});
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

MMAdminWebTexts.savePositions = function(){
    var webTextIds = new Array();
    $('.adminPosition').each(function() {
        webTextIds[webTextIds.length] = $(this).attr('id');
    });
    
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/WebTexts/savePositions',
        data:{'webTextIds':(webTextIds)},
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

    
MMAdminWebTexts.remove = function(id){
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/WebTexts/delete',
        data:{'id':(id)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.alert(response.message,1,function(){Tools.refresh();});
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
    
MMAdminWebTexts.updateWebTextData = function(){
    var selectedWebTextId = parseInt($('#selectedWebTextId').val());
    if(!isNaN(selectedWebTextId) && selectedWebTextId!==0)
        MMAdminWebTexts.webText.id = selectedWebTextId
    else if($('#webTextId').length>0)
        MMAdminWebTexts.webText.id = $('#webTextId').val();
    else
        MMAdminWebTexts.webText.id = 0;
    MMAdminWebTexts.webText.name = $('#name').val();
};
    
MMAdminWebTexts.checkSelectedWebText = function(){
    var id = parseInt($('#webTextId').val());
    if(!isNaN(id) && id!==0){
        $('#selectedWebTextId').val(id);
        MMAdminWebTexts.loadWebText(id);
    }
};
    
MMAdminWebTexts.loadWebText = function(id){
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/WebTexts/getArray',
        data:{'id':(id)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                MMAdminWebTexts.setWebText(response.webText);
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
    
MMAdminWebTexts.setWebText = function(webText){
    MMAdminWebTexts.webText = webText;
    $('#id').val(webText.id);
    $('#name').val(webText.name);
};
        

        



            
//------------------------------------------------------------------------------
//---------------------------SearchThroughTables--------------------------------
//------------------------------------------------------------------------------



MMAdminWebTexts.searchThroughTableBinds = function(){

   $('#selectedWebTextId').on({
       'change':function(){
            var id = $(this).val();
            if(!isNaN(id) && id!==0)
                MMAdminWebTexts.loadWebText(id);
        }
   });
};