<script type='text/javascript' src='/js/categories/admin.js'></script>

<div class='adminTitle'><?php echo(Categories::getModelName('plural'));?></div>
<div class='adminSubtitle'>Creá, editá, eliminá y posicioná tus diferentes <?php echo(Categories::getModelName('plural'));?></div>
<div class='adminTitleLine backgroundColor4'></div>
<div class='adminData'>
    <div class='adminMainOptions color1'>
        <a class='adminMainOption backgroundColor1' href='/index.php/Categories/viewAdd'>Nuevo</a>
        <a class='adminMainOption backgroundColor1' href='/index.php/Categories/viewEdit'>Editar/Eliminar</a>
    </div>
</div>

<?php if(count($categories)>0){ ?>
    <div id='adminPositionsTitle'>Posiciones</div>
    <div id='adminPositions'>
        <?php foreach($categories as $category){ ?>
            <div id='<?php echo($category->id);?>' class='adminPosition'><?php echo($category->name);?></div>
        <?php } ?>
    </div>
    <div class='adminDataRow'>
        <div id='savePositions' class='adminSaveButton'>
            Guardar Posiciones
        </div>
    </div>
<?php } ?>
    <div class='adminDataSpace100'></div>
        