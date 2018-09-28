Gallery = {};
Gallery.youtubePlayer = {};
Gallery.items = [];
Gallery.currentItem = 0;
Gallery.YOUTUBE_VIDEO="4";
Gallery.videoHeight = 720;
Gallery.videoWidth = 1280;
Gallery.headerHeight = 130;
Gallery.whiteBottom = 150;
Gallery.duration=0;
Gallery.blockEventListener=false;
Gallery.firstVideoPlayed=false;
Gallery.firstItemShowed=false;
Gallery.imageDuration=5000;
Gallery.showCircles = true;
Gallery.autoChange = true;
Gallery.videoMuted = false;
Gallery.videoPlaying = true;
Gallery.randomVideo = false;
Gallery.isMobile = false;

var Video = {};

Gallery.start = function(headerHeight, whiteBottom, showCircles, randomVideo, isMobile){ 
        Gallery.headerHeight = headerHeight;
        Gallery.whiteBottom = whiteBottom;
        Gallery.showCircles = showCircles;
        Gallery.randomVideo = randomVideo;
        Gallery.isMobile = isMobile;
        Gallery.getItems();
        Gallery.putCircles();
        Gallery.setItem();
        $(window).resize(function(){
          Gallery.resize();
        });
        Gallery.resize();
};

Gallery.getItems = function(){
    Gallery.items = $.parseJSON($('#itemsArray').val());
    var urlArray = [];
    for(var i=0; i<Gallery.items.length; i++)
        urlArray.push(Gallery.items[i].url);
    
    Loader.start(urlArray, function(){});
};

Gallery.putCircles = function(){
    var numberOfItems = Gallery.items.length;
    console.log(numberOfItems);
    var circlesHtml = "<div id='circlesWrapper'>";
    for(var i=0; i<numberOfItems; i++){
        circlesHtml += "<div id='highlight-"+(i+1)+"' class='highlightCircle backgroundColor4'></div>";
    }
    circlesHtml += "</div>";

    $("#gallery").append(circlesHtml);

    $("body").on('click', '.highlightCircle', function(){
       var fullId = $(this).attr('id');
       var idArray = fullId.split('-');
       var position = parseInt(idArray[1]);
       Gallery.showItem(position-1);
    });
};

Gallery.setItem = function(){
    if(Gallery.firstItemShowed){
        $('#galleryBlackCover').animate({'opacity':1},1000,
            function(){
                $('#galleryImage').css('opacity',0);
                $('#galleryVideo').css('opacity',0);
                
                if(Gallery.isMobile)
                    while(Gallery.items[Gallery.currentItem].file_type_id===Gallery.YOUTUBE_VIDEO)
                        Gallery.nextItem();
                
                if(Gallery.items[Gallery.currentItem].file_type_id===Gallery.YOUTUBE_VIDEO)
                    Gallery.setVideo();
                else
                    Gallery.setImage();
            }
        );
    }
    else{
        Gallery.firstItemShowed=true;
        
        if(Gallery.isMobile){
            while(Gallery.items[Gallery.currentItem].file_type_id===Gallery.YOUTUBE_VIDEO)
                Gallery.nextItem();
        }
        else if(Gallery.randomVideo){
            Gallery.currentItem = Gallery.getRandomNumberBetween(0, Gallery.items.length - 1);
            while(Gallery.items[Gallery.currentItem].file_type_id!==Gallery.YOUTUBE_VIDEO)
                Gallery.currentItem = Gallery.getRandomNumberBetween(0, Gallery.items.length - 1);
        }
        
        if(Gallery.items[Gallery.currentItem].file_type_id===Gallery.YOUTUBE_VIDEO)
            Gallery.setVideo();
        else
            Gallery.setImage();
    }
    Gallery.markCircle(Gallery.currentItem);
};

Gallery.markCircle = function(position){
        $(".selectedCircle").each(function(){
            $(this).removeClass('selectedCircle');
        });
           
        var toSelect = $("#highlight-"+(position+1));
        toSelect.addClass('selectedCircle');
};

Gallery.nextItem = function(){
    Gallery.currentItem++;
    if(Gallery.currentItem===Gallery.items.length)
        Gallery.currentItem = 0;
    
    Gallery.setItem();
};


Gallery.resize = function(){
    var width = $(window).width();
    var height = $(window).height();
    
    if(!Gallery.isMobile){
        if(width<1000)
            width=1000;
        if(height<650)
            height=650;
    }
    
        height = height- Gallery.headerHeight - Gallery.whiteBottom;

        if(Gallery.items[Gallery.currentItem].file_type_id===Gallery.YOUTUBE_VIDEO){
            
            var videoWidth = 1920;
            var videoHeight= 1080;
            var videoMargin= 60;

            var viewableWidth = videoWidth;
            var viewableHeight= videoHeight-videoMargin-videoMargin;

            var finalViewbaleVideoWidth = width;
            var finalViewbaleVideoHeight = viewableHeight * finalViewbaleVideoWidth / viewableWidth;

            var finalLeft = 0; 
            if(finalViewbaleVideoHeight<height){
                finalViewbaleVideoHeight = height;
                finalViewbaleVideoWidth = viewableWidth * finalViewbaleVideoHeight / viewableHeight;
                finalLeft = (width-finalViewbaleVideoWidth)/-2;
            }

            var finalMarginTop = videoMargin * finalViewbaleVideoHeight / viewableHeight;
            var finalMarginBottom = videoMargin * finalViewbaleVideoHeight / viewableHeight;

            var finalVideoWidth = finalViewbaleVideoWidth;
            var finalVideoHeight = finalViewbaleVideoHeight + finalMarginTop + finalMarginBottom;

            $('#galleryVideo').css('width',finalVideoWidth).css('height',finalVideoHeight).css('top',(-1)*finalMarginTop).css('left',(-1)*finalLeft);

            $('#galleryItemContainer').css('height',height);
        }
        else{
            var imageWidth = Gallery.items[Gallery.currentItem].width;
            var imageHeight = Gallery.items[Gallery.currentItem].height;

            var finalImageWidth = width;
            var finalImageHeight = imageHeight * width / imageWidth;
            
            if(finalImageHeight<height){
                finalImageHeight = height;
                finalImageWidth = imageWidth * height / imageHeight;
            }                

            $('#galleryImage').css({'width':finalImageWidth, 'height':finalImageHeight});
            $('.galleryImage').css({'width':finalImageWidth, 'height':finalImageHeight});
                
            if(width>height){
                if(finalImageHeight>height){
                    $('#galleryItemContainer').css('height',height);
                    $('.videoController2').css('top', (height-80)+"px");
                }
                else{
                    $('#galleryItemContainer').css('height',finalImageHeight);
                    $('.videoController2').css('top', (finalImageHeight-80)+"px");
                }
            }
            else{
                $('#galleryItemContainer').css('height',finalImageHeight);
                $('.videoController2').css('top', (height-80)+"px");
            }
            
            $('#galleryTitle').css('top',(height/4));
        }
};

//IMG FUNCTIONS
Gallery.setImage = function(){
    Video.hideController();
    var item = Gallery.items[Gallery.currentItem];
    var imageUrl = item.url;
    var title = item.title;
    
    $('#galleryImage').attr('src',imageUrl);
    $('#galleryTitle').html(item.title);
    $('#galleryTitle').css('font-size',item.font_size+'px');
    $('#galleryTitle').css('letter-spacing',item.letter_spacing+'px');
    
    $('#galleryImage').animate({'opacity':'1'},1000);
        $('#galleryBlackCover').animate({'opacity':'0'},1000,
            function(){
                Tools.delay(Gallery.imageDuration,
                    function(){
                        if(Gallery.autoChange){
                            Gallery.nextItem();
                        }
                    }
                );
           }
        );
        Gallery.resize();
};


//VIDEO FUNCTIONS
Gallery.setVideo = function(){
    if(!Gallery.firstVideoPlayed){
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/player_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        if(firstScriptTag.src.indexOf("https://s.ytimg.com/")!=-1)
            onYouTubePlayerAPIReady();
        else
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    }
    else{
        Gallery.playVideo();
    }
    Video.showController();
};

onYouTubePlayerAPIReady = function(){
    Gallery.playVideo();
};

Gallery.playVideo = function(){
    Gallery.loopingVideo = true;
    Gallery.videoPlaying = true;
    var videoId = Gallery.items[Gallery.currentItem].url;
    
    var width = $(window).width();
    var height = $(window).height();
    
    if(width<1000)
        width = 1000;
    if(height<500)
        height = 500;
    
    var finalVideoWidth = width;
    var finalVideoHeight = Gallery.videoHeight * finalVideoWidth / Gallery.videoWidth;
    
    if(finalVideoHeight+Gallery.headerHeight<height){
        finalVideoHeight = height-Gallery.headerHeight;
        finalVideoWidth = Gallery.videoWidth * finalVideoHeight / Gallery.videoHeight;
    }
    
    if(Gallery.firstVideoPlayed){
        Gallery.youtubePlayer.loadVideoById(videoId);
        $('#galleryBlackCover').animate({'opacity':'0'},1000);
        $('#galleryVideo').animate({'opacity':'1'},1000);
    }
    else{
        Gallery.firstVideoPlayed=true;
        Gallery.youtubePlayer = new YT.Player('galleryVideo', {
        width:finalVideoWidth,
        height:finalVideoHeight,
        videoId:''+videoId,
        playerVars:{
            controls:0,
            iv_load_policy:3,
            autoplay:1,
            showinfo:0,
            disablekb:1,
            rel:0,
            enablejsapi:1,
            modestbranding:1,
            start:0,
            wmode:'transparent'
        }
        });
        $('#galleryVideo').attr('wmode','Opaque');
        Gallery.youtubePlayer.addEventListener('onStateChange', 
            function(e) {
                if(!Gallery.blockEventListener){
                    if(Gallery.videoMuted)
                        Gallery.youtubePlayer.setVolume(0);
                    else
                        Gallery.youtubePlayer.setVolume(100);
                    if(parseInt(e.data)===parseInt(YT.PlayerState.ENDED)){
                        //Gallery.nextItem();
                        //Gallery.loopingVideo = false;
                    }
                    Gallery.duration = Gallery.youtubePlayer.getDuration();
                    if(!isNaN(Gallery.duration) && Gallery.duration!==0){
                        Gallery.checkVideoLoop();
                        $('#galleryVideo').animate({'opacity':'1'},1000);
                    }
                }
            }
        );
        $('#galleryBlackCover').animate({'opacity':'0'},1000);
        $('#galleryVideo').animate({'opacity':'1'},1000);
    }
    
    Gallery.resize();
};

Gallery.checkVideoLoop = function(){
    
    if(Gallery.loopingVideo){
        var videoCurrentTime = Gallery.youtubePlayer.getCurrentTime();
        if(!isNaN(videoCurrentTime) && videoCurrentTime!==0){
            if(Gallery.duration-videoCurrentTime<3){
                Gallery.loopingVideo = false;
                if(Gallery.autoChange){
                    Gallery.nextItem();
                }
            }
        }
    }
    if(Gallery.loopingVideo){
        Tools.delay(1000, Gallery.checkVideoLoop);
    }
};

Gallery.showItem = function(position){
    if(Gallery.items[Gallery.currentItem].file_type_id===Gallery.YOUTUBE_VIDEO){
        if(Gallery.videoPlaying){
            Gallery.youtubePlayer.pauseVideo();
            Gallery.videoPlaying = false;
        }
    }
    Gallery.currentItem = position;
    Gallery.autoChange = false;
    Gallery.setItem();
};


Video.hideController = function(){
    $('.videoController2').animate({'opacity':0},1000,
        function(){
            $('.videoController2').css('display','none');
        }
    );
};

Video.showController = function(){
    $('.videoController2').css('display','block');
    $('.videoController2').animate({'opacity':1},1000);
    
    var playButton = $('.pauseButton2, .playButton2');
    playButton.removeClass('pauseButton2');
    playButton.removeClass('playButton2');
    playButton.addClass('pauseButton2');
};

Gallery.bindVideoFunctions = function(){
    $('.muteButton2, .unMuteButton2').on("click", function(){
        Video.muteUnMute(this);
    });
    $('.pauseButton2, .playButton2').on("click", function(){
        Video.playPause(this);
    });
    $('.fullscreenButton2').on('click touch', function(){
        Video.toggleFullScreen();
    });
};

Video.muteUnMute = function(obj){
    
    if(Gallery.videoMuted)
        Gallery.youtubePlayer.setVolume(100);
    else
        Gallery.youtubePlayer.setVolume(0);
    
    Gallery.videoMuted = !Gallery.videoMuted;
    $(obj).toggleClass("unMuteButton2 muteButton2");
};

Video.playPause = function(obj){
    if(Gallery.videoPlaying)
        Gallery.youtubePlayer.pauseVideo();
    else
        Gallery.youtubePlayer.playVideo();
    
    Gallery.videoPlaying = !Gallery.videoPlaying;
    
    if(obj!=null){
        obj = $(obj)
        var classText = obj.attr('class');
        
        if(classText.indexOf('playButton2')!=-1){
            obj.removeClass('playButton2');
            obj.addClass('pauseButton2');
        }
        else if(classText.indexOf('pauseButton2')!=-1){
            obj.removeClass('pauseButton2');
            obj.addClass('playButton2');
        }
    }
};

Gallery.getRandomNumberBetween = function(min, max){
    return Math.floor(Math.random()*(max-min+1)+min);
};