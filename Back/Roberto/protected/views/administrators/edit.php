<script type='text/javascript' src='/js/fileManager.js'></script>
<link href='/css/fileManager.css' rel='stylesheet' type='text/css'/>
<script type='text/javascript' src='/js/administrators/admin.js'></script>

<div class='adminTitle'>Editar Administrator</div>
<input type='hidden' id='administratorId' value='<?php echo($id); ?>'/>
    
<div class='adminData'> 
    
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'>Administrator:</div>
        <select id='selectedAdministratorId' class='adminInput300'>
            <option value='0'>Seleccione un Administrator</option>
            <?php 
                foreach($administrators as $administrator){
            ?>
            <option value='<?php echo $administrator->id;?>'><?php echo HelperFunctions::purify($administrator->name);?></option>
            <?php
                }
            ?>
        </select>
        <div id='deleteAdministrator' class='adminDeleteButton'>eliminar</div>
        <input type='hidden' id='confirmationText' value='¿Está seguro que quiere eliminar el Administrator?'/>
    </div>
    <div class='adminDataRow'>
        <div class='adminEditSeparation'></div>
    </div>
    <?php echo $this->renderPartial('form',array('administratorRoles'=>$administratorRoles, ));?>
    
    <div class='adminDataRow'>
        <div id='addAdministrator' class='adminSaveButton color1 backgroundColor1'>
            Guardar
        </div>
    </div>enderPartial('form',array('administratorRoles'=>$administratorRoles, ));?>
    
    <div class='adminDataRow'>
        <div id='resetPassword' class='adminSaveButton color1 backgroundColor1' style="width:300px;">
            Resetear Contraseña
        </div>
    </div>
</div>