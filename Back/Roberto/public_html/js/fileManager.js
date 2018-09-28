var FileManager = {};
FileManager.instances = new Array();

FileManager.newInstance = function(ref, divId, allow_multi, files){
    var instanceAux = {};
    instanceAux.divId = divId;
    instanceAux.div = $('#'+divId);
    
    instanceAux.ref = ref;
    instanceAux.allow_multi = allow_multi;
    
    instanceAux.scrollingDown = false;
    instanceAux.scrollingUp = false;
    
    instanceAux.files = files;
    instanceAux.removedFiles = new Array();

    instanceAux.fileLoading = FileManager.fileLoading;
    instanceAux.fileLoaded = FileManager.fileLoaded;
    instanceAux.fileLoadingError = FileManager.fileLoadingError;

    instanceAux.start = FileManager.start;
    instanceAux.setHTML = FileManager.setHTML;
    instanceAux.bindFunctions = FileManager.bindFunctions;
    instanceAux.assignLocalIds = FileManager.assignLocalIds;
    instanceAux.putFirstFile = FileManager.putFirstFile;
    instanceAux.getFile = FileManager.getFile;
    instanceAux.getFiles = FileManager.getFiles;
    instanceAux.addFile = FileManager.addFile;
    instanceAux.addURLFile = FileManager.addURLFile;
    instanceAux.showAddURL = FileManager.showAddURL;
    instanceAux.hideAddURL = FileManager.hideAddURL;
    instanceAux.showFile = FileManager.showFile;
    instanceAux.removeFile = FileManager.removeFile;
    instanceAux.cleanFile = FileManager.cleanFile;
    instanceAux.changeFileName = FileManager.changeFileName;
    instanceAux.changeFileType = FileManager.changeFileType;
    instanceAux.changePosition = FileManager.changePosition;
    instanceAux.nextFile = FileManager.nextFile;
    instanceAux.previousFile = FileManager.previousFile;
    instanceAux.getFileIds = FileManager.getFileIds;
    instanceAux.getFilePos = FileManager.getFilePos;
    instanceAux.updateFiles = FileManager.updateFiles;
    instanceAux.showLoader = FileManager.showLoader;
    instanceAux.hideLoader = FileManager.hideLoader;
    instanceAux.refresh = FileManager.refresh;
    instanceAux.removeMultiData = FileManager.removeMultiData;
    
    instanceAux.id = FileManager.instances.length;
    
    FileManager.instances[FileManager.instances.length] = instanceAux;

    return instanceAux;
};

FileManager.start = function(){
    this.setHTML();
};

FileManager.assignLocalIds = function(){
    for(var i=0; i<this.files.length; i++)
        this.files[i].localId = Tools.randomString(20);    
};

FileManager.setHTML = function(){
    var instance = this;
   
    $.ajax({
        type: "POST",
        url: "/Files/getFileManagerHTML",
        data:{'instanceId':(this.id)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                instance.div.append(response.html);
                $('#FM'+instance.id+'FileUploadFrame').attr('src','/Files/viewUploadFile?ref='+instance.ref+'&instanceId='+instance.id);
                instance.bindFunctions();
                instance.putFirstFile();
                if(!instance.allow_multi)
                    instance.removeMultiData();
            }
            else{
                alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
            }
        },
        error: function(){
            alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
        }
    });
};

FileManager.putFirstFile = function(){
    var files = this.files;
    if(files.length>0)
        this.showFile(files[0]);
};

FileManager.fileUploading = function(instanceId, ref){
    var instance = this.getInstance(instanceId);
    instance.showLoader();
};

FileManager.fileUploaded = function(instanceId, ref, id, name, originalName, url, fileTypeId, size, width, height){
    var instance = this.getInstance(instanceId);
    instance.hideLoader();
    var auxFile = {};
    auxFile.ref = ref;
    auxFile.id = id;
    auxFile.name = name;
    auxFile.original_name = originalName;
    auxFile.url = url;
    auxFile.file_type_id = fileTypeId;
    auxFile.size = size;
    auxFile.width = width;
    auxFile.height = height;
    auxFile.deleted = 0;
    
    instance.addFile(auxFile, true);
    if(typeof(FileManager.posFileUploaded)!='undefined'){
        FileManager.posFileUploaded();
    }
};

FileManager.fileUploadingError = function(instanceId, ref, error){
    var instance = this.getInstance(instanceId);
    instance.hideLoader();
    alert('Loading error: ref:'+ref+' error:'+error);
};


FileManager.bindFunctions = function(){
    var instance = this;
    
    instance.loaderDiv = instance.div.find('#FM'+instance.id+'Loader');
    //instance.div.find('#FM'+instance.id+'AddURLFile').on({
    //        'click':function(){
    //            instance.div.find('#FM'+instance.id+'AddURLDiv').show();
    //        }
    //});
    
    instance.div.find('#FM'+instance.id+'DeleteFile').on({
            'click':function(){
                var localId = instance.div.find('#FM'+instance.id+'FileLocalId').val();
                var file = instance.getFile(localId);
                if(file!=='noFile')
                    instance.removeFile(file);
            }
    });
    
    instance.div.find('#FM'+instance.id+'FilePosition').on({
            'change':function(){
                instance.changePosition();
            }
    });
    
    instance.div.find('#FM'+instance.id+'AddURLFile').on({
            'click':function(){
                instance.showAddURL();
            }
    });
    
    instance.div.find('#FM'+instance.id+'AddURLCoverBkg').on({
            'click':function(){
                instance.hideAddURL();
            }
    });
    
    instance.div.find('#FM'+instance.id+'AddURLAddURL').on({
            'click':function(){
                instance.addURLFile();
            }
    });
    
    instance.div.find('#FM'+instance.id+'FileName').on({
            'keyup':function(){
                instance.changeFileName();
            }
    });
    
    instance.div.find('#FM'+instance.id+'FileType').on({
            'change':function(){
                instance.changeFileType();
            }
    });
    
    if(this.allow_multi){
        instance.div.find('#FM'+instance.id+'NextFile').on({
            'click':function(){
                instance.nextFile();
            }
        });
        instance.div.find('#FM'+instance.id+'PreviousFile').on({
            'click':function(){
                instance.previousFile();
            }
        });
    }
    
};

FileManager.addFile = function(file, show){
    file.localId = Tools.randomString(20);  
    if(this.allow_multi)
        this.files[this.files.length] = file;
    else
        this.files[0] = file;
    
    if(show)
        this.showFile(file);
};

FileManager.refresh = function(){
    var files = this.files;
    this.assignLocalIds();
    
    if(this.div!=undefined){
        var fileContainer = this.div.find('#FM'+this.id+'FileContainer');
        fileContainer.html('');
        this.div.find('#FM'+this.id+'FileId').val('');
        this.div.find('#FM'+this.id+'FileLocalId').val('');
        this.div.find('#FM'+this.id+'FileName').val('');
        this.div.find('#FM'+this.id+'FileName').removeClass('FMTextInput').addClass('FMTextInputDisabled');
        this.div.find('#FM'+this.id+'FileName').prop('disabled', true);
        this.div.find('#FM'+this.id+'FileOriginalName').val('');
        this.div.find('#FM'+this.id+'FileURL').val('');
        this.div.find('#FM'+this.id+'FileSize').val('');
        this.div.find('#FM'+this.id+'FileWidth').val('');
        this.div.find('#FM'+this.id+'FileHeight').val('');
        this.putFirstFile();
    }
};


FileManager.setCorrectSize = function(div, img, loader){
    var divWidth = parseInt(div.width());
    var divHeight = parseInt(div.height());
    var imgWidth = parseInt(img.width());
    var imgHeight = parseInt(img.height());

    if(divWidth/imgWidth > divHeight/imgHeight){
        img.css('height',divHeight);
        img.css('width',imgWidth*divHeight/imgHeight);
        img.css('top',0);
        img.css('left',(divWidth-(imgWidth*divHeight/imgHeight))/2);
    }
    else{
        img.css('width',divWidth);
        img.css('height',imgHeight*divWidth/imgWidth);
        img.css('left',0);
        img.css('top',(divHeight-(imgHeight*divWidth/imgWidth))/2);
    }
    
    img.stop().animate({'opacity':1},500);
    loader.stop().animate({'opacity':0},500,
        function(){
            $(this).remove();
        }
    );
};

FileManager.getInstance = function(id){
    return this.instances[id];
};

FileManager.showLoader = function(){
    this.loaderDiv.css('opacity',0);
    this.loaderDiv.css('display','block');
    this.loaderDiv.stop().animate({'opacity':1},1000);
};

FileManager.hideLoader = function(){
    this.loaderDiv.stop().animate({'opacity':0},1000,
        function(){
            $(this).css('display','none');
        }
    );
};


FileManager.removeFile = function(file){
    var auxFiles = new Array();
    var pos = 0;
    for(var i=0; i<this.files.length; i++){
        if(this.files[i].localId!==file.localId){
            auxFiles[auxFiles.length] = this.files[i];
            pos = i;
        }
        else{
            this.files[i].deleted=1;
            this.removedFiles[this.removedFiles.length] = this.files[i];
        }
    }
    
    this.files = auxFiles;
    
    if(this.files.length===0)
        this.cleanFile();
    else{
        pos--;
        if(pos===-1)
            pos = this.files.length-1;
        this.showFile(this.files[pos]);
    }
};

FileManager.getFile = function(localId){
    for(var i=0; i<this.files.length; i++)
        if(this.files[i].localId===localId)
            return this.files[i];
    return 'noFile';
};

FileManager.getFilePos = function(localId){
    for(var i=0; i<this.files.length; i++)
        if(this.files[i].localId===localId)
            return i;
    return 'noFile';
};

FileManager.nextFile = function(){
    var localId = this.div.find('#FM'+this.id+'FileLocalId').val();
    var filePos = this.getFilePos(localId);
    var nextFilePos = filePos+1;
    if(nextFilePos===this.files.length)
        nextFilePos = 0;
    this.showFile(this.files[nextFilePos]);
};

FileManager.previousFile = function(){
    var localId = this.div.find('#FM'+this.id+'FileLocalId').val();
    var filePos = this.getFilePos(localId);
    var previousFilePos = filePos-1;
    if(previousFilePos===-1)
        previousFilePos = this.files.length-1;
    this.showFile(this.files[previousFilePos]);
};

FileManager.showFile = function(file){
    this.div.find('#FM'+this.id+'FileId').val(file.id);
    this.div.find('#FM'+this.id+'FileLocalId').val(file.localId);
    this.div.find('#FM'+this.id+'FileName').val(file.name);
    this.div.find('#FM'+this.id+'FileName').removeClass('FMTextInputDisabled').addClass('FMTextInput');
    this.div.find('#FM'+this.id+'FileName').prop('disabled', false);
    this.div.find('#FM'+this.id+'FileOriginalName').val(file.original_name);
    this.div.find('#FM'+this.id+'FileURL').val(file.url);
    this.div.find('#FM'+this.id+'FileSize').val(file.size);
    this.div.find('#FM'+this.id+'FileWidth').val(file.width);
    this.div.find('#FM'+this.id+'FileHeight').val(file.height);
    
    var currentPos = this.getFilePos(file.localId)+1;
    var posOptionsHTML = '';
    for(var i=0; i<this.files.length; i++)
        posOptionsHTML+='<option value="'+(i+1)+'">'+(i+1)+'</option>';
    
    this.div.find('#FM'+this.id+'FilePosition').html(posOptionsHTML);
    this.div.find('#FM'+this.id+'FilePosition').val(currentPos);
    this.div.find('#FM'+this.id+'FilePosition').removeClass('FMComboInputDisabled').addClass('FMComboInput');
    this.div.find('#FM'+this.id+'FilePosition').prop('disabled', false);
    this.div.find('#FM'+this.id+'FileType').val(file.file_type_id);
    this.div.find('#FM'+this.id+'FileType').removeClass('FMComboInputDisabled').addClass('FMComboInput');
    this.div.find('#FM'+this.id+'FileType').prop('disabled', false);
    
    
    var fileContainer = this.div.find('#FM'+this.id+'FileContainer');
    switch(parseInt(file.file_type_id)){
        case 1:
            var width = file.width;
            var height = file.height;

            if(width>800 || height>400){
                if(width/800 > height/400){
                    height = height * 800 / width;
                    width = 800;
                }
                else{
                    width = width * 400 / height;
                    height = 400;
                }
            }

            fileContainer.html('<img src="'+file.url+'" width="'+width+'px" height="'+height+'px"/>');
            fileContainer.css('left',((800-width)/2)+'px');
            fileContainer.css('top',((400-height)/2)+'px');
        break;
        
        case 4:
            fileContainer.html('<iframe class="FMYoutubeVideoFrame" src="http://www.youtube.com/embed/'+file.url+'?autoplay=1&v_load_policy=3&showinfo=0&rel=0&modestbranding=1&controls=0" frameborder="0" allowfullscreen></iframe>');
            fileContainer.css('left','50px');
            fileContainer.css('top','25px');
        break;
    }
};

FileManager.cleanFile = function(){
    this.div.find('#FM'+this.id+'FileId').val('');
    this.div.find('#FM'+this.id+'FileLocalId').val('');
    this.div.find('#FM'+this.id+'FileName').val('');
    this.div.find('#FM'+this.id+'FileName').removeClass('FMTextInput').addClass('FMTextInputDisabled');
    this.div.find('#FM'+this.id+'FileName').prop('disabled', true);
    this.div.find('#FM'+this.id+'FileOriginalName').val('');
    this.div.find('#FM'+this.id+'FileURL').val('');
    this.div.find('#FM'+this.id+'FileSize').val('');
    this.div.find('#FM'+this.id+'FileWidth').val('');
    this.div.find('#FM'+this.id+'FileHeight').val('');
    this.div.find('#FM'+this.id+'FilePosition').html('');
    this.div.find('#FM'+this.id+'FilePosition').val('');
    this.div.find('#FM'+this.id+'FilePosition').removeClass('FMComboInput').addClass('FMComboInputDisabled');
    this.div.find('#FM'+this.id+'FilePosition').prop('disabled', true);
    this.div.find('#FM'+this.id+'FileType').val('');
    this.div.find('#FM'+this.id+'FileType').removeClass('FMComboInput').addClass('FMComboInputDisabled');
    this.div.find('#FM'+this.id+'FileType').prop('disabled', true);
    this.div.find('#FM'+this.id+'FileContainer').html('');
};

FileManager.addURLFile = function(){
    var instance = this;
    var fileURL = $('#FM'+instance.id+'AddURLURL').val();
    var fileType = $('#FM'+instance.id+'AddURLType').val();
    
    $.ajax({
        type: "POST",
        url: "/Files/addURLFile",
        data:{'fileURL':(fileURL),'fileType':(fileType),'ref':(instance.ref)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                instance.hideAddURL();
                instance.addFile(response.file,true);
            }
            else{
                alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
            }
        },
        error: function(){
            alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
        }
    });
};

FileManager.showAddURL = function(){
    $('#FM'+this.id+'AddURLCover').show();
};

FileManager.hideAddURL = function(){
    $('#FM'+this.id+'AddURLURL').val('');
    $('#FM'+this.id+'AddURLCover').hide();
};

FileManager.changePosition = function(){
    var localId = this.div.find('#FM'+this.id+'FileLocalId').val();
    var file = this.getFile(localId);
    var newFilePos = parseInt(this.div.find('#FM'+this.id+'FilePosition').val())-1;
    var auxFiles = new Array();
    
    if(newFilePos===0)
        auxFiles[auxFiles.length] = file;
    for(var i=0; i<this.files.length; i++){
        if(i!==0 && i!==(this.files.length-1) && i===newFilePos)
            auxFiles[auxFiles.length] = file;
        if(this.files[i].localId!==localId)
            auxFiles[auxFiles.length] = this.files[i];
    }
    if(newFilePos===(this.files.length-1))
        auxFiles[auxFiles.length] = file;
    
    this.files = auxFiles;
};

FileManager.updateFiles = function(files){
    this.files = files;
    this.refresh();
};

FileManager.changeFileName = function(){
    var localId = this.div.find('#FM'+this.id+'FileLocalId').val();
    var newName = this.div.find('#FM'+this.id+'FileName').val();
    
    for(var i=0; i<this.files.length; i++){
        if(this.files[i].localId===localId){
            this.files[i].name = newName;
            return true;
        }
    }
};

FileManager.changeFileType = function(){
    var localId = this.div.find('#FM'+this.id+'FileLocalId').val();
    var newFileTypeId = this.div.find('#FM'+this.id+'FileType').val();
    
    for(var i=0; i<this.files.length; i++){
        if(this.files[i].localId===localId){
            this.files[i].file_type_id = newFileTypeId;
            return true;
        }
    }
};

FileManager.getFiles = function(){
    if(this.allow_multi)
        return this.files.concat(this.removedFiles);
    else
        if(this.files.length>0)
            return this.files[0];
        else
            return false;
};

FileManager.removeMultiData = function(){
    this.div.find('#FM'+this.id+'FilePosition').hide();
    this.div.find('#FM'+this.id+'NextFile').hide();
    this.div.find('#FM'+this.id+'PreviousFile').hide();
};
