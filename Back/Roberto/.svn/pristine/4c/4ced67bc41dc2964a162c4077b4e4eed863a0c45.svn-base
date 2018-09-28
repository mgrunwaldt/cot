<?php
    //--------------------------------------------------------------------------
    //------------------------------Positions-----------------------------------
    //--------------------------------------------------------------------------


    $positions = false;
    $positionsData = '';
    
    foreach($table['columns'] as $column)
        if($column['type']==BuilderTypes::$POSITION)
            $positions = true;
        
    if($positions){
        $positionsData = "
<?php if(count(\$".$modelNames['pluralCamelCase'].")>0){ ?>
    <div id='adminPositionsTitle'>Posiciones</div>
    <div id='adminPositions'>
        <?php foreach(\$".$modelNames['pluralCamelCase']." as \$".$modelNames['singularCamelCase']."){ ?>
            <div id='<?php echo($".$modelNames['singularCamelCase']."->id);?>' class='adminPosition'><?php echo($".$modelNames['singularCamelCase']."->name);?></div>
        <?php } ?>
    </div>
    <div class='adminDataRow'>
        <div id='savePositions' class='adminSaveButton'>
            Guardar Posiciones
        </div>
    </div>
<?php } ?>
    <div class='adminDataSpace100'></div>
        ";
    }

    
$data = "";
if($positions)
    $data .= "<script type='text/javascript' src='/js/".$modelNames['pluralCamelCase']."/admin.js'></script>";
    
    
$data .= "

<div class='adminTitle'><?php echo(".$modelNames['plural']."::getModelName('plural'));?></div>
<div class='adminSubtitle'>Creá, editá, eliminá y posicioná tus diferentes <?php echo(".$modelNames['plural']."::getModelName('plural'));?></div>
<div class='adminTitleLine backgroundColor4'></div>
<div class='adminData'>
    <div class='adminMainOptions color1'>
        <a class='adminMainOption backgroundColor1' href='/index.php/".$modelNames['plural']."/viewAdd'>Nuevo</a>
        <a class='adminMainOption backgroundColor1' href='/index.php/".$modelNames['plural']."/viewEdit'>Editar/Eliminar</a>
    </div>
</div>
".$positionsData;
?>