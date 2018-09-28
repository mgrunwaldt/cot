var MMGallery = {};
MMGallery.galleries = new Array();

$(window).on('resize', function(){
      MMGallery.start
});

MMGallery.newGallery=function(divId, files, zoom){
    var auxGallery = {};
    auxGallery.div = $('#'+divId);
    auxGallery.files = files;
    auxGallery.currentFile = 0;
    auxGallery.fileAutoMove = true;
    auxGallery.delayTime = 4000;
    auxGallery.filesBlocked = false;
    auxGallery.width = parseInt(auxGallery.div.css("width"));
    auxGallery.height = parseInt(auxGallery.div.find("#MMFiles").css("height"));
    auxGallery.zoom = zoom;
    
    auxGallery.bindFunctions = MMGallery.bindFunctions;
    auxGallery.start = MMGallery.start;
    auxGallery.preloadNextFile = MMGallery.preloadNextFile;
    auxGallery.setFilesNumbers = MMGallery.setFilesNumbers;
    auxGallery.nextFile = MMGallery.nextFile;
    auxGallery.previousFile = MMGallery.previousFile;
    auxGallery.fileNumberClick = MMGallery.fileNumberClick;
    auxGallery.setFile = MMGallery.setFile;
    auxGallery.setThumbnails = MMGallery.setThumbnails;
    auxGallery.getWidthHeightLeftTop = MMGallery.getWidthHeightLeftTop;
    auxGallery.views = MMGallery.views;
    auxGallery.clicks = MMGallery.clicks;
    auxGallery.reStart = MMGallery.reStart;
    auxGallery.chooseFile = MMGallery.chooseFile;
    auxGallery.restarted = false;
    auxGallery.resize = MMGallery.resize;
    
    auxGallery.magnifyied = false;
    auxGallery.startMagnifyingEffect = MMGallery.startMagnifyingEffect;
    auxGallery.afterMagnifyiedImageLoad = MMGallery.afterMagnifyiedImageLoad;
    
    MMGallery.galleries[MMGallery.galleries.length] = auxGallery;
    
    
    auxGallery.div.show();
    
    if($('#isMobile').length == 0)
        MMGallery.startMagnifyingEffect();
    
    return auxGallery;
};

//*********************************************************//

MMGallery.bindFunctions=function(){
    var instance = this;
    /*this.div.find('#MMGallery').off().on({
        'click':function(){
            instance.clicks();
        }
    },'.MMFilesItem');*/
    
//    this.div.find('#MMRightArrow').off().on({
//        'click':function(){
//            instance.fileAutoMove = false;
//            instance.nextFile();
//        }
//    });
//    
//    this.div.find('#MMLeftArrow').off().on({
//        'click':function(){
//            instance.fileAutoMove = false;
//            instance.previousFile();
//        }
//    });
    $('body').on('click','.MMGalleryImage',function(){
        instance.chooseFile($(this));
    });
};

MMGallery.start=function(){
    this.filesBlocked = false;
    this.currentFile = 0;
    this.preloadNextFile();
    this.setFilesNumbers();
    this.bindFunctions();
    this.setFile();
    this.setThumbnails();
};

MMGallery.reStart=function(){
    this.filesBlocked = false;
    this.restarted = true;
    this.currentFile = 0;
    this.preloadNextFile();
    this.setFilesNumbers();
    this.bindFunctions();
    this.setFile();
    this.setThumbnails();
};

$(window).resize(function() {
    /*for (var i = 0; i < MMGallery.galleries.length; i++) {
        MMGallery.galleries[i].resize();
    }*/
});



MMGallery.resize = function(){
    
    var windowWidth = parseInt($(window).width());
    var circlesWidth = parseInt($("#MMFilesNumbers").width());
    var height = parseInt($("#MMFiles").height());
    var left = (windowWidth - circlesWidth)/2;
    $("#MMFilesNumbers").css({"left":left, "top":height-25});
    /*var instance = this;
    
    var galleryWidth = parseInt($('#MMFiles').width());
    var galleryHeight = galleryWidth/1.5;
    $('#MMFiles').height(galleryHeight);
    
    var currentFile = instance.files[instance.currentFile];
    var originalWidth = currentFile.width;
    var originalHeight = currentFile.height;
    var finalValues = Tools.getMaxSize(originalWidth,originalHeight,galleryWidth,galleryHeight);
    
    var finalWidth = finalValues.finalWidth;
    var finalHeight = finalValues.finalHeight;
    var left = (galleryWidth/2 - finalWidth/2);
    var top = (galleryHeight/2 - finalHeight/2);
    
    $(".MMFilesItem").css({'top':top,'left':left,'width':finalWidth,'height':finalHeight});
    $(".MMFilesItemImage").css({'width':finalWidth,'height':finalHeight});*/
};


MMGallery.preloadNextFile=function(){
    var fileToLoad = this.currentFile + 1;
    if(fileToLoad===this.files.length)
        fileToLoad = 0;

    var fileToLoad = this.files[fileToLoad];

    if(parseInt(fileToLoad.file_type_id)===1)
        Tools.preloadImage(fileToLoad.url);
};

MMGallery.setFilesNumbers = function(){
    var filesDiv = $('#MMFilesNumbers');
    filesDiv.html('');
    var instance = this;
    for(var i=0; i<this.files.length; i++){
        if(i===0)
            filesDiv.append('<div id="MMFilesNumber'+(i+1)+'" class="MMFilesNumbersSelected"></div>');
        else
            filesDiv.append('<div id="MMFilesNumber'+(i+1)+'" class="MMFilesNumbersUnSelected"></div>');
        
        $('#MMFilesNumber'+(i+1)).on({
            'click':function(){
                instance.fileNumberClick($(this));
            }
        });
    }
};

MMGallery.nextFile=function(){
    if(!this.filesBlocked){
        var instance = this;
        if($('#magnifyiedProductOuter').length===0){
            if(this.files.length>1){
                if(this.restarted){
                    this.restarted = false;
                }
                else{
                    this.currentFile++;
                    if(this.currentFile===this.files.length)
                        this.currentFile = 0;
                    this.setFile();
                    if(this.fileAutoMove){
                        Tools.delay(this.delayTime,
                            function(){
                                instance.nextFile();
                            }
                        );
                    }
                }
            }
        }
        else{
            Tools.delay(this.delayTime,
                function(){
                    instance.nextFile();
                }
            );
        }
    }
};

MMGallery.previousFile=function(){
    if(!this.filesBlocked){
        if($('#magnifyiedProductOuter').length===0){
            if(this.files.length>1){
                this.currentFile--;
                if(this.currentFile===-1)
                    this.currentFile = this.files.length-1;
                this.setFile();
            }
        }
    }
};

MMGallery.fileNumberClick = function(jObj){
    if(this.files.length>1){
        if(!this.filesBlocked){
            this.fileAutoMove = false;
            var position = parseInt(jObj.attr('id').replace('MMFilesNumber',''));
            if(position>0 && position<=this.files.length){
                this.currentFile = position-1;
                this.setFile();
            }
        }
    }
};

MMGallery.chooseFile = function(obj){
    if(!this.filesBlocked){
        var fileIndex = parseInt(obj.parent().attr('id').replace('MMGalleryItem',''));
        this.currentFile = fileIndex-1;
        this.setFile();
    }
};

MMGallery.setFile=function(){
    this.filesBlocked = true;
    console.trace(this.filesBlocked);
    var file = this.files[this.currentFile];
    var randomId = Tools.randomString(20);
    
    
    var dummyString = '<div id="'+randomId+'" class="MMFilesItem" style="opacity:0">';
    dummyString += '<img class="MMFilesItemImage" src="'+file.url+'"/></div>';
            
    var filesDiv = $('#MMFiles');
    var currentFileDiv = $(filesDiv.children()[0]);
    $('#MMFiles').append(dummyString);
    
    var instance = this;
    Tools.delay(100,
        function(){
            currentFileDiv.animate({'opacity':'0'},500,function(){
                $(this).remove();
                instance.resize();
                $('#'+randomId).animate({'opacity':'1'},500,function(){
                                   instance.filesBlocked = false;
                               });
                
            });
        }
    );
        
};

MMGallery.setThumbnails=function(){
    var html = '';
    
    for (var i = 0; i < this.files.length; i++) {
        var rightMargin = i==this.files.length-1?"":"rightMarginItem";
        html += '<div id="MMGalleryItem'+ (i+1) +'" class="MMGalleryItemWrapper '+ rightMargin +'">';
        html += '<img class="MMGalleryImage" src="'+this.files[i]['url'] +'">';
        html += '</div>';
    }
    
    Tools.delay(100,
        function(){
            $('#MMGalleryItemsWrapper').css('opacity','0');
            $('#MMGalleryItemsWrapper').html(html);
            $('#MMGalleryItemsWrapper').animate({'opacity':'1'},1000);
        }
    );
    
};

MMGallery.getWidthHeightLeftTop = function(file){
    var width = this.width;
    var height = this.height;
    var left = 0;
    var top = 0;
    
    var fileWidth = parseInt(file.width);
    var fileHeight = parseInt(file.height);
    
    if(fileWidth>this.width || fileHeight>this.height){
        if((fileWidth/this.width) > (fileHeight/this.height))
            height = (this.width/fileWidth) * fileHeight;
        else if((fileWidth/this.width) < (fileHeight/this.height))
            width = (this.height/fileHeight) * fileWidth;
    }
    else{
        width = fileWidth;
        height = fileHeight;
    }
    
    top = (this.height-height)/2;
    left = (this.width-width)/2;
    
    var widthHeightLeftTop = new Array();
    widthHeightLeftTop['width'] = width;
    widthHeightLeftTop['height'] = height;
    widthHeightLeftTop['left'] = left;
    widthHeightLeftTop['top'] = top;
    
    return widthHeightLeftTop;
};



MMGallery.clicks=function(){
};

MMGallery.startMagnifyingEffect = function(){
    if(this.zoom){
        var instance = this;
        console.log(this.magnifyied);
        $('#MMFiles').on({
                'mouseover':function(e){

                        var current=instance.galleries[0].currentFile;
                        var galleryWidth=instance.galleries[0].width;
                        var fileWidth=parseInt(instance.galleries[0].files[current].width);
                        var galleryHeight=instance.galleries[0].height;
                        var fileHeight=parseInt(instance.galleries[0].files[current].height);

                        if(fileWidth>galleryWidth && fileHeight>galleryHeight){
                            if(!instance.magnifyied){
                                instance.magnifyied = true;
                                console.log(instance.magnifyied);
                                var jObj = $(this);
                                var random = Tools.randomString(20);
                                $(this).parent().parent().append('<div id="magnifyiedProductOuter"><img id="'+random+'" class="magnifyiedProductImage" src=""/></div>');
                                $("#magnifyiedProductOuter").css("width",$(this).parent().parent().width()).css("height",$(this).parent().parent().height());
                                instance.afterMagnifyiedImageLoad(random);
                                $('#'+random).attr('src',jObj.attr('src'));
                            } 
                        }
                }
            },'.MMFilesItemImage'
        );
    }
};

MMGallery.afterMagnifyiedImageLoad = function(id){
    var instance = this;
    $('#'+id).load(
         function(){
           
           //nuevo
            var image = $(this);
            var width = instance.width;
            var height = instance.height;
            var imageWidth = image.width();
            var imageHeight = image.height();
            
            if(imageWidth>width)
                image.css('left',(-1)*((imageWidth-width)/2));
            if(imageHeight>height)
                image.css('top',(-1)*((imageHeight-height)/2));
            
            $('#magnifyiedProductOuter').off().on({
                'mousemove':function(e){
                    var jObj = $(this);
                    var offset = jObj.offset();
                    var x = e.pageX - offset.left;
                    var y = e.pageY - offset.top;
                    var width = $(this).width();
                    var height = $(this).height();
                    var percentageX = x/width;
                    var percentageY = y/height;
                    var image = jObj.find('.magnifyiedProductImage');
                    var imageWidth = image.width();
                    var imageHeight = image.height();
                    
                    if(imageWidth>width)
                        image.css('left',(-1)*(imageWidth-width)*percentageX);
                    if(imageHeight>height)
                        image.css('top',(-1)*(imageHeight-height)*percentageY);
                },
                'mouseout':function(){
                    $(this).remove();
                    instance.magnifyied = false;
                    console.log('mouseout true');
                },
                'click':function(){
                    var src=$(this).find(".magnifyiedProductImage").attr("src");
                    ViewProductFamilyByDetails.setImage(src);
                }
            });
         }
     );
};