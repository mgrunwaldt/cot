<?php 
    $instanceId = HelperFunctions::purify($instanceId);
?>

<div id="FM<?php echo $instanceId;?>FileManager" class="FMDiv">
    <div id="FM<?php echo $instanceId;?>FileDiv" class="FMFileDiv">
        <div id="FM<?php echo $instanceId;?>FileContainer" class="FMFileContainer"></div>
        <div id="FM<?php echo $instanceId;?>DeleteFile" class="FMDeleteFile">eliminar archivo</div>
    </div>
    <div id="FM<?php echo $instanceId;?>FileData">
        <input type="hidden" id="FM<?php echo $instanceId;?>FileLocalId" value=""/>
        <input type="hidden" id="FM<?php echo $instanceId;?>FileId" value=""/>
        <div class="FMDataRow">
            <div class="FMDataRowTitle">Nombre:</div>
            <input type="text" id="FM<?php echo $instanceId;?>FileName" class="FMTextInputDisabled" disabled="disabled"/>
        </div>
        <div class="FMDataRow">
            <div class="FMDataRowTitle">Nombre Original:</div>
            <input type="text" id="FM<?php echo $instanceId;?>FileOriginalName" class="FMTextInputDisabled" disabled="disabled"/>
        </div>
        <div class="FMDataRow">
            <div class="FMDataRowTitle">URL:</div>
            <input type="text" id="FM<?php echo $instanceId;?>FileURL" class="FMTextInputDisabled" disabled="disabled"/>
        </div>
        <div class="FMDataRow">
            <div class="FMDataRowTitle">Tipo:</div>
            <select id="FM<?php echo $instanceId;?>FileType" class="FMComboInputDisabled">
                <?php 
                    $fileTypeIds = FileTypes::getAllIds();
                    foreach($fileTypeIds as $fileTypeId){
                ?>
                        <option value="<?php echo $fileTypeId;?>"><?php echo FileTypes::getName($fileTypeId);?></option>
                <?php
                    }
                ?>
            </select>
        </div>
        <div class="FMDataRow">
            <div class="FMDataRowTitle">Tamaño:</div>
            <input type="text" id="FM<?php echo $instanceId;?>FileSize" class="FMTextInputDisabled" disabled="disabled"/>
        </div>
        <div class="FMDataRow">
            <div class="FMDataRowTitle">Ancho:</div>
            <input type="text" id="FM<?php echo $instanceId;?>FileWidth" class="FMTextInputDisabled" disabled="disabled"/>
        </div>
        <div class="FMDataRow">
            <div class="FMDataRowTitle">Alto:</div>
            <input type="text" id="FM<?php echo $instanceId;?>FileHeight" class="FMTextInputDisabled" disabled="disabled"/>
        </div>
        <div class="FMDataRow">
            <div class="FMDataRowTitle">Posición:</div>
            <select id="FM<?php echo $instanceId;?>FilePosition" class="FMComboInputDisabled"></select>
        </div>
    </div>
    <div class="FMLastRow">
        <div id="FM<?php echo $instanceId;?>AddFile" class="FMAddFile">
            agregar archivo/
            <iframe id="FM<?php echo $instanceId;?>FileUploadFrame" class="FMFileUploadFrame" src=""></iframe>
        </div>
        <div id="FM<?php echo $instanceId;?>AddURLFile" class="FMAddURLFile">agregar URL</div>
        <div id="FM<?php echo $instanceId;?>NextFile" class="FMNextFile">próximo archivo</div>
        <div id="FM<?php echo $instanceId;?>PreviousFile" class="FMPreviousFile">anterior archivo</div>
    </div>
    <div id="FM<?php echo $instanceId;?>Loader" class="FMLoader">
        <div class="FMLoaderBkg"></div>
        <div class="FMLoaderImgDiv"><img src="https://s3-sa-east-1.amazonaws.com/moonmanager/loading.gif" class="FMLoaderImg"/></div>
    </div>
    
    <div id="FM<?php echo $instanceId;?>AddURLCover" class="FMAddURLCover">
        <div id="FM<?php echo $instanceId;?>AddURLCoverBkg" class="FMAddURLCoverBkg"></div>
        <div class="FMAddURLDiv">
            <div class="FMAddURLTitle">Agregar URL</div>
            <div class="FMAddURLRow">
                <div class="FMAddURLRowTitle">URL:</div>
                <input type="text" id="FM<?php echo $instanceId;?>AddURLURL" class="FMAddURLRowInput"/>
            </div>
            <div class="FMAddURLRow">
                <div class="FMAddURLRowTitle">Tipo:</div>
                <select type="text" id="FM<?php echo $instanceId;?>AddURLType" class="FMAddURLRowComboInput">
                    <?php 
                        $URLFileTypeIds = FileTypes::getAllURLIds();
                        foreach($URLFileTypeIds as $URLFileTypeId){
                    ?>
                            <option value="<?php echo $URLFileTypeId;?>"><?php echo FileTypes::getName($URLFileTypeId);?></option>
                    <?php
                        }
                    ?>    
                </select>
            </div>
            <div class="FMAddURLRow">
                <div id="FM<?php echo $instanceId;?>AddURLAddURL" class="FMAddURLAddURL">agregar URL</div>
            </div>
        </div>
    </div>
</div>