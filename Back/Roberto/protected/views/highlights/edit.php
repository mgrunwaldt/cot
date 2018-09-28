
<script type='text/javascript' src='/js/highlights/admin.js'></script>

<div class='adminTitle'>Editar <?php echo(Highlights::getModelName('singular'));?></div>
<div class='adminSubtitle'>Elija el <?php echo(Highlights::getModelName('plural'));?> a editar/eliminar, los datos se cargarán automáticamente</div>
<div class='adminTitleLine backgroundColor4'></div>
<input type='hidden' id='highlightId' value='<?php echo($id); ?>'/>
<div class='adminData backgroundColor5'>
    <div class='adminDataSearchRow'>
        <div class='adminDataSearchRowTitle'>Highlight:</div>
        <select id='selectedHighlightId' class='adminInput300'>
            <option value='0'>Seleccione un Highlight</option>
            <?php 
                foreach($highlights as $highlight){
            ?>
                <option value='<?php echo $highlight->id;?>'><?php echo $highlight->name;?></option>
            <?php
                }
            ?>
        </select>
        <img id='deleteHighlightTrash' class='deleteModelTrash' src='/files/layouts/trash.png' alt='moonideas remove icon'>
        <div id='deleteHighlight' class='deleteModelButton'>eliminar</div>
        <input type='hidden' id='confirmationText' value='¿Está seguro que quiere eliminar el <?php echo(Highlights::getModelName('singular'));?>?'/>
    </div>
</div>
<div class='adminDataRow'>
    <div class='adminEditSeparation'></div>
</div>
<?php echo $this->renderPartial('form',array());?>

<div class='adminDataRow'>
    <div id='addHighlight' class='adminSaveButton color1 backgroundColor1'>
        Guardar
    </div>
</div>