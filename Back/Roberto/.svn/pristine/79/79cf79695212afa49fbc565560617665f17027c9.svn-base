
<script type='text/javascript' src='/js/users/admin.js'></script>

<div class='adminTitle'>Editar <?php echo(Users::getModelName('singular'));?></div>
<div class='adminSubtitle'>Elija el <?php echo(Users::getModelName('singular'));?> a editar/eliminar, los datos se cargarán automáticamente</div>
<div class='adminTitleLine backgroundColor4'></div>
<input type='hidden' id='userId' value='<?php echo($id); ?>'/>
<div class='adminData backgroundColor5'>
    <div class='adminDataSearchRow'>
        <div class='adminDataSearchRowTitle'><?php echo(Users::getModelName('singular'));?>:</div>
        <select id='selectedUserId' class='adminInput300'>
            <option value='0'>Seleccione un <?php echo(Users::getModelName('singular'));?></option>
            <?php 
                foreach($users as $user){
            ?>
                <option value='<?php echo $user->id;?>'><?php echo $user->email;?></option>
            <?php
                }
            ?>
        </select>
        <img id='deleteUserTrash' class='deleteModelTrash' src='/files/layouts/trash.png' alt='moonideas remove icon'>
        <div id='deleteUser' class='deleteModelButton'>eliminar</div>
        <input type='hidden' id='confirmationText' value='¿Está seguro que quiere eliminar el <?php echo(Users::getModelName('singular'));?>?'/>
    </div>
</div>
<div class='adminDataRow'>
    <div class='adminEditSeparation'></div>
</div>
<?php echo $this->renderPartial('form',array('userCategories'=>$userCategories, 'ranches'=>$ranches));?>

<div class='adminDataRow'>
    <div id='addUser' class='adminSaveButton color1 backgroundColor1'>
        Guardar
    </div>
</div>