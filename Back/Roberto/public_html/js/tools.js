var Tools = {};
Tools.loaderMaxTime = 7500;
Tools.loaderCodes = new Array();
Tools.loading = false;

$(document).ready(
    function(){
        //Checkboxes
        if($('.adminData').length>0){
            $('.adminData').on({
                'click':function(){
                    var instance = this;
                    Tools.delay(100,
                        function(){
                            $(instance).attr('class','adminCheckboxChecked');
                        }
                    );
                }
            },'.adminCheckbox');

            $('.adminData').on({
                'click':function(){
                    var instance = this;
                    Tools.delay(100,
                        function(){
                            $(instance).attr('class','adminCheckbox');
                        }
                    );
                }
            },'.adminCheckboxChecked');
        }
        //Multidata Checkboxes
        if($('.adminMultiDataTable').length>0){
            $('.adminMultiDataTable').on({
                'click':function(){
                    $(this).attr('class','adminMultiDataCheckboxChecked');
                }
            },'.adminMultiDataCheckbox');
            
            $('.adminMultiDataTable').on({
                'click':function(){
                    $(this).attr('class','adminMultiDataCheckbox');
                }
            },'.adminMultiDataCheckboxChecked');
        }
});

Tools.alert = function(message, type, afterFunc1, afterFunct2, close){
    $('#alertMessageAceptar').hide();
    $('#alertMessageClose').hide();
    
    $('#alertMessageFixedContainer #alertMessageMessage').html(message);
    
    
    $('#alertMessageClose').show();
    $('#alertMessageClose').off().on({
        'click':function(){
            Tools.removeAlert();
        }
    });
    $('#alertCloseButton').off().on({
        'click':function(){
            Tools.removeAlert();
        }
    });
    
    switch(type){
        case 1:
            $('#alertMessageAceptar').show();
            $('#alertMessageAceptar').off().on({
                'click':function(){
                    afterFunc1();
                }
            });
            $('#alertMessageClose').off().on({
                'click':function(){
                    afterFunc1();
                }
            });
        break;
        default:
            $('#alertMessageAceptar').show();
            $('#alertMessageAceptar').off().on({
                'click':function(){
                    Tools.removeAlert();
                }
            });
        break;
    }
    
    if(close===false){
        $('#alertMessageClose').hide();
        $('#alertMessageClose').off();
    }
    
    $('#alertMessageFixedContainer').css({'opacity':'0','display':'block'}).animate({'opacity':1},200);
};

Tools.removeAlert = function(){
    $('#alertMessageFixedContainer').animate({'opacity':'0'},200,function(){
        $(this).hide();
        Tools.resetAlertSize();
    });
};

Tools.setAlertSize = function(width,height){
    $('#alertMessageDiv').css({'width':width,'height':height});
};

Tools.resetAlertSize = function(){
    $('#alertMessageDiv').css({'width':338,'height':'auto'});
};

Tools.randomString = function(numChars){
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    for( var i=0; i < numChars; i++ )
    text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text;
};

Tools.delay = function(time, nextFunc){
    var randomString = Tools.randomString(8);
    $('body').append('<div id="'+randomString+'"></div>');
    $('#'+randomString).animate({'opacity':1},time,
        function(){
            $('#'+randomString).remove();
            nextFunc();
        }
    );
};

Tools.preloadImage = function(src, func){
    var random = Tools.randomString(20);
    $('body').append('<img id="'+random+'" style="position:absolute; left:-3000px; top:-3000px;" src="">');
    Tools.imagePreloaded(random, func);
    $("#"+random).attr('src',src);
};

Tools.imagePreloaded = function(id, func){
        $("#"+id).load(
                function(){
                        $(this).remove();
                        if(typeof func !== 'undefined')
                            func();
                }
        );
};

Tools.refresh = function(){
        var randomString = Tools.randomString(6);
        var url = window.location.href;
        
        if(url.indexOf('refresh')!==-1)
            url = url.split('/index.php/cart/list')[0]+'/index.php/cart/list';
        
        url = url+'?refresh='+randomString;
            
        setTimeout(function(){ window.location.href=url;}, 200);
};

Tools.redirect = function(url){
    setTimeout(function(){ window.location.href=url;}, 200);
};

Tools.showLoading = function(setTimeout){
    Tools.loading = true;
    var code = Tools.randomString(10);
    
    if(typeof setTimeout==='undefined' || setTimeout===true)
        Tools.setTimeout(code);
    $('#loaderFixedContainer').css({'opacity':'0','display':'block'}).animate({'opacity':1},200);
    return code;
};

Tools.removeLoading = function(code){
    Tools.loading = false;
    $('#loaderFixedContainer').animate({'opacity':'0'},200,function(){$(this).hide()});
    for(var i=0; i<Tools.loaderCodes.length; i++)
        if(Tools.loaderCodes[i]===code){
            Tools.loaderCodes[i]=false;
            return true;
        }
};

Tools.setTimeout = function(code){
    Tools.loaderCodes[Tools.loaderCodes.length] = code;
    Tools.delay(Tools.loaderMaxTime,
        function(){
            Tools.timeout(code);
        }
    );
};

Tools.timeout = function(code){
    for(var i=0; i<Tools.loaderCodes.length; i++)
        if(Tools.loaderCodes[i]===code){
            Tools.removeLoading(code);
            return true;
        }
};

Tools.getValueFromCheckbox = function(obj){
    if(obj.attr('class').indexOf('Checked')!==-1)
        return 1;
    else
        return 0;
};

Tools.isNumber = function(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
};

Tools.bounceFromCenter = function(obj, ratio, speed, times){
    var left = parseInt(obj.css('left'));
    var top = parseInt(obj.css('top'));
    var width = parseInt(obj.css('width'));
    var height = parseInt(obj.css('height'));
    
    var bigLeft = left-((width-(width/ratio))/2);
    var bigTop = top-((height-(height/ratio))/2);
    var bigWidth = width*ratio;
    var bigHeight = height*ratio;
    
    obj.stop();
    for(var i=0; i<times; i++)
        obj.animate({
                'top':bigTop,
                'left':bigLeft,
                'width':bigWidth,
                'height':bigHeight
            },speed,'easeOutQuint'
            ).animate({
                'top':top,
                'left':left,
                'width':width,
                'height':height
            },speed,'easeOutQuint'
            );
};

Tools.addStops = function(number){
    var numberString = '';
    number = ''+number;
    var number = number.split('.');
    var units = number[0];
    var cents = '';
    if(number.length>1){
        cents = number[1];
        if(cents.length>2){
            var centsAux = cents.substring(0,2)+'.'+cents.substring(2,cents.length-2);
            cents = ','+Math.round(centsAux);
        }
        else if(cents.length===1){
            cents = ','+cents+'0';
        }
        else{
            cents = ','+cents;
        }
    }
    
    
    for(var i=0; i<units.length; i++)
    {
            if(i%3===0 && i!==0)
                    numberString ='.'+numberString;
            numberString = units.charAt(units.length-i-1) + numberString;
    }
    
    numberString = numberString + cents;
    
    return numberString;
};

Tools.nl2br = function (str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
};


Tools.validateEmail = function(email){ 
 var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/; 
 return email.match(re);
};

Tools.validateBirthdate = function(birthdate){ 
    var birthdate = birthdate.split('-');
    if(birthdate.length===3){
        var year = parseInt(birthdate[0]);
        if(!isNaN(year) && year>1900 && year<2100){
            var month = parseInt(birthdate[1]);
            if(!isNaN(month) && month>0 && month<13){
                var day = parseInt(birthdate[2]);
                if(!isNaN(day) && day>0 && day<32){
                    return true;
                }
            }
        }
    }
};

Tools.decodeHTML = function(string) {
    var map = {"gt":">" /* , … */};
    return string.replace(/&(#(?:x[0-9a-f]+|\d+)|[a-z]+);?/gi, function($0, $1) {
        if ($1[0] === "#") {
            return String.fromCharCode($1[1].toLowerCase() === "x" ? parseInt($1.substr(2), 16)  : parseInt($1.substr(1), 10));
        } else {
            return map.hasOwnProperty($1) ? map[$1] : $0;
        }
    });
};

Tools.checkInputTextFocus = function(obj, text){
    var value = obj.val();
    if(value.trim()===text){
        obj.val('');
    }
};

Tools.checkInputTextBlur = function(obj, text){
    var value = obj.val();
    if(value.trim()===''){
        obj.val(text);
    }
};

Tools.toggleInput = function(input){
    if(input.hasClass('adminInputDisabled'))
        input.removeClass('adminInputDisabled').removeAttr('disabled');
    else
        input.addClass('adminInputDisabled').attr('disabled','disabled');
};

Tools.getMaxSize = function(width, height, maxWidth, maxHeight){
    var returnObj = {};
    
    returnObj.finalWidth = 0;
    returnObj.finalHeight = 0;
    
    if(width/maxWidth > height/maxHeight){
        returnObj.finalWidth = maxWidth;
        returnObj.finalHeight = height * maxWidth / width;
    }
    else{
        returnObj.finalHeight = maxHeight;
        returnObj.finalWidth = width * maxHeight / height;
    }
    
    returnObj.top = (maxHeight/2) - (returnObj.finalHeight/2);
    returnObj.left = (maxWidth/2) - (returnObj.finalWidth/2);
    
    return returnObj;
};

Loader = {};

Loader.images = '';
Loader.nextFunction = '';
Loader.imagesIndex = 0;

Loader.start = function (images, nextFunction) {
    Loader.images = images;
    Loader.nextFunction = nextFunction;
    Loader.imagesIndex = 0;
    if (Loader.images.length > 0)
        Loader.loadImage();
};

Loader.loadImage = function () {
    var auxId = Loader.randomString(20);
    $('body').append('<img id="' + auxId + '" style="display:none;position:absolute;left:-3000px;top:-3000px;" src=""/>');
    $('#' + auxId).load(function () {
        $("#" + auxId).remove();
        Loader.imagesIndex++;
        if (Loader.imagesIndex === Loader.images.length)
            Loader.nextFunction();
        else
            Loader.loadImage();
    });
    $('#' + auxId).attr('src', Loader.images[Loader.imagesIndex]);
};

Loader.randomString = function (numChars) {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    for (var i = 0; i < numChars; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text;
};