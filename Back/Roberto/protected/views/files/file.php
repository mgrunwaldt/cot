<div class="FileDiv">
    <div id="FileMainDiv" class="FileMainDiv"></div>
    <div class="FileList">
        <img class="FileListArrowUp" src="/images/files/arrowUp.png"/>
        
        <div class="FileListItemsContainer">
            <div id="FileListItems" class="FileListItems"></div>
        </div>
        <img class="FileListArrowDown" src="/images/files/arrowDown.png"/>
    </div>
    <div class="FileOptionsDiv">
        <img class="FileAddFileImg" src="/images/files/addIcon.png"/>
        <img class="FileRemoveFileImg" src="/images/files/removeIcon.png"/>
    </div>
    <div class="FileAddFileMenuDiv">
        <div class="FileAddFileVideoDiv">
            <img class="FileAddFileVideoImg" src="/images/files/addVideo.png"/>
        </div>
        <div class="FileAddFileFileDiv">
            <img class="FileAddFileFileImg" src="/images/files/addFile.png"/>
        </div>
        <div class="FileAddFileImageDiv">
            <img class="FileAddFileImageImg" src="/images/files/addImage.png"/>
        </div>
        <iframe width="100%" height="100%" class="FileAddFileIframe" src="/Files/uploadFile?ref=<?php echo HelperFunctions::purify($ref);?>&instanceId=<?php echo HelperFunctions::purify($instanceId);?>"></iframe>
    </div>
    <div class="FileAddVideoMenuDiv">
        <div class="FileAddVideoMenuTxt">ID de YouTube</div>
        <input type="text" class="FileAddVideoIdInput" val=""/>
        <img class="FileAddVideoIconImg" src="/images/files/addIcon.png"/>
        <img class="FileRemoveVideoIconImg" src="/images/files/removeIcon.png"/>
    </div>
    <div class="FileLoaderDiv">
        <div class="FileBlackBkg80"></div>
        <img class="FileLoaderImg" src="/images/files/loading.gif"/>
    </div>
</div>