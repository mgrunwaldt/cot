<script type='text/javascript' src='/js/fileManager.js'></script>
<link href='/css/fileManager.css' rel='stylesheet' type='text/css'/>
<div class='adminData backgroundColor5'>
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'><?php echo(Categories::getAttributeName('name'));?>:</div>
        <input type='text' id='name' class='adminInput300'/>
    </div>
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'><?php echo(Categories::getAttributeName('icon_file_id'));?>:</div>
    </div>
        <div id='iconFile' class='adminFiles'>
    </div>
    <div class='adminDataRow'>
        <div class='adminDataRowTitle floatLeft'><?php echo(Categories::getAttributeName('active'));?>:</div>
        <div id='active' class='adminCheckbox'></div>
    </div>
</div>