<div class='adminData backgroundColor5'>
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'><?php echo(Highlights::getAttributeName('name'));?>:</div>
        <input type='text' id='name' class='adminInput300'/>
    </div>
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'><?php echo(Highlights::getAttributeName('highlight_file_id'));?>:</div>
    </div>
        <div id='highlightFile' class='adminFiles'>
    </div>
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'><?php echo(Highlights::getAttributeName('title'));?>:</div>
        <input type='text' id='title' class='adminInput300'/>
    </div>
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'><?php echo(Highlights::getAttributeName('font_size'));?>:</div>
        <input type='text' id='font_size' class='adminInput300'/>
    </div>
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'><?php echo(Highlights::getAttributeName('letter_spacing'));?>:</div>
        <input type='text' id='letter_spacing' class='adminInput300'/>
    </div>
    <div class='adminDataRow'>
        <div class='adminDataRowTitle'><?php echo(Highlights::getAttributeName('link'));?>:</div>
        <input type='text' id='link' class='adminInput300'/>
    </div>
    <div class='adminDataRow'>
        <div class='adminDataRowTitle floatLeft'><?php echo(Highlights::getAttributeName('mobile'));?>:</div>
        <div id='mobile' class='adminCheckbox'></div>
    </div>
</div>