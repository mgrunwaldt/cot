var ImageGallery = {};

ImageGallery.create = function(gallery, nextButton, previousButton, files, width, time){
    ImageGallery.gallery = gallery;
    ImageGallery.files = files;
    ImageGallery.width = width;
    ImageGallery.time = time;
    ImageGallery.nextButton = nextButton;
    ImageGallery.previousButton = previousButton;
    ImageGallery.current = 0;
    ImageGallery.auto = true;
    ImageGallery.locked = false;
    ImageGallery.next = this.next;
    ImageGallery.previous = this.previous;
    ImageGallery.getNextFile = this.getNextFile;
    ImageGallery.getPreviousFile = this.getPreviousFile;
    ImageGallery.start = this.start;
    ImageGallery.animate = this.animate;
    ImageGallery.bind = this.bind;
    ImageGallery.autoNext = this.autoNext;
    return this;
};


ImageGallery.start = function(){
    var instance = this;
    var file = this.files[this.current];
    var nextFile = this.getNextFile();
    var previousFile = this.getPreviousFile();
    
    this.gallery.append('<img src="'+previousFile.url+'" style="position:absolute; left:'+((-1)*this.width)+'px; top:0px;"/>');
    this.gallery.append('<img src="'+file.url+'" style="position:absolute; left:0px; top:0px;"/>');
    this.gallery.append('<img src="'+nextFile.url+'" style="position:absolute; left:'+(this.width)+'px; top:0px;"/>');
    
    this.bind();
    Tools.delay(this.time, 
        function(){
            instance.autoNext();
        }
    );
};

ImageGallery.bind = function(){
    var instance = this;
    
    this.nextButton.on({
        'click':function(){
            if(!instance.locked){
                instance.auto = false;
                instance.next();
            }
        }
    });
    
    this.previousButton.on({
        'click':function(){
            if(!instance.locked){
                instance.auto = false;
                instance.previous();
            }
        }
    });
};

ImageGallery.autoNext = function(){
    if(this.auto){
        this.next();
        var instance = this;
        Tools.delay(this.time, 
            function(){
                instance.autoNext();
            }
        );
    }
};

ImageGallery.next = function(){
    this.current++;
    if(this.current===this.files.length)
        this.current = 0;
    this.animate(true);
};

ImageGallery.previous = function(){
    this.current--;
    if(this.current===-1)
        this.current = this.files.length-1;
    this.animate();
};

ImageGallery.getNextFile = function(){
    var next = this.current+1;
    if(next===this.files.length)
        next = 0;
    return this.files[next];
};

ImageGallery.getPreviousFile = function(){
    var previous = this.current-1;
    if(previous===-1)
        previous = this.files.length-1;
    return this.files[previous];
};

ImageGallery.animate = function(next){
    this.locked = true;
    var instance = this;
    if(next){
        var file = this.getNextFile();
        var children = this.gallery.children();
        
        $(children[1]).animate({'left':((-1)*this.width)+'px'},1000,'');
        $(children[2]).animate({'left':'0px'},1000,function(){instance.locked = false;});
        $(children[0]).remove();
        this.gallery.append('<img src="'+file.url+'" style="position:absolute; left:'+(this.width)+'px; top:0px;"/>');
    }
    else{
        var file = this.getPreviousFile();
        var children = this.gallery.children();
        
        $(children[0]).animate({'left':'0px'},1000,'');
        $(children[1]).animate({'left':(this.width)+'px'},1000,function(){instance.locked = false;});
        $(children[2]).remove();
        this.gallery.prepend('<img src="'+file.url+'" style="position:absolute; left:'+((-1)*this.width)+'px; top:0px;"/>');
    }
    
};