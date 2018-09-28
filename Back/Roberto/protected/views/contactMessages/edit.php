
<script type='text/javascript' src='/js/contactMessages/admin.js'></script>

<div class='adminTitle'>Editar <?php echo(ContactMessages::getModelName('singular'));?></div>
<div class='adminSubtitle'>Elija el <?php echo(ContactMessages::getModelName('plural'));?> a editar/eliminar, los datos se cargarán automáticamente</div>
<div class='adminTitleLine backgroundColor4'></div>
<input type='hidden' id='contactMessagId' value='<?php echo($id); ?>'/>
<div class='adminData backgroundColor5'>
    <div class='adminDataSearchRow'>
        <div class='adminDataSearchRowTitle'>Contact Messag:</div>
        <select id='selectedContactMessagId' class='adminInput300'>
            <option value='0'>Seleccione un Contact Messag</option>
            <?php 
                foreach($contactMessages as $contactMessag){
            ?>
                <option value='<?php echo $contactMessag->id;?>'><?php echo $contactMessag->name;?></option>
            <?php
                }
            ?>
        </select>
        <img id='deleteContactMessagTrash' class='deleteModelTrash' src='/files/layouts/trash.png' alt='moonideas remove icon'>
        <div id='deleteContactMessag' class='deleteModelButton'>eliminar</div>
        <input type='hidden' id='confirmationText' value='¿Está seguro que quiere eliminar el <?php echo(ContactMessages::getModelName('singular'));?>?'/>
    </div>
</div>
<div class='adminDataRow'>
    <div class='adminEditSeparation'></div>
</div>
<?php echo $this->renderPartial('form',array());?>

<div class='adminDataRow'>
    <div id='addContactMessag' class='adminSaveButton color1 backgroundColor1'>
        Guardar
    </div>
</div>