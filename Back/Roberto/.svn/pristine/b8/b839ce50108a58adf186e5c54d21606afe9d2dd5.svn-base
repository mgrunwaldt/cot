var Slider = {};
Slider.instances = [];

Slider.newInstance = function(divId, arrowWidth, arrowHeight, clickFunction){
    var newInstance = {};
    newInstance.div = $('#'+divId);
    newInstance.arrowWidth = arrowWidth;
    newInstance.arrowHeight = arrowHeight;
    newInstance.start = Slider.start;
    newInstance.bindFunctions = Slider.bindFunctions;
    newInstance.addImage = Slider.addImage;
    newInstance.setElements = Slider.setElements;
    newInstance.dragged = Slider.dragged;
    newInstance.scrollZoneClick = Slider.scrollZoneClick;
    newInstance.clickFunction = clickFunction;
    Slider.instances.push(newInstance);
    return newInstance;
};

Slider.start = function(images){
    this.div.find('#meSliderFiles').html('');
    
    var meSliderFilesWidth = 0;
    var meSliderFilesHeight = parseFloat(this.div.find('#meSliderFiles').height());
    for(var i=0; i<images.length; i++){
       this.addImage(images[i].id, images[i].url); 
       meSliderFilesWidth += parseFloat(images[i].width)*meSliderFilesHeight/parseFloat(images[i].height);
   }
   this.div.find('#meSliderFiles').css('width',meSliderFilesWidth);
   this.bindFunctions();
};

Slider.bindFunctions = function(){
    var instance = this;
    instance.setElements();
    instance.div.find('#meSliderScrollBarBall').draggable({ 
        axis: "x", 
        containment: "parent",
        drag: function() {
          instance.dragged();
        }
    });
    instance.div.find('#meSliderScrollZone').off().on({ 
        click: function(e){
            instance.scrollZoneClick(this, e);
        }
    });
    instance.div.find('#meSliderFiles').off().on({ 
        click: function(){
            instance.clickFunction(this);
        }
    },'.meSliderFile');
};

Slider.addImage = function(id, url){
    this.div.find('#meSliderFiles').append('<img id="'+id+'" class="meSliderFile" src="'+url+'"/>');
};

Slider.setElements = function(){
    var scrollBar = this.div.find('#meSliderScrollBar');
    var leftArrow = scrollBar.find('#meSliderLeftArrow');
    var rightArrow = scrollBar.find('#meSliderRightArrow');
    var scrollZone = scrollBar.find('#meSliderScrollZone');
    
    var scrollBarHeight = parseFloat(scrollBar.height());
    var scrollZoneHeight = parseFloat(scrollZone.height());
    
    var scrollBarWidth = parseFloat(scrollBar.width());
    var scrollZoneWidth = scrollBarWidth-this.arrowWidth-this.arrowWidth;
    
    scrollZone.css('width',scrollZoneWidth+4);
    
    scrollZone.css('top',(scrollBarHeight-scrollZoneHeight)/2);
    leftArrow.css('top',(scrollBarHeight-this.arrowHeight)/2);
    rightArrow.css('top',(scrollBarHeight-this.arrowHeight)/2);
    
    leftArrow.css('left','0px');
    scrollZone.css('left',this.arrowWidth-2);
    rightArrow.css('left',this.arrowWidth+scrollZoneWidth);
};

Slider.dragged = function(){
    var scrollBar = this.div.find('#meSliderScrollBar');
    var ball = this.div.find('#meSliderScrollBarBall');
    var meSliderFilesContainer = this.div.find('#meSliderFilesContainer');
    var meSliderFiles = this.div.find('#meSliderFiles');
    
    var ballLeft = parseFloat(ball.css('left'));
    var scrollBarWidth = parseFloat(scrollBar.width());
    var meSliderFilesContainerWidth = parseFloat(meSliderFilesContainer.width());
    var meSliderFilesWidth = parseFloat(meSliderFiles.width());
    
    if(meSliderFilesWidth>meSliderFilesContainerWidth){
        meSliderFiles.css('left',(-1)*(meSliderFilesWidth-meSliderFilesContainerWidth)*(ballLeft/scrollBarWidth));
    }
    else
        meSliderFiles.css('left',0);
};

Slider.scrollZoneClick = function(obj, event){
    var parentOffset = $(obj).parent().offset(); 
    var relX = event.pageX - parentOffset.left - 30;
    if(relX<0)
        relX = 0;
    this.div.find('#meSliderScrollBarBall').css('left',relX);
    this.dragged();
};