<?php
//------------------------------------------------------------------------------
//----------------------------------Variables-----------------------------------
//------------------------------------------------------------------------------
$variables = "";
$MMAdminModel = "MMAdmin".$modelNames['plural'];
$variables .= "
var ".$MMAdminModel." = {};
".$MMAdminModel.".editMode = false;
".$MMAdminModel.".".$modelNames['singularCamelCase']." = {};
";

if(isset($table['manyToThis']))
    foreach($table['manyToThis'] as $manyToThis){
        $auxManyToThisNames = self::getModelNamesFromTableName($manyToThis['table']);
        $variables .= "
".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$auxManyToThisNames['pluralCamelCase']." = new Array();";
    }

    
foreach($table['columns'] as $column){
    if($column['type']==BuilderTypes::$SINGLE_FILE){
        $columnNames = $this->getModelNamesFromTableName($column['name']);
        $variables .= "
".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$columnNames['noIdCamelCase']."Manager = {};";
    }
}
    
    
if(isset($table['files']))
    foreach($table['files'] as $file){
        $auxManyFileNames = self::getModelNamesFromTableName($file['table']);
        $variables .= "
".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$auxManyFileNames['pluralCamelCase']." = new Array();
".$MMAdminModel.".".$auxManyFileNames['pluralCamelCase']."Manager = {};";
    }
    
//------------------------------------------------------------------------------
//----------------------------------Dates---------------------------------------
//------------------------------------------------------------------------------

$datesData = "";

foreach($table['columns'] as $column)
    if($column['type']==BuilderTypes::$DATETIME){
        $datesData .= "
            
            $('#".$column['name']."').datetimepicker({ 
                dateFormat: 'yy-mm-dd', 
                timeFormat: 'HH:mm:ss',
                beforeShow: function (input, inst) {
                    var offset = $(input).offset();
                    var height = $(input).height();
                    window.setTimeout(function () {
                        inst.dpDiv.css({ top: (offset.top + height + 4) + 'px', left: offset.left + 'px' })
                    }, 1);
                }
            });
            
            ";
    }
    else{
        if($column['type']==BuilderTypes::$DATE){
        $datesData .= "
            
            $('#".$column['name']."').datepicker({ 
                dateFormat: 'yy-mm-dd'
            });
            
            ";
        }
    }

//------------------------------------------------------------------------------
//----------------------------------Binds---------------------------------------
//------------------------------------------------------------------------------
$binds = "
        if($('#savePositions').length>0){
            $('#adminPositions').sortable();

            $('#savePositions').on({
                'click':function(){
                    ".$MMAdminModel.".savePositions();
                }
            });
        }
        else{
            if($('#add".$modelNames['singular']."').length>0){
                $('#add".$modelNames['singular']."').on({
                    'click':function(){
                        if(".$MMAdminModel.".editMode)
                            ".$MMAdminModel.".save();
                        else
                            ".$MMAdminModel.".add();
                    }
                });
            }

            if(".$MMAdminModel.".editMode){
                $('#delete".$modelNames['singular'].", #delete".$modelNames['singular']."Trash').on({
                    'click':function(){
                        var id = parseInt($('#selected".$modelNames['singular']."Id').val());
                        if(id!==0)
                            if(confirm($('#confirmationText').val()))
                                ".$MMAdminModel.".remove(id);
                    }
                });
                ".$MMAdminModel.".searchThroughTableBinds();
                ".$MMAdminModel.".checkSelected".$modelNames['singular']."();
            }
            else{
                if($('#active').length>0)
                    $('#active').attr('class','adminCheckboxChecked');
            }    

            ".$datesData;



if(isset($table['manyToThis']))
    foreach($table['manyToThis'] as $manyToThis){
        $auxManyToThisNames = self::getModelNamesFromTableName($manyToThis['table']);
        $binds .= "
            ".$MMAdminModel.".bind".$auxManyToThisNames['plural']."();";
    }


foreach($table['columns'] as $column){
    if($column['type']==BuilderTypes::$SINGLE_FILE){
        $columnNames = $this->getModelNamesFromTableName($column['name']);
        $binds .= "
        ".$MMAdminModel.".".$columnNames['noIdCamelCase']."Manager = FileManager.newInstance('".$columnNames['noIdCamelCase']."','".$columnNames['noIdCamelCase']."',false,new Array());
        ".$MMAdminModel.".".$columnNames['noIdCamelCase']."Manager.start();";
    }
}
    
    
if(isset($table['files']))
    foreach($table['files'] as $file){
        $auxManyFileNames = self::getModelNamesFromTableName($file['table']);
        $binds .= "
            
        ".$MMAdminModel.".".$auxManyFileNames['pluralCamelCase']."Manager = FileManager.newInstance('".$auxManyFileNames['pluralCamelCase']."','".$auxManyFileNames['pluralCamelCase']."',true,new Array());
        ".$MMAdminModel.".".$auxManyFileNames['pluralCamelCase']."Manager.start();";
    }
    
//------------------------------------------------------------------------------
//----------------------------------Add-----------------------------------------
//------------------------------------------------------------------------------
$add = $MMAdminModel.".add = function(){
    ".$MMAdminModel.".update".$modelNames['singular']."Data();
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/".$modelNames['plural']."/add',
        data:{'".$modelNames['singularCamelCase']."':(".$MMAdminModel.".".$modelNames['singularCamelCase'].")},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.removeLoading(loadCode);
                Tools.alert(response.message,1,function(){Tools.redirect('/".$modelNames['plural']."/viewEdit/'+response.id);});
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
};";    
    
//------------------------------------------------------------------------------
//---------------------------------Save-----------------------------------------
//------------------------------------------------------------------------------
$save = $MMAdminModel.".save = function(){
    ".$MMAdminModel.".update".$modelNames['singular']."Data();
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/".$modelNames['plural']."/save',
        data:{'".$modelNames['singularCamelCase']."':(".$MMAdminModel.".".$modelNames['singularCamelCase'].")},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.removeLoading(loadCode);
                Tools.alert(response.message,1,function(){Tools.redirect('/".$modelNames['plural']."/viewEdit/'+".$MMAdminModel.".".$modelNames['singularCamelCase'].".id);});
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

".$MMAdminModel.".savePositions = function(){
    var ".$modelNames['singularCamelCase']."Ids = new Array();
    $('.adminPosition').each(function() {
        ".$modelNames['singularCamelCase']."Ids[".$modelNames['singularCamelCase']."Ids.length] = $(this).attr('id');
    });
    
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/".$modelNames['plural']."/savePositions',
        data:{'".$modelNames['singularCamelCase']."Ids':(".$modelNames['singularCamelCase']."Ids)},
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


";        
    
//------------------------------------------------------------------------------
//---------------------------------Remove---------------------------------------
//------------------------------------------------------------------------------
$remove = $MMAdminModel.".remove = function(id){
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/".$modelNames['plural']."/delete',
        data:{'id':(id)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.removeLoading(loadCode);
                Tools.alert(response.message,1,function(){Tools.redirect('/".$modelNames['plural']."/viewEdit');});
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
};";        
    
//------------------------------------------------------------------------------
//---------------------------------Update---------------------------------------
//------------------------------------------------------------------------------
$update = $MMAdminModel.".update".$modelNames['singular']."Data = function(){
    var selected".$modelNames['singular']."Id = parseInt($('#selected".$modelNames['singular']."Id').val());
    if(!isNaN(selected".$modelNames['singular']."Id) && selected".$modelNames['singular']."Id!==0)
        ".$MMAdminModel.".".$modelNames['singularCamelCase'].".id = selected".$modelNames['singular']."Id
    else if($('#".$modelNames['singularCamelCase']."Id').length>0)
        ".$MMAdminModel.".".$modelNames['singularCamelCase'].".id = $('#".$modelNames['singularCamelCase']."Id').val();
    else
        ".$MMAdminModel.".".$modelNames['singularCamelCase'].".id = 0;";
     

foreach($table['columns'] as $column){
    if(BuilderTypes::canBeModifiedByUser($column['type']) && $column['type']!=BuilderTypes::$SINGLE_FILE){
        switch($column['type']){
            case BuilderTypes::$CHECKBOX:
                $update .= "
    ".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$column['name']." = Tools.getValueFromCheckbox($('#".$column['name']."'));";
            break;
            default:
                $update .= "
    ".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$column['name']." = $('#".$column['name']."').val();";
            break;
        }
    }
}

if(isset($table['manyToThis']))
    foreach($table['manyToThis'] as $manyToThis){
        $auxManyToThisNames = self::getModelNamesFromTableName($manyToThis['table']);
        $update .= "
    ".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$auxManyToThisNames['pluralCamelCase']." = ".$MMAdminModel.".get".$auxManyToThisNames['plural']."();";
    }
    
foreach($table['columns'] as $column){
    if($column['type']==BuilderTypes::$SINGLE_FILE){
        $columnNames = $this->getModelNamesFromTableName($column['name']);
        $update .= "
    ".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$column['name']." = ".$MMAdminModel.".get".$columnNames['noId']."();";
    }
}

if(isset($table['files']))
    foreach($table['files'] as $file){
        $auxManyFileNames = self::getModelNamesFromTableName($file['table']);
        $update .= "
    ".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$auxManyFileNames['pluralCamelCase']." = ".$MMAdminModel.".get".$auxManyFileNames['plural']."();";
    }

$update .= "
};";
//------------------------------------------------------------------------------
//----------------------------------Check---------------------------------------
//------------------------------------------------------------------------------
$check = $MMAdminModel.".checkSelected".$modelNames['singular']." = function(){
    var id = parseInt($('#".$modelNames['singularCamelCase']."Id').val());
    if(!isNaN(id) && id!==0){
        $('#selected".$modelNames['singular']."Id').val(id);
        ".$MMAdminModel.".load".$modelNames['singular']."(id);
    }
};";
    
    
//------------------------------------------------------------------------------
//-----------------------------------Load---------------------------------------
//------------------------------------------------------------------------------
$load = $MMAdminModel.".load".$modelNames['singular']." = function(id){
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/".$modelNames['plural']."/getArray',
        data:{'id':(id)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                ".$MMAdminModel.".set".$modelNames['singular']."(response.".$modelNames['singularCamelCase'].");
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
};";
    
    
    
//------------------------------------------------------------------------------
//------------------------------------Set---------------------------------------
//------------------------------------------------------------------------------
$set = $MMAdminModel.".set".$modelNames['singular']." = function(".$modelNames['singularCamelCase']."){
    ".$MMAdminModel.".".$modelNames['singularCamelCase']." = ".$modelNames['singularCamelCase'].";
    $('#id').val(".$modelNames['singularCamelCase'].".id);";

foreach($table['columns'] as $column){
    if(BuilderTypes::canBeModifiedByUser($column['type']) && $column['type']!=BuilderTypes::$SINGLE_FILE){
        switch($column['type']){
            case BuilderTypes::$CHECKBOX:
                $set .= "
    if(parseInt(".$modelNames['singularCamelCase'].".".$column['name'].")===1)
        $('#".$column['name']."').attr('class','adminCheckboxChecked');
    else
        $('#".$column['name']."').attr('class','adminCheckbox');
    ";
            break;
            default:
                $set .= "
    \$('#".$column['name']."').val(".$modelNames['singularCamelCase'].".".$column['name'].");";
            break;
        }
    }
}

if(isset($table['manyToThis']))
    foreach($table['manyToThis'] as $manyToThis){
        $auxManyToThisNames = self::getModelNamesFromTableName($manyToThis['table']);
        $set .= "
    ".$MMAdminModel.".add".$auxManyToThisNames['plural']."();";
    }

foreach($table['columns'] as $column){
    if($column['type']==BuilderTypes::$SINGLE_FILE){
        $columnNames = $this->getModelNamesFromTableName($column['name']);
        $set .= "
    ".$MMAdminModel.".add".$columnNames['noId']."();";
    }
}
    
if(isset($table['files']))
    foreach($table['files'] as $file){
        $auxManyFileNames = self::getModelNamesFromTableName($file['table']);
        $set .= "
    ".$MMAdminModel.".add".$auxManyFileNames['plural']."();";
    }
$set .= "
};";

//------------------------------------------------------------------------------
//------------------------------ManyToThis--------------------------------------
//------------------------------------------------------------------------------
$manyToThisData = "";
if(isset($table['manyToThis']))
    foreach($table['manyToThis'] as $manyToThis){
        $auxManyToThisNames = self::getModelNamesFromTableName($manyToThis['table']);
        $auxNameLength = strlen($auxManyToThisNames['plural']); 
        $auxDotLength = floor((79-$auxNameLength)/2);
        $manyToThisData .= "
            
//------------------------------------------------------------------------------
//";
        for($i=0; $i<$auxDotLength; $i++) $manyToThisData .= "-";
        $manyToThisData .= $auxManyToThisNames['plural'];
        for($i=0; $i<$auxDotLength; $i++) $manyToThisData .= "-";
        $manyToThisData .= "
//------------------------------------------------------------------------------";
    
          //----------------------------------------------------------
          //------------------------BIND------------------------------
          //----------------------------------------------------------
        $manyToThisData .= "
            
".$MMAdminModel.".bind".$auxManyToThisNames['plural']." = function(){
    $('#add".$auxManyToThisNames['singular']."').on({
        'click':function(){
            ".$MMAdminModel.".new".$auxManyToThisNames['singular']."();
        }
    });

    $('#".$auxManyToThisNames['pluralCamelCase']."').on({
        'click':function(){
            var randomId = $(this).attr('id').replace('".$auxManyToThisNames['singularCamelCase']."Delete','');
            ".$MMAdminModel.".remove".$auxManyToThisNames['singular']."(randomId);
        }
    },'.adminMultiDataDeleteButton');    
};";
    
          //----------------------------------------------------------
          //------------------------NEW-------------------------------
          //----------------------------------------------------------
        $manyToThisData .= "
            
".$MMAdminModel.".new".$auxManyToThisNames['singular']." = function(){
    var ".$auxManyToThisNames['singularCamelCase']." = {};
    ".$auxManyToThisNames['singularCamelCase'].".localId = Tools.randomString(20);
    ".$auxManyToThisNames['singularCamelCase'].".id = 0;";
        
        foreach($manyToThis['columns'] as $column){
            if($column['name'] != $manyToThis['key'] && BuilderTypes::canBeModifiedByUser($column['type'])){
                switch($column['type']){
                    case BuilderTypes::$SELECT: case BuilderTypes::$CHECKBOX:
                        $manyToThisData .= "
    ".$auxManyToThisNames['singularCamelCase'].".".$column['name']." = 0;";
                        break;
                    default:
                        $manyToThisData .= "
    ".$auxManyToThisNames['singularCamelCase'].".".$column['name']." = '';";
                        break;
                }
            }
        }
        
        $manyToThisData .= "
    ".$auxManyToThisNames['singularCamelCase'].".deleted = 0;
    ".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$auxManyToThisNames['pluralCamelCase']."[".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$auxManyToThisNames['pluralCamelCase'].".length] = ".$auxManyToThisNames['singularCamelCase'].";
    ".$MMAdminModel.".add".$auxManyToThisNames['singular']."HTML(".$auxManyToThisNames['singularCamelCase'].");
};";
    
          //----------------------------------------------------------
          //------------------------ADD-------------------------------
          //----------------------------------------------------------
        
        $manyToThisData .= "
            
".$MMAdminModel.".add".$auxManyToThisNames['plural']." = function(){
    var titlesHtml = $('#".$auxManyToThisNames['pluralCamelCase']."').find('.adminMultiDataTitle').html();
    $('#".$auxManyToThisNames['pluralCamelCase']."').html('<tr class=\"adminMultiDataTitle\">'+titlesHtml+'</tr>');
    for(var i=0; i<".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$auxManyToThisNames['pluralCamelCase'].".length; i++){
        var ".$auxManyToThisNames['singularCamelCase']." = ".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$auxManyToThisNames['pluralCamelCase']."[i];
        ".$auxManyToThisNames['singularCamelCase'].".localId = Tools.randomString(20);
        ".$auxManyToThisNames['singularCamelCase'].".deleted = 0;
        ".$MMAdminModel.".add".$auxManyToThisNames['singular']."HTML(".$auxManyToThisNames['singularCamelCase'].");
    }
};";
        
          //----------------------------------------------------------
          //---------------------ADD HTML-----------------------------
          //----------------------------------------------------------
        $selectLoadData = "";
        $manyToThisData .= "
            
".$MMAdminModel.".add".$auxManyToThisNames['singular']."HTML = function(".$auxManyToThisNames['singularCamelCase']."){
    var html = '';
    html += \"<tr id='".$auxManyToThisNames['singularCamelCase']."\"+".$auxManyToThisNames['singularCamelCase'].".localId+\"' class='adminMultiDataRow'>\";
    html += \"<td><input id='".$auxManyToThisNames['singularCamelCase']."Id\"+".$auxManyToThisNames['singularCamelCase'].".localId+\"' type='hidden' value='\"+".$auxManyToThisNames['singularCamelCase'].".id+\"'/></td>\";";
    
        foreach($manyToThis['columns'] as $column){
            if($column['name'] != $manyToThis['key'] && BuilderTypes::canBeModifiedByUser($column['type'])){
                $auxColumnNames = self::getModelNamesFromTableName($column['name']);
                switch($column['type']){
                     case BuilderTypes::$CHECKBOX:
                         $manyToThisData .= "
    if(parseInt(".$auxManyToThisNames['singularCamelCase'].".".$column['name'].")===1)
        html += \"<td><div id='".$auxManyToThisNames['singularCamelCase'].$auxColumnNames['plural']."\"+".$auxManyToThisNames['singularCamelCase'].".localId+\"' class='adminCheckboxChecked'></div></td>\";
    else
        html += \"<td><div id='".$auxManyToThisNames['singularCamelCase'].$auxColumnNames['plural']."\"+".$auxManyToThisNames['singularCamelCase'].".localId+\"' class='adminCheckbox'></div></td>\";";
                        break;
                    case BuilderTypes::$SELECT:
                        $manyToThisData .= "
    html += \"<td><select id='".$auxManyToThisNames['singularCamelCase'].$auxColumnNames['plural']."\"+".$auxManyToThisNames['singularCamelCase'].".localId+\"' class='adminMultiDataInput100'></select>\";";
    $auxSelectNames = self::getModelNamesFromTableName($column['typeValue']);
    $selectLoadData .= "
    ".$MMAdminModel.".load".$auxSelectNames['plural']."For".$auxManyToThisNames['singular']."('".$auxManyToThisNames['singularCamelCase'].$auxColumnNames['plural']."'+".$auxManyToThisNames['singularCamelCase'].".localId, ".$auxManyToThisNames['singularCamelCase'].".".$column['name'].");";                    
                        break;
                    default:
                        $manyToThisData .= "
    html += \"<td><input type='text' id='".$auxManyToThisNames['singularCamelCase'].$auxColumnNames['plural']."\"+".$auxManyToThisNames['singularCamelCase'].".localId+\"' class='adminMultiDataInput100' value='\"+".$auxManyToThisNames['singularCamelCase'].".".$column['name']."+\"'/></td>\";";
                        break;
                }
            }
        }
        
        $manyToThisData .= "
    html += \"<img id='".$auxManyToThisNames['singularCamelCase']."Delete\"+".$auxManyToThisNames['singularCamelCase'].".localId+\"' class='adminMultiDataTrash' src='/files/layouts/trash.png' alt='moonideas remove icon'/><div id='".$auxManyToThisNames['singularCamelCase']."Delete\"+".$auxManyToThisNames['singularCamelCase'].".localId+\"' class='adminMultiDataDeleteButton'>eliminar</div></td>\";
    html += \"</tr>\";

    $('#".$auxManyToThisNames['pluralCamelCase']."').append(html);".$selectLoadData."
};";
    
          //----------------------------------------------------------
          //-----------------------REMOVE-----------------------------
          //----------------------------------------------------------
        
        $manyToThisData .= "

".$MMAdminModel.".remove".$auxManyToThisNames['singular']." = function(localId){
    $('#".$auxManyToThisNames['singularCamelCase']."'+localId).remove();
    
    for(var i=0; i<".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$auxManyToThisNames['pluralCamelCase'].".length; i++)
        if(".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$auxManyToThisNames['pluralCamelCase']."[i].localId===localId)
            ".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$auxManyToThisNames['pluralCamelCase']."[i].deleted = 1;
};";
          //----------------------------------------------------------
          //------------------GET SELECT OPTIONS----------------------
          //----------------------------------------------------------
    
        foreach($manyToThis['columns'] as $column){
            if($column['name'] != $manyToThis['key'] && $column['type']==BuilderTypes::$SELECT){
                $auxColumnNames = self::getModelNamesFromTableName($column['name']);
                $auxSelectNames = self::getModelNamesFromTableName($column['typeValue']); 
        
        $manyToThisData .= "

".$MMAdminModel.".load".$auxSelectNames['plural']."For".$auxManyToThisNames['singular']." = function(id, selectedOptionId){
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/".$auxSelectNames['plural']."/getAllArray',
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                var optionsHtml = '';
                for(var i=0; i<response.".$auxSelectNames['pluralCamelCase'].".length; i++)
                    optionsHtml += '<option value=\"'+response.".$auxSelectNames['pluralCamelCase']."[i].id+'\">'+response.".$auxSelectNames['pluralCamelCase']."[i].name+'</option>';
                $('#'+id).html(optionsHtml);
                
                if(parseInt(selectedOptionId)!==0)
                    $('#'+id).val(selectedOptionId);
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
};";
            }
        }
        
          //----------------------------------------------------------
          //------------------------GET-------------------------------
          //----------------------------------------------------------
        
        $manyToThisData .= "
            
".$MMAdminModel.".get".$auxManyToThisNames['plural']." = function(){
    var ".$auxManyToThisNames['pluralCamelCase']."Aux = new Array();
    for(var i=0; i<".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$auxManyToThisNames['pluralCamelCase'].".length; i++){
        var ".$auxManyToThisNames['singularCamelCase']." = ".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$auxManyToThisNames['pluralCamelCase']."[i];
        var localId = ".$auxManyToThisNames['singularCamelCase'].".localId;
        if($('#".$auxManyToThisNames['singularCamelCase']."'+localId).length>0){
            var ".$auxManyToThisNames['singularCamelCase']."Aux = {};
            ".$auxManyToThisNames['singularCamelCase']."Aux.localId = localId;
            ".$auxManyToThisNames['singularCamelCase']."Aux.id = $('#".$auxManyToThisNames['singularCamelCase']."Id'+localId).val();";
        
        
        foreach($manyToThis['columns'] as $column){
            if($column['name'] != $manyToThis['key'] && BuilderTypes::canBeModifiedByUser($column['type'])){
                $auxColumnNames = self::getModelNamesFromTableName($column['name']);
                switch($column['type']){
                    case BuilderTypes::$CHECKBOX:
                        $manyToThisData .= "
            ".$auxManyToThisNames['singularCamelCase']."Aux.".$column['name']." = Tools.getValueFromCheckbox($('#".$auxManyToThisNames['singularCamelCase'].$auxColumnNames['plural']."'+localId));";
                        break;
                    default:
                        $manyToThisData .= "
            ".$auxManyToThisNames['singularCamelCase']."Aux.".$column['name']." = $('#".$auxManyToThisNames['singularCamelCase'].$auxColumnNames['plural']."'+localId).val();";
                        break;
                }
            }
        }
        $manyToThisData .= "
            ".$auxManyToThisNames['singularCamelCase']."Aux.deleted = 0;";
        
        $manyToThisData .= "
            ".$auxManyToThisNames['pluralCamelCase']."Aux[".$auxManyToThisNames['pluralCamelCase']."Aux.length] = ".$auxManyToThisNames['singularCamelCase']."Aux;
        }
        else if(".$auxManyToThisNames['singularCamelCase'].".deleted===1){
            ".$auxManyToThisNames['pluralCamelCase']."Aux[".$auxManyToThisNames['pluralCamelCase']."Aux.length] = ".$auxManyToThisNames['singularCamelCase'].";
        }
    }
    ".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$auxManyToThisNames['pluralCamelCase']." = ".$auxManyToThisNames['pluralCamelCase']."Aux;
    return ".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$auxManyToThisNames['pluralCamelCase'].";
};";
        
    }
    

//------------------------------------------------------------------------------
//---------------------------------Files----------------------------------------
//------------------------------------------------------------------------------
    
$filesData = "";
    
foreach($table['columns'] as $column){
    if($column['type']==BuilderTypes::$SINGLE_FILE){
        $columnNames = $this->getModelNamesFromTableName($column['name']);
        
        $auxNameLength = strlen($columnNames['plural']); 
        $auxDotLength = floor((79-$auxNameLength)/2);
        $filesData .= "
            
//------------------------------------------------------------------------------
//";
        for($i=0; $i<$auxDotLength; $i++) $filesData .= "-";
        $filesData .= $columnNames['plural'];
        for($i=0; $i<$auxDotLength; $i++) $filesData .= "-";
        $filesData .= "
//------------------------------------------------------------------------------";
    
        $filesData .= "
".$MMAdminModel.".get".$columnNames['noId']." = function(){
    var file = ".$MMAdminModel.".".$columnNames['noIdCamelCase']."Manager.getFiles();
    if(file!==false)
        return file.id;
    else
        return '';
};

".$MMAdminModel.".add".$columnNames['noId']." = function(){
    if(".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$columnNames['noIdCamelCase'].".length!==0)
        ".$MMAdminModel.".".$columnNames['noIdCamelCase']."Manager.updateFiles([".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$columnNames['noIdCamelCase']."]);
    else
        ".$MMAdminModel.".".$columnNames['noIdCamelCase']."Manager.updateFiles([]);
};";
    }
}
    
    
if(isset($table['files']))
    foreach($table['files'] as $file){
        $auxFileNames = self::getModelNamesFromTableName($file['table']);
        $auxNameLength = strlen($auxFileNames['plural']); 
        $auxDotLength = floor((79-$auxNameLength)/2);
        $filesData .= "
            
//------------------------------------------------------------------------------
//";
        for($i=0; $i<$auxDotLength; $i++) $filesData .= "-";
        $filesData .= $auxFileNames['plural'];
        for($i=0; $i<$auxDotLength; $i++) $filesData .= "-";
        $filesData .= "
//------------------------------------------------------------------------------";
    
        $filesData .= "

".$MMAdminModel.".get".$auxFileNames['plural']." = function(){
    ".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$auxFileNames['pluralCamelCase']." = ".$MMAdminModel.".".$auxFileNames['pluralCamelCase']."Manager.getFiles();
    return ".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$auxFileNames['pluralCamelCase'].";
};

".$MMAdminModel.".add".$auxFileNames['plural']." = function(){
    ".$MMAdminModel.".".$auxFileNames['pluralCamelCase']."Manager.updateFiles(".$MMAdminModel.".".$modelNames['singularCamelCase'].".".$auxFileNames['pluralCamelCase'].");
};";
    }
    

//------------------------------------------------------------------------------
//---------------------------SearchThroughTables--------------------------------
//------------------------------------------------------------------------------
$searchThroughTablesBinds = "
".$MMAdminModel.".searchThroughTableBinds = function(){
"; 
$searchThroughTablesData = "
            
//------------------------------------------------------------------------------
//---------------------------SearchThroughTables--------------------------------
//------------------------------------------------------------------------------
";

if(isset($table['searchThroughTables'])){
           
    for($i=0; $i<count($table['searchThroughTables']); $i++){
        if($i!=(count($table['searchThroughTables'])-1)){
            $searchThroughTable = $table['searchThroughTables'][$i];
            $searchThroughTableNames = self::getModelNamesFromTableName($searchThroughTable['table']);
            $searchThroughPreviousTableNames = self::getModelNamesFromTableName($table['searchThroughTables'][$i+1]['table']);
            $searchThroughTablesData .= "
".$MMAdminModel.".getAll".$searchThroughTableNames['plural']."From".$searchThroughPreviousTableNames['singular']." = function(){
    var ".$searchThroughTable['through']." = \$('#selected".$searchThroughPreviousTableNames['singular']."Id').val();
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/".$searchThroughTableNames['plural']."/getAllFrom".$searchThroughPreviousTableNames['singular']."Array',
        data: {".$searchThroughTable['through'].":(".$searchThroughTable['through'].")},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                var optionsHtml = '<option value=\"0\">Seleccione un ".$searchThroughTableNames['singularSpaces']."</option>';
                for(var i=0; i<response.".$searchThroughTableNames['pluralCamelCase'].".length; i++)
                    optionsHtml += '<option value=\"'+response.".$searchThroughTableNames['pluralCamelCase']."[i].id+'\">'+response.".$searchThroughTableNames['pluralCamelCase']."[i].name+'</option>';
                $('#selected".$searchThroughTableNames['singular']."Id').html(optionsHtml);
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
};";
           $searchThroughTablesBinds .= "
   \$('#selected".$searchThroughPreviousTableNames['singular']."Id').on({
       'change':function(){
            ".$MMAdminModel.".getAll".$searchThroughTableNames['plural']."From".$searchThroughPreviousTableNames['singular']."();
        }
   });
"; 
        }
    }
    $searchThroughPreviousTable = $table['searchThroughTables'][0];
    $searchThroughPreviousTableNames = self::getModelNamesFromTableName($searchThroughPreviousTable['table']);
    
    $searchThroughTablesBinds .= "
   \$('#selected".$searchThroughPreviousTableNames['singular']."Id').on({
       'change':function(){
            ".$MMAdminModel.".getAll".$modelNames['plural']."From".$searchThroughPreviousTableNames['singular']."();
        }
   });
"; 
    
    $searchThroughTablesData .= "
".$MMAdminModel.".getAll".$modelNames['plural']."From".$searchThroughPreviousTableNames['singular']." = function(){
    var ".$searchThroughPreviousTable['through']." = \$('#selected".$searchThroughPreviousTableNames['singular']."Id').val();
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/".$modelNames['plural']."/getAllFrom".$searchThroughPreviousTableNames['singular']."Array',
        data: {".$searchThroughPreviousTable['through'].":(".$searchThroughPreviousTable['through'].")},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                var optionsHtml = '<option value=\"0\">Seleccione un ".$modelNames['singularSpaces']."</option>';
                for(var i=0; i<response.".$modelNames['pluralCamelCase'].".length; i++)
                    optionsHtml += '<option value=\"'+response.".$modelNames['pluralCamelCase']."[i].id+'\">'+response.".$modelNames['pluralCamelCase']."[i].name+'</option>';
                $('#selected".$modelNames['singular']."Id').html(optionsHtml);
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
};";
}
$searchThroughTablesBinds .= "
   \$('#selected".$modelNames['singular']."Id').on({
       'change':function(){
            var id = $(this).val();
            if(!isNaN(id) && id!==0)
                ".$MMAdminModel.".load".$modelNames['singular']."(id);
        }
   });
};";

//------------------------------------------------------------------------------
//------------------------------------DATA--------------------------------------
//------------------------------------------------------------------------------
$data = $variables."
    
$(document).ready(
    function(){
        ".$MMAdminModel.".editMode = $('#selected".$modelNames['singular']."Id').length>0;"
        .$binds."
        }
});

".$add."
    
".$save."
    
".$remove."
    
".$update."
    
".$check."
    
".$load."
    
".$set."
        
".$manyToThisData."
        
".$filesData."

".$searchThroughTablesData."

".$searchThroughTablesBinds;
?>