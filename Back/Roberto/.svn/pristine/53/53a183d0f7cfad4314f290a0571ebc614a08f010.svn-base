<div class='adminData backgroundColor5'>
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'><?php echo(Projects::getAttributeName('name'));?>:</div>
        <input type='text' id='name' class='adminInput300'/>
    </div>
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'><?php echo(Projects::getAttributeName('client'));?>:</div>
        <input type='text' id='client' class='adminInput300'/>
    </div>
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'><?php echo(Projects::getAttributeName('description'));?>:</div>
            <textarea type='text' id='description' class='adminTextArea'></textarea>
    </div>
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'><?php echo(Projects::getAttributeName('preview_file_id'));?>:</div>
    </div>
        <div id='previewFile' class='adminFiles'>
    </div>
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'><?php echo(Projects::getAttributeName('category_id'));?>:</div>
        <select id='category_id' class='adminInput300'>
            <?php foreach($categories as $category){ ?>
                <option value='<?php echo $category->id;?>'><?php echo $category->name;?></option>
            <?php } ?>
        </select>
    </div>
    <div class='adminDataRow'>
        <div class='adminDataRowTitle floatLeft'><?php echo(Projects::getAttributeName('active'));?>:</div>
        <div id='active' class='adminCheckbox'></div>
    </div>
            
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'>Archivos:</div>
    </div>
    <div id='projectFiles' class='adminFiles'>
    </div>
</div>