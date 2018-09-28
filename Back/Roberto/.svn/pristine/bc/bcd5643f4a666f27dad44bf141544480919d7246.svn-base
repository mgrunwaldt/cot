
<script type='text/javascript' src='/js/categories/admin.js'></script>

<div class='adminTitle'>Editar <?php echo(Categories::getModelName('singular'));?></div>
<div class='adminSubtitle'>Elija el <?php echo(Categories::getModelName('plural'));?> a editar/eliminar, los datos se cargarán automáticamente</div>
<div class='adminTitleLine backgroundColor4'></div>
<input type='hidden' id='categoryId' value='<?php echo($id); ?>'/>
<div class='adminData backgroundColor5'>
    <div class='adminDataSearchRow'>
        <div class='adminDataSearchRowTitle'>Category:</div>
        <select id='selectedCategoryId' class='adminInput300'>
            <option value='0'>Seleccione un Category</option>
            <?php 
                foreach($categories as $category){
            ?>
                <option value='<?php echo $category->id;?>'><?php echo $category->name;?></option>
            <?php
                }
            ?>
        </select>
        <img id='deleteCategoryTrash' class='deleteModelTrash' src='/files/layouts/trash.png' alt='moonideas remove icon'>
        <div id='deleteCategory' class='deleteModelButton'>eliminar</div>
        <input type='hidden' id='confirmationText' value='¿Está seguro que quiere eliminar el <?php echo(Categories::getModelName('singular'));?>?'/>
    </div>
</div>
<div class='adminDataRow'>
    <div class='adminEditSeparation'></div>
</div>
<?php echo $this->renderPartial('form',array());?>

<div class='adminDataRow'>
    <div id='addCategory' class='adminSaveButton color1 backgroundColor1'>
        Guardar
    </div>
</div>