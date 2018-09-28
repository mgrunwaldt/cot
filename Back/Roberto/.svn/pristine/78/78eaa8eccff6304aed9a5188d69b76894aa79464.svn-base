
var DataContainer={};

DataContainer.index = {};
DataContainer.containersArray = new Array();


(function ($) {
    $.fn.dataContainer = function (title,titleUrl,dataUrl,invertHeader) {
        var dataContainer = {};
        dataContainer.div = $(this);
        dataContainer.title = title;
        dataContainer.titleUrl = titleUrl;
        dataContainer.dataUrl = dataUrl;
        dataContainer.invertHeader = invertHeader;
        dataContainer.loadData = DataContainer.loadData;
        dataContainer.start = DataContainer.start;
        dataContainer.createHtml = DataContainer.createHtml;
        dataContainer.bindFunctions = DataContainer.bindFunctions;
        dataContainer.toggleBoxes = DataContainer.toggleBoxes;
        dataContainer.count = DataContainer.containersArray.length;
        dataContainer.loadData();

        DataContainer.containersArray.push(dataContainer);
        return dataContainer;
 };
})(jQuery);


DataContainer.loadData = function(){
    var instance = this;
    instance.div.html('<div class="dataContainerOverlay"><img class="loaderImage" src="/files/loader.gif"></div>');
    
    $.ajax({
        type: 'POST',
        url: instance.dataUrl,
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                instance.data = response.data;
                instance.start();
            }
            else if(response.status==='error'){
                Tools.alert(response.errorMessage);
            }
            else{
                Tools.alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
            }
        },
        error: function(error){
            Tools.alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
        }
    });
};


DataContainer.start = function(){
    this.createHtml();
    this.bindFunctions();
};

DataContainer.bindFunctions = function(){
   var instance = this;
   var data = this.data;
   
    this.div.on('click', '.subtitle',function(){
        instance.toggleBoxes($(this));
    });
};

DataContainer.createHtml = function(){
    var containerDiv = this.div;
    var data = this.data;
    
    var amount = 3;
    var count = data.length;
    
    if(count < 3)
        amount = count;
    
    var html = "<div class='dataContainer'>";
    html += "<div class='titleContainer'>";
    
    var subtitles = "";
    
    for(var i=0; i<amount; i++){
        var sub = data[i].label;
        var type = i==0 ? 'subtitleOn':'subtitleOff';
        var type2 = i==2 ? '':'subtitleMargin';
        subtitles += "<div id='c"+this.count+"_subtitle_"+ data[i].id +"' class='subtitle "+ type +" "+type2+"'>"+ sub +"</div>";
    }
    
    var titleType = this.invertHeader?'':'titleRight';
    var title = "<div class='title "+ titleType +"'><a href='"+ this.titleUrl +"'>"+this.title+"</a></div>";
   
    if(this.invertHeader){
        html += title;
        html += subtitles;
    }
    else{
       html += subtitles;
       html += title; 
    }

    html += "</div>";// End titleContainer
    
    
    
    
    for (var i=0; i<amount; i++){
        var hidden = i==0 ? 'on':'hidden';
        html += "<div id='c"+this.count+"_dataBox_"+ data[i].id +"' class='data "+ hidden +"'>";
        html += "<img class='dataImage' src='"+ data[i].imageUrl +"'>";
        html += "<div class='dataText'>";
        html += "<div class='dataTitle'>"+ data[i].title +"</div>";
        html += "<div class='dataDescription'>"+ data[i].description +"</div>";
        html += "<div class='viewMore'><a href='"+ data[i].itemUrl +"'>ver más<a></div>";
        html += "</div>"; //End dataText
        html += "</div>"; //End data
    }
    
    
    
    
    html += "</div>";//End dataContainer
    
    containerDiv.html(html);
};

DataContainer.toggleBoxes = function(obj){
    var id = obj.attr('id').replace("c"+this.count+"_subtitle_",'');
    
    var subOn = this.div.find('.subtitleOn');
    subOn.addClass('subtitleOff');
    subOn.removeClass('subtitleOn');
    
    obj.addClass('subtitleOn');
    obj.removeClass('subtitleOff');
    
    var onBox = this.div.find('.on');
    onBox.removeClass('on');
    onBox.addClass('hidden');
    
    var box = this.div.find('#c'+this.count+'_dataBox_'+ id);
    box.addClass('on');
    box.removeClass('hidden');
    
};




