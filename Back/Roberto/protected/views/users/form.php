<div class='adminData backgroundColor5'>
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'><?php echo(Users::getAttributeName('name'));?>:</div>
        <input type='text' id='name' class='adminInput300'/>
    </div>
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'><?php echo(Users::getAttributeName('email'));?>:</div>
        <input type='text' id='email' class='adminInput300'/>
    </div>
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'><?php echo(Users::getAttributeName('phone'));?>:</div>
        <input type='text' id='phone' class='adminInput300'/>
    </div>
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'><?php echo(Users::getAttributeName('category_id'));?>:</div>
        <select id='category_id' class='adminInput300'>
            <?php 
                foreach($userCategories as $category){
                    echo("<option value='".$category->id."'>".$category->name."</option>");
                }
            ?>
        </select>
    </div>
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'><?php echo(Users::getAttributeName('ranch_id'));?>:</div>
        <select id='ranch_id' class='adminInput300'>
            <option value="0">Ninguna</option>
            <?php 
                foreach($ranches as $ranch){
                    echo("<option value='".$ranch->id."'>".$ranch->name."</option>");
                }
            ?>
        </select>
    </div>
    <div class='adminMultiData'>
        <table id='userNotes' class='adminMultiDataTable'>
            <tr class='adminMultiDataTitle'>
                <td width='100px'></td>
                <td><?php echo(UserNotes::getModelName('plural'));?></td>
                <td width='100px'></td>
            </tr>
        </table>
        <div id='addUserNot' class='adminMultiDataAddButton backgroundColor1 color1'>agregar</div>
    </div>
</div>