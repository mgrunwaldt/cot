<script type='text/javascript' src='/js/fileManager.js'></script>
<link href='/css/fileManager.css' rel='stylesheet' type='text/css'/>
<script type='text/javascript' src='/js/projects/admin.js'></script>

<div class='adminTitle'>Editar <?php echo(Projects::getModelName('singular'));?></div>
<div class='adminSubtitle'>Elija el <?php echo(Projects::getModelName('plural'));?> a editar/eliminar, los datos se cargarán automáticamente</div>
<div class='adminTitleLine backgroundColor4'></div>
<input type='hidden' id='projectId' value='<?php echo($id); ?>'/>

    <div class='adminDataSearchRow'>
        <div class='adminDataSearchRowTitle'><?php echo(Categories::getModelName('singular'));?>:</div>
        <select id='selectedCategoryId' class='adminInput300'>
            <option value='0'>Seleccione un <?php echo(Categories::getModelName('singular'));?></option>
            <?php 
                foreach($categories as $category){
            ?>
                <option value='<?php echo $category->id;?>'><?php echo $category->name;?></option>
            <?php
                }
            ?>
        </select>
    </div><div class='adminData backgroundColor5'>
    <div class='adminDataSearchRow'>
        <div class='adminDataSearchRowTitle'><?php echo(Projects::getModelName('singular'));?>:</div>
        <select id='selectedProjectId' class='adminInput300'>
        </select>
        <div id='deleteProject' class='adminDeleteButton'>eliminar</div>
        <input type='hidden' id='confirmationText' value='¿Está seguro que quiere eliminar el <?php echo(Projects::getModelName('singular'));?>?'/>
    </div>
</div>
<div class='adminDataRow'>
    <div class='adminEditSeparation'></div>
</div>
<?php echo $this->renderPartial('form',array('categories'=>$categories, 'projects'=>$projects));?>

<div class='adminDataRow'>
    <div id='addProject' class='adminSaveButton color1 backgroundColor1'>
        Guardar
    </div>
</div>