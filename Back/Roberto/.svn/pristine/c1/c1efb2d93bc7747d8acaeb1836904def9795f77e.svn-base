var Investments = {};

$(document).ready(function(){
   Investments.bindFunctions(); 
});

Investments.bindFunctions = function(){
    $("#ranchSelect").on({
       'change':function(){
           Investments.ranchSelected();
       } 
    });
};

Investments.ranchSelected = function(){
    var selectedId = $("#ranchSelect").val();
    if(selectedId != 0){
        window.location.href = '/Ranches/view/'+selectedId;
    }
};