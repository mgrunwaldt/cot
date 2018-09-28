var MMAdminBuild = {};
MMAdminBuild.tables = {};
MMAdminBuild.selectedTable = {};
MMAdminBuild.table = {};
MMAdminBuild.files = new Array();
MMAdminBuild.manyToThis = new Array();
MMAdminBuild.searchThroughTables = new Array();
MMAdminBuild.columnTypeOptions = '';

$(document).ready(
    function(){
        MMAdminBuild.editMode = $('#selectedBasicActionId').length>0;
        
        $('#table').on({
            'change':function(){
                MMAdminBuild.setSelectedTable($(this).val());
                MMAdminBuild.setColumns($(this).val());
            }
        });
        
        $('.adminData').on({
            'click':function(){
                MMAdminBuild.addFiles();
            }
        },'#buildAddFiles');
        
        $('.adminData').on({
            'click':function(){
                MMAdminBuild.addManyToThis();
            }
        },'#buildAddManyToThis');
        
        $('.adminData').on({
            'click':function(){
                MMAdminBuild.addSearchThroughTable();
            }
        },'#buildAddSearchThroughTable');
        
        $('#buildAdd').on({
            'click':function(){
                MMAdminBuild.build();
            }
        });
        
        MMAdminBuild.loadData();
});

MMAdminBuild.loadData = function(){
    //loadTypes
    //then loadTables
    MMAdminBuild.loadTypes();
};

MMAdminBuild.loadTypes = function(){
    $.ajax({
        type: "POST",
        url: "/index.php/builder/getBuilderTypes",
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                MMAdminBuild.columnTypeOptions = '';
                for(var i=0; i<response.builderTypes.length; i++)
                    MMAdminBuild.columnTypeOptions += '<option value="'+response.builderTypes[i].id+'">'+response.builderTypes[i].name+'</option>';
                MMAdminBuild.loadTables();
            }
            else if(response.status==='error'){
                Tools.alert(response.errorMessage);
            }
            else{
                alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
            }
        },
        error: function(){
            alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
        }
    });
};

MMAdminBuild.loadTables = function(){
    $.ajax({
        type: "POST",
        url: "/index.php/builder/getTables",
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                MMAdminBuild.tables = response.tables;
                MMAdminBuild.setTables();
            }
            else if(response.status==='error'){
                Tools.alert(response.errorMessage);
            }
            else{
                alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
            }
        },
        error: function(){
            alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
        }
    });
};

MMAdminBuild.setTables = function(){
    var tableOptionsHtml = '<option value="0">Select a Table</option>';
    for(var i=0; i<MMAdminBuild.tables.length; i++)
        tableOptionsHtml += '<option value="'+MMAdminBuild.tables[i].name+'">'+MMAdminBuild.tables[i].name+'</option>';
    $('#table').html(tableOptionsHtml);
};

MMAdminBuild.build = function(){
    MMAdminBuild.updateTableData();
    var model = Tools.getValueFromCheckbox($('#model'));
    var controller = Tools.getValueFromCheckbox($('#controller'));
    var js = Tools.getValueFromCheckbox($('#js'));
    var views = Tools.getValueFromCheckbox($('#views'));
    
    $.ajax({
        type: "POST",
        url: "/index.php/builder/build",
        data:{'table':(MMAdminBuild.table),'model':(model),'controller':(controller),'js':(js),'views':(views)},
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
        },
        error: function(){
            alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
        }
    });
};

MMAdminBuild.setSelectedTable = function(tableName){
    for(var i=0; i<MMAdminBuild.tables.length; i++)
        if(MMAdminBuild.tables[i].name===tableName)
            MMAdminBuild.selectedTable = MMAdminBuild.tables[i];
};

MMAdminBuild.setColumns = function(){
    var columns = MMAdminBuild.selectedTable.columns;
    $('#buildTableRowSpecifics').html('');
    if(columns.length>1)
        for(var i=1; i<columns.length; i++){
            var auxHtml = '<div id="column'+columns[i].name+'Row" class="adminDataRow"><div class="adminDataRowTitle">'+columns[i].name+'</div><select id="column'+columns[i].name+'Type" class="adminInput200">'+MMAdminBuild.columnTypeOptions+'</select><div id="column'+columns[i].name+'ExtraData"></div><div class="adminDataRowShortTitle">Unique:</div><div id="column'+columns[i].name+'Unique" class="adminCheckbox"></div></div>';
            $('#buildTableRowSpecifics').append(auxHtml);
            MMAdminBuild.setColumnTypeChange(columns[i].name);
        }
    
    $('#buildTableRowSpecifics').append('<div class="adminDataRow"><div class="adminDataRowTitle">Many To This:</div></div><div id="manyToThis"></div><div id="buildAddManyToThis" class="adminMultiDataAddButton">add</div><div class="adminDataRow"><div class="adminDataRowTitle">Files:</div></div><div id="files"></div><div id="buildAddFiles" class="adminMultiDataAddButton">add</div><div class="adminDataRow"><div class="adminDataRowTitle">Search Through Tables:</div></div><div id="searchThroughTables"></div><div id="buildAddSearchThroughTable" class="adminMultiDataAddButton">Add Table</div>');
    MMAdminBuild.setSearchThroughTable(columns);
    MMAdminBuild.autoSet();
};
MMAdminBuild.setColumnTypeChange = function(columnName){
    $('#column'+columnName+'Type').off().on({
        'change':function(){
            MMAdminBuild.columnTypeChange('column'+columnName, parseInt($(this).val()));
        }
    }); 
};

MMAdminBuild.columnTypeChange = function(id, value){
    switch(value){
        case 0: case 2: case 3: case 5: case 6: case 7: case 8: case 12:
            $('#'+id+'ExtraData').html('');
            break;
        case 1:
            var tableOptions = $('#table').html();
            $('#'+id+'ExtraData').html('');
            $('#'+id+'ExtraData').html('<select id="'+id+'TypeValue" class="adminInput200">'+tableOptions+'</select>');
        break;
        case 4: case 9: case 10: case 11:
            $('#'+id+'ExtraData').html('');
            $('#'+id+'ExtraData').html('<input type="text" id="'+id+'TypeValue" class="adminInput200"/>');
        break;
    }
};

MMAdminBuild.updateTableData = function(){
    MMAdminBuild.table = {};
    MMAdminBuild.table.name = MMAdminBuild.selectedTable.name;
    MMAdminBuild.table.columns = new Array();
    for(var i=1; i<MMAdminBuild.selectedTable.columns.length; i++){
        var auxColumn = {};
        auxColumn.name = MMAdminBuild.selectedTable.columns[i].name;
        auxColumn.type = $('#column'+auxColumn.name+'Type').val();
        auxColumn.unique = Tools.getValueFromCheckbox($('#column'+auxColumn.name+'Unique'));
        if($('#column'+auxColumn.name+'TypeValue').length>0)
            auxColumn.typeValue = $('#column'+auxColumn.name+'TypeValue').val();
        MMAdminBuild.table.columns[MMAdminBuild.table.columns.length] = auxColumn;
    }
    
    MMAdminBuild.getFiles();
    MMAdminBuild.getManyToThis();
    MMAdminBuild.getSearchThroughTables();
};


//------------------------------------------------------------------------------
//--------------------------------FILES-----------------------------------------
//------------------------------------------------------------------------------

MMAdminBuild.addFiles = function(){
    var localId = Tools.randomString(20);
    var file = {};
    file.localId = localId;
    MMAdminBuild.files[MMAdminBuild.files.length] = file;
    var tableOptions = $('#table').html();
    $('#files').append('<div id="files'+localId+'" class="adminMultiData"><div class="adminDataRow"><div class="adminDataRowSmallTitle">Table:</div><select id="files'+localId+'Table" class="adminInput200">'+tableOptions+'</select></div><div id="files'+localId+'Delete" class="adminDeleteButton">eliminar</div></div>');
    
    $('#files'+localId+'Table').off().on({
        'change':function(){
            MMAdminBuild.loadColumnsForFiles($(this).val(), localId);
        }
    }); 
    
    $('#files'+localId+'Delete').off().on({
        'click':function(){
            MMAdminBuild.deleteFile(localId);
        }
    }); 
    
    return localId;
};

MMAdminBuild.loadColumnsForFiles = function(tableName, filesId){
    for(var i=0; i<MMAdminBuild.tables.length; i++)
        if(MMAdminBuild.tables[i].name===tableName)
            MMAdminBuild.setColumnsForFiles(filesId, MMAdminBuild.tables[i].columns);
};

MMAdminBuild.setColumnsForFiles = function(filesId, columns){
    var optionsHtml = '';
    if(columns.length>1)
        for(var i=1; i<columns.length; i++)
            optionsHtml += '<option value="'+columns[i].name+'">'+columns[i].name+'</option>';
    $('#files'+filesId+'Key').remove();
    $('#files'+filesId).find('.adminDataRow').append('<select id="files'+filesId+'Key" class="adminInput200">'+optionsHtml+'</select>');
};

MMAdminBuild.getFiles = function(){
    MMAdminBuild.table.files = new Array();
    for(var i=0; i<MMAdminBuild.files.length; i++){
        if($('#files'+MMAdminBuild.files[i].localId+'Table').length>0){
            var auxFiles = {};
            auxFiles.table = $('#files'+MMAdminBuild.files[i].localId+'Table').val();
            auxFiles.key = $('#files'+MMAdminBuild.files[i].localId+'Key').val();
            MMAdminBuild.table.files[MMAdminBuild.table.files.length] = auxFiles;
        }
    }
};

MMAdminBuild.deleteFile = function(localId){
    var auxArray = new Array();
    for(var i=0; i<MMAdminBuild.files.length; i++)
        if(MMAdminBuild.files[i].localId!==localId)
           auxArray[auxArray.length] = MMAdminBuild.files[i];
    MMAdminBuild.files = auxArray;
    $('#files'+localId).remove();
};

//------------------------------------------------------------------------------
//-----------------------------MANY TO THIS-------------------------------------
//------------------------------------------------------------------------------

MMAdminBuild.addManyToThis = function(){
    var localId = Tools.randomString(20);
    var manyToThis = {};
    manyToThis.localId = localId;
    MMAdminBuild.manyToThis[MMAdminBuild.manyToThis.length] = manyToThis;
    var tableOptions = $('#table').html();
    $('#manyToThis').append('<div id="manyToThis'+localId+'" class="adminMultiData"><div class="adminDataRow"><div class="adminDataRowSmallTitle">Table:</div><select id="manyToThis'+localId+'Table" class="adminInput200">'+tableOptions+'</select><div class="adminDataRowSmallTitle">Key:</div><select id="manyToThis'+localId+'Key" class="adminInput200"></select><input type="hidden" id="manyToThis'+localId+'LastKey" value=""/></div><div id="manyToThis'+localId+'Rows"></div><div id="manyToThis'+localId+'Delete" class="adminDeleteButton">eliminar</div></div>');
    
    $('#manyToThis'+localId+'Table').off().on({
        'change':function(){
            MMAdminBuild.loadColumnsForManyToThis($(this).val(), localId);
        }
    }); 
    
    $('#manyToThis'+localId+'Delete').off().on({
        'click':function(){
            MMAdminBuild.deleteManyToThis(localId);
        }
    }); 
    
    return localId;
};

MMAdminBuild.loadColumnsForManyToThis = function(tableName, manyToThisId){
    for(var i=0; i<MMAdminBuild.tables.length; i++)
        if(MMAdminBuild.tables[i].name===tableName)
                MMAdminBuild.setColumnsForManyToThis(manyToThisId, MMAdminBuild.tables[i].columns);
};

MMAdminBuild.setColumnsForManyToThis = function(manyToThisId, columns){
    for(var i=0; i<MMAdminBuild.manyToThis.length; i++)
        if(MMAdminBuild.manyToThis[i].localId === manyToThisId)
            MMAdminBuild.manyToThis[i].columns = columns;
            
    $('#manyToThis'+manyToThisId+'Rows').html('');
    $('#manyToThis'+manyToThisId+'Key').html('');
    if(columns.length>1)
        for(var i=1; i<columns.length; i++){
            if(i===1)
                $('#manyToThis'+manyToThisId+'LastKey').val(columns[i].name);
            var auxHtml = '<div id="manyToThis'+manyToThisId+'Column'+columns[i].name+'Row" class="adminDataRow"><div class="adminDataRowTitle">'+columns[i].name+'</div><select id="manyToThis'+manyToThisId+'Column'+columns[i].name+'Type" class="adminInput200">'+MMAdminBuild.columnTypeOptions+'</select><div id="manyToThis'+manyToThisId+'Column'+columns[i].name+'ExtraData"></div><div class="adminDataRowShortTitle">Unique:</div><div id="manyToThis'+manyToThisId+'Column'+columns[i].name+'Unique" class="adminCheckbox"></div></div>';
            $('#manyToThis'+manyToThisId+'Rows').append(auxHtml);
            MMAdminBuild.setManyToThisColumnTypeChange(manyToThisId, columns[i].name);
            $('#manyToThis'+manyToThisId+'Key').append('<option value="'+columns[i].name+'">'+columns[i].name+'</option>');
            MMAdminBuild.manyToThisKeyUpdated(manyToThisId);
        }
    MMAdminBuild.manyToThisSetKeyUpdate(manyToThisId);
    MMAdminBuild.manyToThisKeyUpdated(manyToThisId);
};

MMAdminBuild.setManyToThisColumnTypeChange = function(manyToThisId, columnName){
    $('#manyToThis'+manyToThisId+'Column'+columnName+'Type').off().on({
        'change':function(){
            MMAdminBuild.columnTypeChange('manyToThis'+manyToThisId+'Column'+columnName, parseInt($(this).val()));
        }
    }); 
};

MMAdminBuild.getManyToThis = function(){
    MMAdminBuild.table.manyToThis = new Array();
    for(var i=0; i<MMAdminBuild.manyToThis.length; i++){
        if($('#manyToThis'+MMAdminBuild.manyToThis[i].localId+'Table').length>0){
            var auxManyToThis = {};
            auxManyToThis.table = $('#manyToThis'+MMAdminBuild.manyToThis[i].localId+'Table').val();
            auxManyToThis.key = $('#manyToThis'+MMAdminBuild.manyToThis[i].localId+'Key').val();
            auxManyToThis.columns = new Array();
            for(var j=1; j<MMAdminBuild.manyToThis[i].columns.length; j++){
                    var localId = MMAdminBuild.manyToThis[i].localId;
                    var name = MMAdminBuild.manyToThis[i].columns[j].name;
                if($('#manyToThis'+localId+'Column'+name+'Type').length>0){
                    var auxColumn = {};
                    auxColumn.name = name;
                    auxColumn.type = parseInt($('#manyToThis'+localId+'Column'+name+'Type').val());
                    auxColumn.unique = Tools.getValueFromCheckbox($('#manyToThis'+localId+'Column'+name+'Unique'));
                    if($('#manyToThis'+localId+'Column'+name+'TypeValue').length>0)
                        auxColumn.typeValue = $('#manyToThis'+localId+'Column'+name+'TypeValue').val();

                    auxManyToThis.columns[auxManyToThis.columns.length] = auxColumn;
                }
            }
            MMAdminBuild.table.manyToThis[MMAdminBuild.table.manyToThis.length] = auxManyToThis;
        }
    }
};

MMAdminBuild.manyToThisSetKeyUpdate = function(manyToThisId){
    $('#manyToThis'+manyToThisId+'Key').off().on({
        'change':function(){
            MMAdminBuild.manyToThisKeyUpdated(manyToThisId);
        }
    }); 
};

MMAdminBuild.manyToThisKeyUpdated = function(manyToThisId){
    var currentKey = $('#manyToThis'+manyToThisId+'Key').val();
    var lastKey = $('#manyToThis'+manyToThisId+'LastKey').val();
    
    $('#manyToThis'+manyToThisId+'Column'+lastKey+'Row').show();
    $('#manyToThis'+manyToThisId+'Column'+currentKey+'Row').hide();
    
    $('#manyToThis'+manyToThisId+'LastKey').val(currentKey);
};

MMAdminBuild.deleteManyToThis = function(localId){
    var auxArray = new Array();
    for(var i=0; i<MMAdminBuild.manyToThis.length; i++)
        if(MMAdminBuild.manyToThis[i].localId!==localId)
           auxArray[auxArray.length] = MMAdminBuild.manyToThis[i];
    MMAdminBuild.manyToThis = auxArray;
    $('#manyToThis'+localId).remove();
};

//------------------------------------------------------------------------------
//--------------------------SEARCH THROUGH TABLES-------------------------------
//------------------------------------------------------------------------------

MMAdminBuild.setSearchThroughTable = function(){
    var tableName = MMAdminBuild.selectedTable.name;
    $('#searchThroughTables').append('<div id="searchThroughTableRoot" class="adminMultiData"><div class="adminDataRow"><div class="adminDataRowSmallTitle">All From:</div><select id="searchThroughTableRootTable" class="adminInput200"><option value="'+tableName+'">'+tableName+'</option></select></div></div>');   
    MMAdminBuild.searchThroughTables = new Array();
    var auxSearchThroughTable = {};
    auxSearchThroughTable.name = MMAdminBuild.selectedTable.name;
    auxSearchThroughTable.columns = MMAdminBuild.selectedTable.columns;
    auxSearchThroughTable.localId = 'root';
    MMAdminBuild.searchThroughTables[0] = auxSearchThroughTable;
};

MMAdminBuild.addSearchThroughTable = function(){
    var localId = Tools.randomString(20);
    var auxSearchThroughTable = {};
    auxSearchThroughTable.localId = localId;
    MMAdminBuild.searchThroughTables[MMAdminBuild.searchThroughTables.length] = auxSearchThroughTable;
    var tableOptions = $('#table').html();
    $('#searchThroughTables').append('<div id="searchThroughTable'+localId+'" class="adminMultiData"><div class="adminDataRow"><div class="adminDataRowSmallTitle">That link to:</div><select id="searchThroughTable'+localId+'Table" class="adminInput200">'+tableOptions+'</select></div></div>');
    
    $('#searchThroughTable'+localId+'Table').off().on({
        'change':function(){
            MMAdminBuild.loadColumnsForSearchThroughTable($(this).val(), localId);
        }
    }); 
};

MMAdminBuild.loadColumnsForSearchThroughTable = function(tableName, searchThroughTableId){
    for(var i=0; i<MMAdminBuild.tables.length; i++)
        if(MMAdminBuild.tables[i].name===tableName)
            MMAdminBuild.setColumnsForSearchThroughTable(searchThroughTableId, tableName, MMAdminBuild.tables[i].columns);
};

MMAdminBuild.setColumnsForSearchThroughTable = function(searchThroughTableId, tableName, columns){
    
    var lastTableColumns = '';
    for(var i=1; i<MMAdminBuild.searchThroughTables.length; i++)
        if(MMAdminBuild.searchThroughTables[i].localId===searchThroughTableId){
            MMAdminBuild.searchThroughTables[i].name = tableName;
            MMAdminBuild.searchThroughTables[i].columns = columns;
            
            lastTableColumns = MMAdminBuild.searchThroughTables[i-1].columns;
        }
                
    var optionsHtml = '';
    if(columns.length>1)
        for(var i=0; i<columns.length; i++)
            optionsHtml += '<option value="'+columns[i].name+'">'+columns[i].name+'</option>';
    
    var lastTableColumnsOptions = '';
    for(var i=0; i<lastTableColumns.length; i++)
        lastTableColumnsOptions += '<option value="'+lastTableColumns[i].name+'">'+lastTableColumns[i].name+'</option>';
    
    $('#searchThroughTable'+searchThroughTableId+'ThroughDiv').remove();
    $('#searchThroughTable'+searchThroughTableId).find('.adminDataRow').append('<div id="searchThroughTable'+searchThroughTableId+'ThroughDiv"><div class="adminDataRowXSmallTitle">through</div><select id="searchThroughTable'+searchThroughTableId+'Through" class="adminInput100">'+lastTableColumnsOptions+'</select></div>');

    $('#searchThroughTable'+searchThroughTableId+'ToDiv').remove();
    $('#searchThroughTable'+searchThroughTableId).find('.adminDataRow').append('<div id="searchThroughTable'+searchThroughTableId+'ToDiv"><div class="adminDataRowXSmallTitle">to</div><select id="searchThroughTable'+searchThroughTableId+'To" class="adminInput100">'+optionsHtml+'</select></div>');
};

MMAdminBuild.getSearchThroughTables = function(){
    MMAdminBuild.table.searchThroughTables = new Array();
    for(var i=0; i<MMAdminBuild.searchThroughTables.length; i++){
        if($('#searchThroughTable'+MMAdminBuild.searchThroughTables[i].localId+'Table').length>0){
            var auxSearchThroughTable = {};
            auxSearchThroughTable.table = $('#searchThroughTable'+MMAdminBuild.searchThroughTables[i].localId+'Table').val();
            auxSearchThroughTable.through = $('#searchThroughTable'+MMAdminBuild.searchThroughTables[i].localId+'Through').val();
            auxSearchThroughTable.to = $('#searchThroughTable'+MMAdminBuild.searchThroughTables[i].localId+'To').val();
            MMAdminBuild.table.searchThroughTables[MMAdminBuild.table.searchThroughTables.length] = auxSearchThroughTable;
        }
    }
};



//------------------------------------------------------------------------------
//------------------------------AUTOMATIC SET-----------------------------------
//------------------------------------------------------------------------------
MMAdminBuild.autoSet = function(){
    for(var i=1; i<MMAdminBuild.selectedTable.columns.length; i++)
        MMAdminBuild.autoSetColumnType(MMAdminBuild.selectedTable.columns[i], 'column'+MMAdminBuild.selectedTable.columns[i].name);
    
    MMAdminBuild.autoSetCheckManyToThis();
    MMAdminBuild.autoSetCheckFiles();
};

MMAdminBuild.autoSetColumnType = function(column, id){
    var obj = $('#'+id+'Type');
    var type = column.type.split('(')[0];
    switch(type){
        case 'tinyint':
            if(column.name==='deleted' || column.name==='is_deleted')
                obj.val(14);
            else
                obj.val(2);
        break;
        case 'int':
            if(column.name.indexOf('_file_id')!==-1){
                obj.val(5);
            }
            else if(column.name.indexOf('_id')!==-1){
                MMAdminBuild.autoSetColumnSelectTable(column.name, id);
            }
            else if(column.name==='position')
                obj.val(13);
            else
                obj.val(7);
        break;
        case 'varchar':
            if(column.name==='email')
                obj.val(16);
            else
                obj.val(0);
        break;
        case 'datetime':
            if(column.name==='updated_on')
                obj.val(15);
            else if(column.name==='created_on')
                obj.val(6);
            else
                obj.val(3);
        break;
        case 'date':
            obj.val(12);
        break;
        case 'float':
            obj.val(8);
        break;
    }
};

MMAdminBuild.autoSetColumnSelectTable = function(columnName, id){
    var suspectedTableName = MMAdminBuild.getPlural(columnName.split('_id')[0]);
    for(var i=0; i<MMAdminBuild.tables.length; i++)
        if(suspectedTableName===MMAdminBuild.tables[i].name){
            $('#'+id+'Type').val(1);
            MMAdminBuild.columnTypeChange(id, 1);
            $('#'+id+'TypeValue').val(suspectedTableName);
        }
};

MMAdminBuild.autoSetCheckManyToThis = function(){
    var manyToThisTables = new Array();
    var tablePreText = MMAdminBuild.getSingular(MMAdminBuild.selectedTable.name)+'_';
    
    for(var i=0; i<MMAdminBuild.tables.length; i++)
        if(MMAdminBuild.tables[i].name.indexOf(tablePreText)!==-1 && MMAdminBuild.tables[i].name.indexOf('files')===-1)
            for(var j=0; j<MMAdminBuild.tables[i].columns.length; j++)
                if(MMAdminBuild.tables[i].columns[j].name === tablePreText+'id')
                    manyToThisTables[manyToThisTables.length] = MMAdminBuild.tables[i];
    
    for(var i=0; i<manyToThisTables.length; i++){
        var localId = MMAdminBuild.addManyToThis();
        $('#manyToThis'+localId+'Table').val(manyToThisTables[i].name);
        MMAdminBuild.loadColumnsForManyToThis(manyToThisTables[i].name, localId);
        
        for(var j=0; j<manyToThisTables[i].columns.length; j++)
            if(manyToThisTables[i].columns[j].name===tablePreText+'id'){
                $('#manyToThis'+localId+'Key').val(manyToThisTables[i].columns[j].name);
                MMAdminBuild.manyToThisKeyUpdated(localId);
            }
        for(var j=0; j<manyToThisTables[i].columns.length; j++)
            MMAdminBuild.autoSetColumnType(manyToThisTables[i].columns[j], 'manyToThis'+localId+'Column'+manyToThisTables[i].columns[j].name);
    }
    
};

MMAdminBuild.autoSetCheckFiles = function(){
    var filesTables = new Array();
    var tablePreText = MMAdminBuild.getSingular(MMAdminBuild.selectedTable.name)+'_';
    
    for(var i=0; i<MMAdminBuild.tables.length; i++)
        if(MMAdminBuild.tables[i].name.indexOf(tablePreText)!==-1 && MMAdminBuild.tables[i].name.indexOf('files')!==-1)
            for(var j=0; j<MMAdminBuild.tables[i].columns.length; j++)
                if(MMAdminBuild.tables[i].columns[j].name === tablePreText+'id')
                    filesTables[filesTables.length] = MMAdminBuild.tables[i];
    
    for(var i=0; i<filesTables.length; i++){
        var localId = MMAdminBuild.addFiles();
        $('#files'+localId+'Table').val(filesTables[i].name);
        MMAdminBuild.loadColumnsForFiles(filesTables[i].name, localId);
        
        for(var j=0; j<filesTables[i].columns.length; j++)
            if(filesTables[i].columns[j].name===tablePreText+'id')
                $('#files'+localId+'Key').val(filesTables[i].columns[j].name);
    }
};

MMAdminBuild.getPlural = function(name){
    var lastLetter = name.substring(name.length-1,name.length);
    var allButLastLetter = name.substring(0,name.length-1);
    if(lastLetter==='y'){
        return allButLastLetter+'ies';
    }
    else if(lastLetter==='s' || lastLetter==='x'){
        return name + 'es';
    }
    else
        return name+'s';
};

MMAdminBuild.getSingular = function(name){
    var last3Letters = name.substring(name.length-3,name.length);
    var last2Letters = name.substring(name.length-2,name.length);
    var lastLetter = name.substring(name.length-1,name.length);
    
    var allButLast3Letters = name.substring(0,name.length-3);
    var allButLast2Letters = name.substring(0,name.length-2);
    var allButLastLetter = name.substring(0,name.length-1);
    
    if(last3Letters==='ies')
        return allButLast3Letters+'y';
    
    if(last2Letters==='es')
        return allButLast2Letters;
    
    if(lastLetter==='s')
        return allButLastLetter;
};