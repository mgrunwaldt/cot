<?php

//--------------------------------------------------------------------------
//-----------------------------DATES----------------------------------------
//--------------------------------------------------------------------------

$dates = false;
$datesData = "";

foreach($table['columns'] as $column)
    if($column['type']==BuilderTypes::$DATE || $column['type']==BuilderTypes::$DATETIME)
        $dates = true;

if($dates)
    $datesData = "<script type='text/javascript' src='/js/jquery/timePicker.js'></script>
<link href='/css/timePicker.css' rel='stylesheet' type='text/css'/>";


$actionViewAddArrayHTML = "";
foreach($table['columns'] as $column){
    if($column['type']==BuilderTypes::$SELECT){
        $modelNamesAux = self::getModelNamesFromTableName($column['typeValue']);
        $actionViewAddArrayHTML .= "'".$modelNamesAux['pluralCamelCase']."'=>\$".$modelNamesAux['pluralCamelCase'].', ';
    }
}

//------------------------------------------------------------------------------
//-------------------------------FileLinks--------------------------------------
//------------------------------------------------------------------------------
$fileManagerLinks = "";
if(isset($table['files']))
    $fileManagerLinks = "<script type='text/javascript' src='/js/fileManager.js'></script>
<link href='/css/fileManager.css' rel='stylesheet' type='text/css'/>";

//------------------------------------------------------------------------------
//------------------------------------Search------------------------------------
//------------------------------------------------------------------------------
$searchCode = "<div class='adminData backgroundColor5'>";

if(isset($table['searchThroughTables'])){
    for($i=0; $i<count($table['searchThroughTables']); $i++){
        $searchThroughTableNames = self::getModelNamesFromTableName($table['searchThroughTables'][$i]['table']);
        if($i==count($table['searchThroughTables'])-1){
            $searchCode = "
    <div class='adminDataSearchRow'>
        <div class='adminDataSearchRowTitle'><?php echo(".$searchThroughTableNames['plural']."::getModelName('singular'));?>:</div>
        <select id='selected".$searchThroughTableNames['singular']."Id' class='adminInput300'>
            <option value='0'>Seleccione un <?php echo(".$searchThroughTableNames['plural']."::getModelName('singular'));?></option>
            <?php 
                foreach(\$".$searchThroughTableNames['pluralCamelCase']." as \$".$searchThroughTableNames['singularCamelCase']."){
            ?>
                <option value='<?php echo \$".$searchThroughTableNames['singularCamelCase']."->id;?>'><?php echo \$".$searchThroughTableNames['singularCamelCase']."->name;?></option>
            <?php
                }
            ?>
        </select>
    </div>".$searchCode;
        }
        else{
            $searchCode .= "
    <div class='adminDataSearchRow'>
        <div class='adminDataSearchRowTitle'><?php echo(".$searchThroughTableNames['plural']."::getModelName('singular'));?>:</div>
        <select id='selected".$searchThroughTableNames['singular']."Id' class='adminInput300'>
        </select>
    </div>";
        }
    }
    $searchCode .= "
    <div class='adminDataSearchRow'>
        <div class='adminDataSearchRowTitle'><?php echo(".$modelNames['plural']."::getModelName('singular'));?>:</div>
        <select id='selected".$modelNames['singular']."Id' class='adminInput300'>
        </select>
        <div id='delete".$modelNames['singular']."' class='adminDeleteButton'>eliminar</div>
        <input type='hidden' id='confirmationText' value='¿Está seguro que quiere eliminar el <?php echo(".$modelNames['plural']."::getModelName('singular'));?>?'/>
    </div>
</div>";
}
else{
    $searchCode .= "
    <div class='adminDataSearchRow'>
        <div class='adminDataSearchRowTitle'>".$modelNames['singularSpaces'].":</div>
        <select id='selected".$modelNames['singular']."Id' class='adminInput300'>
            <option value='0'>Seleccione un ".$modelNames['singularSpaces']."</option>
            <?php 
                foreach(\$".$modelNames['pluralCamelCase']." as \$".$modelNames['singularCamelCase']."){
            ?>
                <option value='<?php echo \$".$modelNames['singularCamelCase']."->id;?>'><?php echo \$".$modelNames['singularCamelCase']."->name;?></option>
            <?php
                }
            ?>
        </select>
        <img id='delete".$modelNames['singular']."Trash' class='deleteModelTrash' src='/files/layouts/trash.png' alt='moonideas remove icon'>
        <div id='delete".$modelNames['singular']."' class='deleteModelButton'>eliminar</div>
        <input type='hidden' id='confirmationText' value='¿Está seguro que quiere eliminar el <?php echo(".$modelNames['plural']."::getModelName('singular'));?>?'/>
    </div>
</div>";
}



$data = $datesData.$fileManagerLinks."
<script type='text/javascript' src='/js/".$modelNames['pluralCamelCase']."/admin.js'></script>

<div class='adminTitle'>Editar <?php echo(".$modelNames['plural']."::getModelName('singular'));?></div>
<div class='adminSubtitle'>Elija el <?php echo(".$modelNames['plural']."::getModelName('plural'));?> a editar/eliminar, los datos se cargarán automáticamente</div>
<div class='adminTitleLine backgroundColor4'></div>
<input type='hidden' id='".$modelNames['singularCamelCase']."Id' value='<?php echo(\$id); ?>'/>
".$searchCode."
<div class='adminDataRow'>
    <div class='adminEditSeparation'></div>
</div>
<?php echo \$this->renderPartial('form',array(".$actionViewAddArrayHTML."));?>

<div class='adminDataRow'>
    <div id='add".$modelNames['singular']."' class='adminSaveButton color1 backgroundColor1'>
        Guardar
    </div>
</div>";
?>