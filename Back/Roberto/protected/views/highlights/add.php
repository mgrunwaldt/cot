
<script type='text/javascript' src='/js/highlights/admin.js'></script>

<div class='adminTitle'>Agregar <?php echo(Highlights::getModelName('singular'));?></div>
<div class='adminSubtitle'>Completá los datos para agregar un nuevo <?php echo(Highlights::getModelName('plural'));?></div>
<div class='adminTitleLine backgroundColor4'></div>
<?php echo $this->renderPartial('form',array());?>
    
<div class='adminDataRow'>
    <div id='addHighlight' class='adminSaveButton color1 backgroundColor1'>
        Agregar
    </div>
</div>