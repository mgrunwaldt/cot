
var MMAdminProjects = {};
MMAdminProjects.editMode = false;
MMAdminProjects.project = {};

MMAdminProjects.project.previewFileManager = {};
MMAdminProjects.project.projectFiles = new Array();
MMAdminProjects.projectFilesManager = {};
    
$(document).ready(
    function(){
        MMAdminProjects.editMode = $('#selectedProjectId').length>0;
        if($('#savePositions').length>0){
            $('#adminPositions').sortable();

            $('#savePositions').on({
                'click':function(){
                    MMAdminProjects.savePositions();
                }
            });
        }
        else{
            if($('#addProject').length>0){
                $('#addProject').on({
                    'click':function(){
                        if(MMAdminProjects.editMode)
                            MMAdminProjects.save();
                        else
                            MMAdminProjects.add();
                    }
                });
            }

            if(MMAdminProjects.editMode){
                $('#deleteProject, #deleteProjectTrash').on({
                    'click':function(){
                        var id = parseInt($('#selectedProjectId').val());
                        if(id!==0)
                            if(confirm($('#confirmationText').val()))
                                MMAdminProjects.remove(id);
                    }
                });
                MMAdminProjects.searchThroughTableBinds();
                MMAdminProjects.checkSelectedProject();
            }
            else{
                if($('#active').length>0)
                    $('#active').attr('class','adminCheckboxChecked');
            }    

            
        MMAdminProjects.previewFileManager = FileManager.newInstance('previewFile','previewFile',false,new Array());
        MMAdminProjects.previewFileManager.start();
            
        MMAdminProjects.projectFilesManager = FileManager.newInstance('projectFiles','projectFiles',true,new Array());
        MMAdminProjects.projectFilesManager.start();
        }
});

MMAdminProjects.add = function(){
    MMAdminProjects.updateProjectData();
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/Projects/add',
        data:{'project':(MMAdminProjects.project)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.removeLoading(loadCode);
                Tools.alert(response.message,1,function(){Tools.redirect('/Projects/viewEdit/'+response.id);});
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
    
MMAdminProjects.save = function(){
    MMAdminProjects.updateProjectData();
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/Projects/save',
        data:{'project':(MMAdminProjects.project)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.removeLoading(loadCode);
                Tools.alert(response.message,1,function(){Tools.redirect('/Projects/viewEdit/'+MMAdminProjects.project.id);});
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

MMAdminProjects.savePositions = function(){
    var projectIds = new Array();
    $('.adminPosition').each(function() {
        projectIds[projectIds.length] = $(this).attr('id');
    });
    
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/Projects/savePositions',
        data:{'projectIds':(projectIds)},
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



    
MMAdminProjects.remove = function(id){
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/Projects/delete',
        data:{'id':(id)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.removeLoading(loadCode);
                Tools.alert(response.message,1,function(){Tools.redirect('/Projects/viewEdit');});
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
    
MMAdminProjects.updateProjectData = function(){
    var selectedProjectId = parseInt($('#selectedProjectId').val());
    if(!isNaN(selectedProjectId) && selectedProjectId!==0)
        MMAdminProjects.project.id = selectedProjectId
    else if($('#projectId').length>0)
        MMAdminProjects.project.id = $('#projectId').val();
    else
        MMAdminProjects.project.id = 0;
    MMAdminProjects.project.name = $('#name').val();
    MMAdminProjects.project.client = $('#client').val();
    MMAdminProjects.project.description = $('#description').val();
    MMAdminProjects.project.category_id = $('#category_id').val();
    MMAdminProjects.project.active = Tools.getValueFromCheckbox($('#active'));
    MMAdminProjects.project.preview_file_id = MMAdminProjects.getPreviewFile();
    MMAdminProjects.project.projectFiles = MMAdminProjects.getProjectFiles();
};
    
MMAdminProjects.checkSelectedProject = function(){
    var id = parseInt($('#projectId').val());
    if(!isNaN(id) && id!==0){
        $('#selectedProjectId').val(id);
        MMAdminProjects.loadProject(id);
    }
};
    
MMAdminProjects.loadProject = function(id){
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/Projects/getArray',
        data:{'id':(id)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                MMAdminProjects.setProject(response.project);
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
    
MMAdminProjects.setProject = function(project){
    MMAdminProjects.project = project;
    $('#id').val(project.id);
    $('#name').val(project.name);
    $('#client').val(project.client);
    $('#description').val(project.description);
    $('#category_id').val(project.category_id);
    if(parseInt(project.active)===1)
        $('#active').attr('class','adminCheckboxChecked');
    else
        $('#active').attr('class','adminCheckbox');
    
    MMAdminProjects.addPreviewFile();
    MMAdminProjects.addProjectFiles();
};
        

        

            
//------------------------------------------------------------------------------
//---------------------------------PreviewFileId---------------------------------
//------------------------------------------------------------------------------
MMAdminProjects.getPreviewFile = function(){
    var file = MMAdminProjects.previewFileManager.getFiles();
    if(file!==false)
        return file.id;
    else
        return '';
};

MMAdminProjects.addPreviewFile = function(){
    if(MMAdminProjects.project.previewFile.length!==0)
        MMAdminProjects.previewFileManager.updateFiles([MMAdminProjects.project.previewFile]);
    else
        MMAdminProjects.previewFileManager.updateFiles([]);
};
            
//------------------------------------------------------------------------------
//---------------------------------ProjectFiles---------------------------------
//------------------------------------------------------------------------------

MMAdminProjects.getProjectFiles = function(){
    MMAdminProjects.project.projectFiles = MMAdminProjects.projectFilesManager.getFiles();
    return MMAdminProjects.project.projectFiles;
};

MMAdminProjects.addProjectFiles = function(){
    MMAdminProjects.projectFilesManager.updateFiles(MMAdminProjects.project.projectFiles);
};


            
//------------------------------------------------------------------------------
//---------------------------SearchThroughTables--------------------------------
//------------------------------------------------------------------------------

MMAdminProjects.getAllProjectsFromCategory = function(){
    var category_id = $('#selectedCategoryId').val();
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/Projects/getAllFromCategoryArray',
        data: {category_id:(category_id)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                var optionsHtml = '<option value="0">Seleccione un Project</option>';
                for(var i=0; i<response.projects.length; i++)
                    optionsHtml += '<option value="'+response.projects[i].id+'">'+response.projects[i].client+' - '+response.projects[i].name+'</option>';
                $('#selectedProjectId').html(optionsHtml);
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


MMAdminProjects.searchThroughTableBinds = function(){

   $('#selectedCategoryId').on({
       'change':function(){
            MMAdminProjects.getAllProjectsFromCategory();
        }
   });

   $('#selectedProjectId').on({
       'change':function(){
            var id = $(this).val();
            if(!isNaN(id) && id!==0)
                MMAdminProjects.loadProject(id);
        }
   });
};