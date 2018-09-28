
<script type='text/javascript' src='/js/webTexts/admin.js'></script>

<div class='adminTitle'>Editar Web Text</div>
<input type='hidden' id='webTextId' value='<?php echo($id); ?>'/>
    
<div class='adminData'> 
    
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'>Web Text:</div>
        <select id='selectedWebTextId' class='adminInput300'>
            <option value='0'>Seleccione un Web Text</option>
            <?php 
                foreach($webTexts as $webText){
            ?>
                <option value='<?php echo $webText->id;?>'><?php echo $webText->name;?></option>
            <?php
                }
            ?>
        </select>
        <div id='deleteWebText' class='adminDeleteButton'>eliminar</div>
        <input type='hidden' id='confirmationText' value='¿Está seguro que quiere eliminar el Web Text?'/>
    </div>
    <div class='adminDataRow'>
        <div class='adminEditSeparation'></div>
    </div>
    <?php echo $this->renderPartial('form',array());?>
    
    <div class='adminDataRow'>
        <div id='addWebText' class='adminSaveButton'>
            Guardar
        </div>
    </div>
</div>