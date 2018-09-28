<script type='text/javascript' src='/js/fileManager.js'></script>
<link href='/css/fileManager.css' rel='stylesheet' type='text/css'/>
<script type='text/javascript' src='/js/administrators/admin.js'></script>

<div class='adminTitle'>Agregar Administrator</div>
<div class='adminData'> 
    <?php echo $this->renderPartial('form',array('administratorRoles'=>$administratorRoles, ));?>
    
    <div class='adminDataRow'>
        <div id='addAdministrator' class='adminSaveButton'>
            Agregar
        </div>
    </div>
</div>