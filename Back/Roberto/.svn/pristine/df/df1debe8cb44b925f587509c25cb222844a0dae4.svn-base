
var MMAdminUsers = {};
MMAdminUsers.editMode = false;
MMAdminUsers.user = {};

MMAdminUsers.user.userNotes = new Array();
    
$(document).ready(
    function(){
        MMAdminUsers.editMode = $('#selectedUserId').length>0;
        if($('#savePositions').length>0){
            $('#adminPositions').sortable();

            $('#savePositions').on({
                'click':function(){
                    MMAdminUsers.savePositions();
                }
            });
        }
        else{
            if($('#addUser').length>0){
                $('#addUser').on({
                    'click':function(){
                        if(MMAdminUsers.editMode)
                            MMAdminUsers.save();
                        else
                            MMAdminUsers.add();
                    }
                });
            }

            if(MMAdminUsers.editMode){
                $('#deleteUser, #deleteUserTrash').on({
                    'click':function(){
                        var id = parseInt($('#selectedUserId').val());
                        if(id!==0)
                            if(confirm($('#confirmationText').val()))
                                MMAdminUsers.remove(id);
                    }
                });
                MMAdminUsers.searchThroughTableBinds();
                MMAdminUsers.checkSelectedUser();
            }
            else{
                if($('#active').length>0)
                    $('#active').attr('class','adminCheckboxChecked');
            }    

            MMAdminUsers.bindUserNotes();
        }
});

MMAdminUsers.add = function(){
    MMAdminUsers.updateUserData();
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/Users/add',
        data:{'user':(MMAdminUsers.user)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.removeLoading(loadCode);
                Tools.alert(response.message,1,function(){Tools.redirect('/Users/viewEdit/'+response.id);});
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
    
MMAdminUsers.save = function(){
    MMAdminUsers.updateUserData();
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/Users/save',
        data:{'user':(MMAdminUsers.user)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.removeLoading(loadCode);
                Tools.alert(response.message,1,function(){Tools.redirect('/Users/viewEdit/'+MMAdminUsers.user.id);});
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

MMAdminUsers.savePositions = function(){
    var userIds = new Array();
    $('.adminPosition').each(function() {
        userIds[userIds.length] = $(this).attr('id');
    });
    
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/Users/savePositions',
        data:{'userIds':(userIds)},
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



    
MMAdminUsers.remove = function(id){
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/Users/delete',
        data:{'id':(id)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.removeLoading(loadCode);
                Tools.alert(response.message,1,function(){Tools.redirect('/Users/viewEdit');});
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
    
MMAdminUsers.updateUserData = function(){
    var selectedUserId = parseInt($('#selectedUserId').val());
    if(!isNaN(selectedUserId) && selectedUserId!==0)
        MMAdminUsers.user.id = selectedUserId
    else if($('#userId').length>0)
        MMAdminUsers.user.id = $('#userId').val();
    else
        MMAdminUsers.user.id = 0;
    MMAdminUsers.user.name = $('#name').val();
    MMAdminUsers.user.email = $('#email').val();
    MMAdminUsers.user.phone = $('#phone').val();
    MMAdminUsers.user.category_id = $('#category_id').val();
    MMAdminUsers.user.ranch_id = $('#ranch_id').val();
    MMAdminUsers.user.userNotes = MMAdminUsers.getUserNotes();
};
    
MMAdminUsers.checkSelectedUser = function(){
    var id = parseInt($('#userId').val());
    if(!isNaN(id) && id!==0){
        $('#selectedUserId').val(id);
        MMAdminUsers.loadUser(id);
    }
};
    
MMAdminUsers.loadUser = function(id){
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/Users/getArray',
        data:{'id':(id)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                MMAdminUsers.setUser(response.user);
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
    
MMAdminUsers.setUser = function(user){
    MMAdminUsers.user = user;
    $('#id').val(user.id);
    $('#name').val(user.name);
    $('#email').val(user.email);
    $('#phone').val(user.phone);
    $('#category_id').val(user.category_id);
    $('#ranch_id').val(user.ranch_id);
    
    MMAdminUsers.addUserNotes();
};
        

        



            
//------------------------------------------------------------------------------
//---------------------------SearchThroughTables--------------------------------
//------------------------------------------------------------------------------



MMAdminUsers.searchThroughTableBinds = function(){

   $('#selectedUserId').on({
       'change':function(){
            var id = $(this).val();
            if(!isNaN(id) && id!==0)
                MMAdminUsers.loadUser(id);
        }
   });
};    

//------------------------------------------------------------------------------
//-----------------------------------UserNotes-----------------------------------
//------------------------------------------------------------------------------
            
MMAdminUsers.bindUserNotes = function(){
    $('#addUserNot').on({
        'click':function(){
            MMAdminUsers.newUserNot();
        }
    });

    $('#userNotes').on({
        'click':function(){
            var randomId = $(this).attr('id').replace('userNotDelete','');
            MMAdminUsers.removeUserNot(randomId);
        }
    },'.adminMultiDataDeleteButton');    
};
            
MMAdminUsers.newUserNot = function(){
    var userNot = {};
    userNot.localId = Tools.randomString(20);
    userNot.id = 0;
    userNot.text = '';
    userNot.deleted = 0;
    MMAdminUsers.user.userNotes[MMAdminUsers.user.userNotes.length] = userNot;
    MMAdminUsers.addUserNotHTML(userNot);
};
            
MMAdminUsers.addUserNotes = function(){
    var titlesHtml = $('#userNotes').find('.adminMultiDataTitle').html();
    $('#userNotes').html('<tr class="adminMultiDataTitle">'+titlesHtml+'</tr>');
    for(var i=0; i<MMAdminUsers.user.userNotes.length; i++){
        var userNot = MMAdminUsers.user.userNotes[i];
        userNot.localId = Tools.randomString(20);
        userNot.deleted = 0;
        MMAdminUsers.addUserNotHTML(userNot);
    }
};
            
MMAdminUsers.addUserNotHTML = function(userNot){
    var html = '';
    html += "<tr id='userNot"+userNot.localId+"' class='adminMultiDataRow'>";
    html += "<td><input id='userNotId"+userNot.localId+"' type='hidden' value='"+userNot.id+"'/></td>";
    if(userNot.text==='')
        html += "<td><textarea type='text' id='userNotText"+userNot.localId+"' class='adminMultiDataInput100'>"+userNot.text+"</textarea></td>";
    else
        html += "<td><textarea type='text' id='userNotText"+userNot.localId+"' class='adminMultiDataInput100' disabled>"+userNot.text+"</textarea></td>";
    html += "<img id='userNotDelete"+userNot.localId+"' class='adminMultiDataTrash' src='/files/layouts/trash.png' alt='moonideas remove icon'/><div id='userNotDelete"+userNot.localId+"' class='adminMultiDataDeleteButton'>eliminar</div></td>";
    html += "</tr>";

    $('#userNotes').append(html);
};

MMAdminUsers.removeUserNot = function(localId){
    $('#userNot'+localId).remove();
    
    for(var i=0; i<MMAdminUsers.user.userNotes.length; i++)
        if(MMAdminUsers.user.userNotes[i].localId===localId)
            MMAdminUsers.user.userNotes[i].deleted = 1;
};
            
MMAdminUsers.getUserNotes = function(){
    var userNotesAux = new Array();
    for(var i=0; i<MMAdminUsers.user.userNotes.length; i++){
        var userNot = MMAdminUsers.user.userNotes[i];
        var localId = userNot.localId;
        if($('#userNot'+localId).length>0){
            var userNotAux = {};
            userNotAux.localId = localId;
            userNotAux.id = $('#userNotId'+localId).val();
            userNotAux.text = $('#userNotText'+localId).val();
            userNotAux.deleted = 0;
            userNotesAux[userNotesAux.length] = userNotAux;
        }
        else if(userNot.deleted===1){
            userNotesAux[userNotesAux.length] = userNot;
        }
    }
    MMAdminUsers.user.userNotes = userNotesAux;
    return MMAdminUsers.user.userNotes;
};