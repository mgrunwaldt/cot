var Mobile = {};
Mobile.menuHeight = 0;
Mobile.menuHeight = 0;
Mobile.menuIsOpen = false;
Mobile.contactIsOpen = false;
Mobile.contactHeight = 0;

$(document).ready(function(){
   Mobile.menuHeight = $("#menuWrapper").height();
   Mobile.contactHeight = parseInt($(window).height()) - 72;
   
   if(Mobile.contactHeight < 478){
       $("#contactDiv").css("overflow","scroll");
   }
   $("#contactDiv").css("width", $(window).width()-2);
   $("#headerMenuIcon").click(function(){
      Mobile.toggleMenu(); 
   });
   
   $("#headerContactInfoButton").click(function(){
       Mobile.toggleContact();
   });
   
   $("#contactSend").click(function(){
       Main.sendContact();
   });
});

Mobile.toggleMenu = function(){
    if(!Mobile.contactIsOpen){
        if(Mobile.menuIsOpen){
            $("#menuDiv").animate({'height':0}, 300);
            Mobile.menuIsOpen = false;
        }else{
            $("#menuDiv").animate({'height':Mobile.menuHeight}, 300);
            Mobile.menuIsOpen = true;
        }
    }
};

Mobile.toggleContact = function(){
    if(Mobile.contactIsOpen){
        $("#contactDiv").animate({'height':0}, 300);
        Mobile.contactIsOpen = false;
    }else{
        $("#contactDiv").animate({'height':Mobile.contactHeight}, 300);
        Mobile.contactIsOpen = true;
    }
};
