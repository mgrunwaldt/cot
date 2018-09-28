<script type='text/javascript' src='/js/fileManager.js'></script>
<link href='/css/fileManager.css' rel='stylesheet' type='text/css'/>
<script type='text/javascript' src='/js/projects/admin.js'></script>

<div class='adminTitle'>Agregar <?php echo(Projects::getModelName('singular'));?></div>
<div class='adminSubtitle'>Completá los datos para agregar un nuevo <?php echo(Projects::getModelName('plural'));?></div>
<div class='adminTitleLine backgroundColor4'></div>
<?php echo $this->renderPartial('form',array('categories'=>$categories, ));?>
    
<div class='adminDataRow'>
    <div id='addProject' class='adminSaveButton color1 backgroundColor1'>
        Agregar
    </div>
</div>