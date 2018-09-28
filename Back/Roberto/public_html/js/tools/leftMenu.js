var LeftMenu = {};
LeftMenu.categoriesLevelOneHeight = 22;
LeftMenu.categoriesLevelTwoHeight = 22;
LeftMenu.categoriesLevelThreeHeight = 22;
LeftMenu.categoriesLevelFourHeight = 22;
LeftMenu.categoriesAnimationSpeed = 600;
LeftMenu.categoriesAnimationLocked = false;
    
$(document).ready(
    function(){
        //LeftMenu.bindFunction();
    }
);

LeftMenu.bindFunction = function(){
    $('.searchSectorName').on({
        'click':function(){
            if(!LeftMenu.categoriesAnimationLocked){
                LeftMenu.categoriesAnimationLocked = true;
                LeftMenu.toggleSector($(this));
            }
        }
    });
    $('.searchCategoryLevelOneName').on({
        'click':function(){
            if(!LeftMenu.categoriesAnimationLocked){
                LeftMenu.categoriesAnimationLocked = true;
                LeftMenu.toggleCategoryLevelOne($(this));
            }
        }
    });
    $('.searchCategoryLevelTwoName').on({
        'click':function(){
            if(!LeftMenu.categoriesAnimationLocked){
                LeftMenu.categoriesAnimationLocked = true;
                LeftMenu.toggleCategoryLevelTwo($(this));
            }
        }
    });
    $('.searchCategoryLevelThreeName').on({
        'click':function(){
            if(!LeftMenu.categoriesAnimationLocked){
                LeftMenu.categoriesAnimationLocked = true;
                LeftMenu.toggleCategoryLevelThree($(this));
            }
        }
    });
};

LeftMenu.toggleSector = function(sectorNameObj){
    var categoriesLevelOneObj = sectorNameObj.parent().find('.searchCategoriesLevelOne');
    var height = categoriesLevelOneObj.css('height');
    if(parseInt(height)===0){
        var newHeight = LeftMenu.getCategoriesLevelOneHeight(categoriesLevelOneObj);
        categoriesLevelOneObj.stop().animate({'height':newHeight}, LeftMenu.categoriesAnimationSpeed, 
            function(){
                $(this).css('height','auto');
                LeftMenu.categoriesAnimationLocked = false;
            }
        );
        sectorNameObj.find('.searchSectorAccordionArrow').html('&#8964;').addClass('searchSectorAccordionArrowOpened');
    }
    else{
        categoriesLevelOneObj.stop().animate({'height':0}, LeftMenu.categoriesAnimationSpeed, 
            function(){
                LeftMenu.categoriesAnimationLocked = false;
            }
        );
        sectorNameObj.find('.searchSectorAccordionArrow').html('>').removeClass('searchSectorAccordionArrowOpened');
    }
};

LeftMenu.toggleCategoryLevelOne = function(categoryLevelOneNameObj){
    var categoriesLevelTwoObj = categoryLevelOneNameObj.parent().find('.searchCategoriesLevelTwo');
    var height = categoriesLevelTwoObj.css('height');
    if(parseInt(height)===0){
        var newHeight = LeftMenu.getCategoriesLevelTwoHeight(categoriesLevelTwoObj);
        categoriesLevelTwoObj.stop().animate({'height':newHeight}, LeftMenu.categoriesAnimationSpeed, 
            function(){
                $(this).css('height','auto');
                LeftMenu.categoriesAnimationLocked = false;
            }
        );
        categoryLevelOneNameObj.find('.categoryLevelOneAccordionArrow').html('&#8964;').addClass('categoryLevelOneAccordionArrowOpened');
        LeftMenu.putCategoriesLevelTwo(categoriesLevelTwoObj);
        $('#searchSectors').find('.color3').removeClass('color3');
        categoryLevelOneNameObj.addClass('color3');
    }
    else{
        categoriesLevelTwoObj.stop().animate({'height':0}, LeftMenu.categoriesAnimationSpeed, 
            function(){
                LeftMenu.categoriesAnimationLocked = false;
            }
        );
        categoryLevelOneNameObj.find('.categoryLevelOneAccordionArrow').html('>').removeClass('categoryLevelOneAccordionArrowOpened');
    }
};

LeftMenu.toggleCategoryLevelTwo = function(categoryLevelTwoNameObj){
    var categoriesLevelThreeObj = categoryLevelTwoNameObj.parent().find('.searchCategoriesLevelThree');
    var height = categoriesLevelThreeObj.css('height');
    if(parseInt(height)===0){
        var newHeight = LeftMenu.getCategoriesLevelThreeHeight(categoriesLevelThreeObj);
        categoriesLevelThreeObj.stop().animate({'height':newHeight}, LeftMenu.categoriesAnimationSpeed, 
            function(){
                $(this).css('height','auto');
                LeftMenu.categoriesAnimationLocked = false;
            }
        );
        categoryLevelTwoNameObj.find('.categoryLevelTwoAccordionArrow').html('&#8964;').addClass('categoryLevelTwoAccordionArrowOpened');
        LeftMenu.putCategoriesLevelThree(categoriesLevelThreeObj);
        $('#searchSectors').find('.color3').removeClass('color3');
        categoryLevelTwoNameObj.addClass('color3');
    }
    else{
        categoriesLevelThreeObj.stop().animate({'height':0}, LeftMenu.categoriesAnimationSpeed, 
            function(){
                LeftMenu.categoriesAnimationLocked = false;
            }
        );
        categoryLevelTwoNameObj.find('.categoryLevelTwoAccordionArrow').html('>').removeClass('categoryLevelTwoAccordionArrowOpened');
    }
};

LeftMenu.toggleCategoryLevelThree = function(categoryLevelThreeNameObj){
    var categoriesLevelFourObj = categoryLevelThreeNameObj.parent().find('.searchCategoriesLevelFour');
    var height = categoriesLevelFourObj.css('height');
    if(parseInt(height)===0){
        var newHeight = LeftMenu.getCategoriesLevelFourHeight(categoriesLevelFourObj);
        categoriesLevelFourObj.stop().animate({'height':newHeight}, LeftMenu.categoriesAnimationSpeed, 
            function(){
                $(this).css('height','auto');
                LeftMenu.categoriesAnimationLocked = false;
            }
        );
        categoryLevelThreeNameObj.find('.categoryLevelThreeAccordionArrow').html('&#8964;').addClass('categoryLevelThreeAccordionArrowOpened');
        LeftMenu.putCategoriesLevelFour(categoriesLevelFourObj);
        $('#searchSectors').find('.color3').removeClass('color3');
        categoryLevelThreeNameObj.addClass('color3');
    }
    else{
        categoriesLevelFourObj.stop().animate({'height':0}, LeftMenu.categoriesAnimationSpeed, 
            function(){
                LeftMenu.categoriesAnimationLocked = false;
            }
        );
        categoryLevelThreeNameObj.find('.categoryLevelThreeAccordionArrow').html('>').removeClass('categoryLevelThreeAccordionArrowOpened');
    }
};


//GET HEIGHTS
LeftMenu.getCategoriesLevelOneHeight = function(categoriesLevelOneObj){
    var heightCount = 0;
    categoriesLevelOneObj.children().each(function () {
        heightCount += LeftMenu.categoriesLevelOneHeight;
        var categoriesLevelTwoObj = $(this).find('.searchCategoriesLevelTwo');
        if(parseInt(categoriesLevelTwoObj.height())!==0)
            heightCount += LeftMenu.getCategoriesLevelTwoHeight(categoriesLevelTwoObj);
    });
    
    return heightCount;
};

LeftMenu.getCategoriesLevelTwoHeight = function(categoriesLevelTwoObj){
    var heightCount = 0;
    categoriesLevelTwoObj.children().each(function () {
        heightCount += LeftMenu.categoriesLevelTwoHeight;
        var categoriesLevelThreeObj = $(this).find('.searchCategoriesLevelThree');
        if(parseInt(categoriesLevelThreeObj.height())!==0)
            heightCount += LeftMenu.getCategoriesLevelThreeHeight(categoriesLevelThreeObj);
    });
    
    return heightCount;
};

LeftMenu.getCategoriesLevelThreeHeight = function(categoriesLevelThreeObj){
    var heightCount = 0;
    categoriesLevelThreeObj.children().each(function () {
        heightCount += LeftMenu.categoriesLevelThreeHeight;
        var categoriesLevelFourObj = $(this).find('.searchCategoriesLevelFour');
        if(parseInt(categoriesLevelFourObj.height())!==0)
            heightCount += LeftMenu.getCategoriesLevelFourHeight(categoriesLevelFourObj);
    });
    
    return heightCount;
};

LeftMenu.getCategoriesLevelFourHeight = function(categoriesLevelFourObj){
    var categoriesLevelFourCount = categoriesLevelFourObj.children().length;
    return categoriesLevelFourCount * LeftMenu.categoriesLevelFourHeight;
};


//PUT IMAGES
LeftMenu.putCategoriesLevelTwo = function(categoriesObj){
    var names = categoriesObj.find('.searchCategoryLevelTwoName');
    var images = categoriesObj.find('.searchCategoryLevelTwoImage');
    LeftMenu.putCategoryImages(names, images);
};
LeftMenu.putCategoriesLevelThree = function(categoriesObj){
    var names = categoriesObj.find('.searchCategoryLevelThreeName');
    var images = categoriesObj.find('.searchCategoryLevelThreeImage');
    LeftMenu.putCategoryImages(names, images);
};
LeftMenu.putCategoriesLevelFour = function(categoriesObj){
    var names = categoriesObj.find('.searchCategoryLevelFourName');
    var images = categoriesObj.find('.searchCategoryLevelFourImage');
    LeftMenu.putCategoryImages(names, images);
};

LeftMenu.putCategoryImages = function(names, images){
    var searchResults = $('#searchResults');
    if(searchResults.length>0){
        var finalHtml = '';
        for(var i=0; i<images.length; i++){
            
            if(i%3!==0)
                finalHtml += '<div class="searchResultSpace"></div>';
            
            finalHtml += '<div class="searchResult">';
            finalHtml += '  <div class="searchResultBox" style="margin-top: 0px;">';
            finalHtml += '      <div class="searchResultTopBar">';
            finalHtml += '          <div class="searchResultName">'+$(names[i]).html()+'</div>';
            finalHtml += '          <img class="searchResultImage" src="'+$(images[i]).val()+'">';
            finalHtml += '      </div>';
            finalHtml += '  </div>';
            finalHtml += '</div>';
        }
        searchResults.html(finalHtml);
    }
};