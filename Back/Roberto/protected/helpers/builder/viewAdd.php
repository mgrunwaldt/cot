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
$actionViewAddArrayHTML = "";
foreach($table['columns'] as $column){
    if($column['type']==BuilderTypes::$SELECT){
        $modelNamesAux = self::getModelNamesFromTableName($column['typeValue']);
        $actionViewAddArrayHTML .= "'".$modelNamesAux['pluralCamelCase']."'=>\$".$modelNamesAux['pluralCamelCase'].', ';
    }
}

$fileManagerLinks = "";
if(isset($table['files']))
    $fileManagerLinks = "<script type='text/javascript' src='/js/fileManager.js'></script>
<link href='/css/fileManager.css' rel='stylesheet' type='text/css'/>";

$data = $datesData.$fileManagerLinks."
<script type='text/javascript' src='/js/".$modelNames['pluralCamelCase']."/admin.js'></script>

<div class='adminTitle'>Agregar <?php echo(".$modelNames['plural']."::getModelName('singular'));?></div>
<div class='adminSubtitle'>Completá los datos para agregar un nuevo <?php echo(".$modelNames['plural']."::getModelName('plural'));?></div>
<div class='adminTitleLine backgroundColor4'></div>
<?php echo \$this->renderPartial('form',array(".$actionViewAddArrayHTML."));?>
    
<div class='adminDataRow'>
    <div id='add".$modelNames['singular']."' class='adminSaveButton color1 backgroundColor1'>
        Agregar
    </div>
</div>";
?>