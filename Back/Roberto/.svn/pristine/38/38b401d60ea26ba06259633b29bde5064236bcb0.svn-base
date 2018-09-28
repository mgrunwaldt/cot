<?php
$totalLength=500;
$mainData = "<div class='adminData backgroundColor5'>";

foreach($table['columns'] as $column){
    if(BuilderTypes::canBeModifiedByUser($column['type'])){
        $auxNames = self::getModelNamesFromTableName($column['name']);
        
        if($column['type']==BuilderTypes::$SINGLE_FILE)
            $mainData .= "
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'><?php echo(".$modelNames['plural']."::getAttributeName('".$column['name']."'));?>:</div>
    </div>";
        else if($column['type']==BuilderTypes::$CHECKBOX)
            $mainData .= "
    <div class='adminDataRow'>
        <div class='adminDataRowTitle floatLeft'><?php echo(".$modelNames['plural']."::getAttributeName('".$column['name']."'));?>:</div>";
        else
            $mainData .= "
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'><?php echo(".$modelNames['plural']."::getAttributeName('".$column['name']."'));?>:</div>";
        
        switch($column['type']){
            
            case BuilderTypes::$SINGLE_FILE:
                $mainData .= "
        <div id='".$auxNames['noIdCamelCase']."' class='adminFiles'>";
            break;
            
            case BuilderTypes::$CHECKBOX:
                $mainData .= "
        <div id='".$column['name']."' class='adminCheckbox'></div>";
            break;
        
            case BuilderTypes::$SELECT:
                $auxTableNames = self::getModelNamesFromTableName($column['typeValue']);
                $mainData .= "
        <select id='".$column['name']."' class='adminInput300'>
            <?php foreach(\$".$auxTableNames['pluralCamelCase']." as \$".$auxTableNames['singularCamelCase']."){ ?>
                <option value='<?php echo \$".$auxTableNames['singularCamelCase']."->id;?>'><?php echo \$".$auxTableNames['singularCamelCase']."->name;?></option>
            <?php } ?>
        </select>";
            break;
        
            case BuilderTypes::$STRING: case BuilderTypes::$EMAIL:
                $columnLength = $this->getColumnLength($table['name'],$column['name']);
                if($columnLength==0)
                    $mainData .= "
            <textarea type='text' id='".$column['name']."' class='adminTextArea'></textarea>";
                else
                    $mainData .= "
        <input type='text' id='".$column['name']."' class='adminInput300'/>";
                break;
                
            default:
                $mainData .= "
        <input type='text' id='".$column['name']."' class='adminInput300'/>";
                break;
        }
        $mainData .= "
    </div>";
    }
}

$manyToThisData = "";
if(isset($table['manyToThis']))
    foreach($table['manyToThis'] as $manyToThis){
        $auxManyToThisNames = self::getModelNamesFromTableName($manyToThis['table']);
        $manyToThisData .= "
            
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'><?php echo(".$auxManyToThisNames['plural']."::getModelName('plural'));?>:</div>
    </div>
    <div class='adminMultiData'>
        <table id='".$auxManyToThisNames['pluralCamelCase']."' class='adminMultiDataTable'>
            <tr class='adminMultiDataTitle'>
                <td width='100px'></td>";
        foreach($manyToThis['columns'] as $column){
            if(BuilderTypes::canBeModifiedByUser($column['type']) && $column['name']!=$manyToThis['key']){
                $auxNames = self::getModelNamesFromTableName($column['name']);
                //$auxLength = $this->getInputLength($this->getColumnLength($manyToThis['table'],$column['name']));
                $manyToThisData .= "
                <td><?php echo(".$auxManyToThisNames['plural']."::getAttributeName('".$column['name']."'));?></td>";
            }
        }
        $spaceLeft = 0;
       
        if($totalLength<800)
            $spaceLeft = (800 - $totalLength)/2;
        $manyToThisData .= "
                <td width='100px'></td>
            </tr>
        </table>
        <div id='add".$auxManyToThisNames['singular']."' class='adminMultiDataAddButton backgroundColor1 color1'>agregar</div>
    </div>";
        $manyToThisData = str_replace('%&/()', $spaceLeft, $manyToThisData);
    }

           
$fileData = "";
if(isset($table['files']))
    foreach($table['files'] as $file){
        $auxNames = self::getModelNamesFromTableName($file['table']);
        $manyToThisData .= "
            
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'>Archivos:</div>
    </div>
    <div id='".$auxNames['pluralCamelCase']."' class='adminFiles'>
    </div>";
    }

    
$data = $mainData.$manyToThisData.$fileData.'
</div>';
?>