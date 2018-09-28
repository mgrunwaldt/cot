
var MMAdminCategories = {};
MMAdminCategories.editMode = false;
MMAdminCategories.category = {};

MMAdminCategories.category.iconFileManager = {};
    
$(document).ready(
    function(){
        MMAdminCategories.editMode = $('#selectedCategoryId').length>0;
        if($('#savePositions').length>0){
            $('#adminPositions').sortable();

            $('#savePositions').on({
                'click':function(){
                    MMAdminCategories.savePositions();
                }
            });
        }
        else{
            if($('#addCategory').length>0){
                $('#addCategory').on({
                    'click':function(){
                        if(MMAdminCategories.editMode)
                            MMAdminCategories.save();
                        else
                            MMAdminCategories.add();
                    }
                });
            }

            if(MMAdminCategories.editMode){
                $('#deleteCategory, #deleteCategoryTrash').on({
                    'click':function(){
                        var id = parseInt($('#selectedCategoryId').val());
                        if(id!==0)
                            if(confirm($('#confirmationText').val()))
                                MMAdminCategories.remove(id);
                    }
                });
                MMAdminCategories.searchThroughTableBinds();
                MMAdminCategories.checkSelectedCategory();
            }
            else{
                if($('#active').length>0)
                    $('#active').attr('class','adminCheckboxChecked');
            }    

            
        MMAdminCategories.iconFileManager = FileManager.newInstance('iconFile','iconFile',false,new Array());
        MMAdminCategories.iconFileManager.start();
        }
        
        $("#alertMessageAceptar").click(function () {
                window.location.reload();
            });
});

MMAdminCategories.add = function(){
    MMAdminCategories.updateCategoryData();
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/Categories/add',
        data:{'category':(MMAdminCategories.category)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.removeLoading(loadCode);
                Tools.alert(response.message,1,function(){Tools.redirect('/Categories/viewEdit/'+response.id);});
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
    
MMAdminCategories.save = function(){
    MMAdminCategories.updateCategoryData();
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/Categories/save',
        data:{'category':(MMAdminCategories.category)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.removeLoading(loadCode);
                Tools.alert(response.message,1,function(){Tools.redirect('/Categories/viewEdit/'+MMAdminCategories.category.id);});
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

MMAdminCategories.savePositions = function(){
    var categoryIds = new Array();
    $('.adminPosition').each(function() {
        categoryIds[categoryIds.length] = $(this).attr('id');
    });
    
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/Categories/savePositions',
        data:{'categoryIds':(categoryIds)},
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



    
MMAdminCategories.remove = function(id){
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/Categories/delete',
        data:{'id':(id)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.removeLoading(loadCode);
                Tools.alert(response.message,1,function(){Tools.redirect('/Categories/viewEdit');});
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
    
MMAdminCategories.updateCategoryData = function(){
    var selectedCategoryId = parseInt($('#selectedCategoryId').val());
    if(!isNaN(selectedCategoryId) && selectedCategoryId!==0)
        MMAdminCategories.category.id = selectedCategoryId
    else if($('#categoryId').length>0)
        MMAdminCategories.category.id = $('#categoryId').val();
    else
        MMAdminCategories.category.id = 0;
    MMAdminCategories.category.name = $('#name').val();
    MMAdminCategories.category.active = Tools.getValueFromCheckbox($('#active'));
    MMAdminCategories.category.icon_file_id = MMAdminCategories.getIconFile();
};
    
MMAdminCategories.checkSelectedCategory = function(){
    var id = parseInt($('#categoryId').val());
    if(!isNaN(id) && id!==0){
        $('#selectedCategoryId').val(id);
        MMAdminCategories.loadCategory(id);
    }
};
    
MMAdminCategories.loadCategory = function(id){
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/Categories/getArray',
        data:{'id':(id)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                MMAdminCategories.setCategory(response.category);
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
    
MMAdminCategories.setCategory = function(category){
    MMAdminCategories.category = category;
    $('#id').val(category.id);
    $('#name').val(category.name);
    if(parseInt(category.active)===1)
        $('#active').attr('class','adminCheckboxChecked');
    else
        $('#active').attr('class','adminCheckbox');
    
    MMAdminCategories.addIconFile();
};
        

        

            
//------------------------------------------------------------------------------
//----------------------------------IconFileId----------------------------------
//------------------------------------------------------------------------------
MMAdminCategories.getIconFile = function(){
    var file = MMAdminCategories.iconFileManager.getFiles();
    if(file!==false)
        return file.id;
    else
        return '';
};

MMAdminCategories.addIconFile = function(){
    if(MMAdminCategories.category.iconFile.length!==0)
        MMAdminCategories.iconFileManager.updateFiles([MMAdminCategories.category.iconFile]);
    else
        MMAdminCategories.iconFileManager.updateFiles([]);
};


            
//------------------------------------------------------------------------------
//---------------------------SearchThroughTables--------------------------------
//------------------------------------------------------------------------------



MMAdminCategories.searchThroughTableBinds = function(){

   $('#selectedCategoryId').on({
       'change':function(){
            var id = $(this).val();
            if(!isNaN(id) && id!==0)
                MMAdminCategories.loadCategory(id);
        }
   });
};