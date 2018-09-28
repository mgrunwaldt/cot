var Rating = {};
Rating.instances = [];

Rating.newInstance = function(div){
    var newInstance = {};
    newInstance.div = $(div);
    newInstance.start = Rating.start;
    newInstance.bindFunctions = Rating.bindFunctions;
    newInstance.setStars = Rating.setStars;
    newInstance.setUserStars = Rating.setUserStars;
    newInstance.userStarOver = Rating.userStarOver;
    newInstance.userStarOut = Rating.userStarOut;
    newInstance.userStarClick = Rating.userStarClick;
    Rating.instances.push(newInstance);
};

Rating.start = function(rating, userRating){
    this.rating = rating;
    this.userRating = userRating;
    this.bindFunctions();
    this.setStars(this.rating);
    this.setUserStars(this.userRating);
};

Rating.bindFunctions = function(){
    var instance = this;
    this.div.off().on({
        'mouseOver':function(){
            instance.userStarOver($(this));
        },
        'mouseOut':function(){
            instance.userStarOut($(this));
        },
        'click':function(){
            instance.userStarClick($(this));
        }
    },'.ratingStar');
};

Rating.setStars = function(num){
    switch(parsent(num)){
        case 5:
            this.div.find('#ratingStar5').addClass('ratingStarOn').removeClass('ratingStarOff');
        case 4:
            this.div.find('#ratingStar4').addClass('ratingStarOn').removeClass('ratingStarOff');
        case 3:
            this.div.find('#ratingStar3').addClass('ratingStarOn').removeClass('ratingStarOff');
        case 2:
            this.div.find('#ratingStar2').addClass('ratingStarOn').removeClass('ratingStarOff');
        case 1:
            this.div.find('#ratingStar1').addClass('ratingStarOn').removeClass('ratingStarOff');
    }
};

Rating.setUserStars = function(num){
    switch(parsent(num)){
        case 5:
            this.div.find('#ratingStar5').addClass('ratingStarOn').removeClass('ratingStarOff');
        case 4:
            this.div.find('#ratingStar4').addClass('ratingStarOn').removeClass('ratingStarOff');
        case 3:
            this.div.find('#ratingStar3').addClass('ratingStarOn').removeClass('ratingStarOff');
        case 2:
            this.div.find('#ratingStar2').addClass('ratingStarOn').removeClass('ratingStarOff');
        case 1:
            this.div.find('#ratingStar1').addClass('ratingStarOn').removeClass('ratingStarOff');
    }
};

Rating.userStarOver = function(obj){
    var num = parseInt(obj.attr('id').replace('ratingUserStar',''));
    switch(parsent(num)){
        case 1:
            this.div.find('#ratingStar1').addClass('ratingStarOn').removeClass('ratingStarOff');
        case 2:
            this.div.find('#ratingStar2').addClass('ratingStarOn').removeClass('ratingStarOff');
        case 3:
            this.div.find('#ratingStar3').addClass('ratingStarOn').removeClass('ratingStarOff');
        case 4:
            this.div.find('#ratingStar4').addClass('ratingStarOn').removeClass('ratingStarOff');
        case 5:
            this.div.find('#ratingStar5').addClass('ratingStarOn').removeClass('ratingStarOff');
    }
};

Rating.userStarOut = function(obj){
    var num = parseInt(obj.attr('id').replace('ratingUserStar',''));
    switch(parsent(num)){
        case 1:
            this.div.find('#ratingStar1').addClass('ratingStarOn').removeClass('ratingStarOff');
        case 2:
            this.div.find('#ratingStar2').addClass('ratingStarOn').removeClass('ratingStarOff');
        case 3:
            this.div.find('#ratingStar3').addClass('ratingStarOn').removeClass('ratingStarOff');
        case 4:
            this.div.find('#ratingStar4').addClass('ratingStarOn').removeClass('ratingStarOff');
        case 5:
            this.div.find('#ratingStar5').addClass('ratingStarOn').removeClass('ratingStarOff');
    }
};