var Location = {};
Location.map = null;

$(document).ready(function(){
    $('#googleMapsButton').on({
        'click':function(){
            $('#locationGoogleMap').animate({'opacity':1},1000);
        }
    });
    Tools.delay(500, Location.setGoogleMap);
});

//------------------------------------------------------------------------------
//------------------------------------Maps--------------------------------------
//------------------------------------------------------------------------------

Location.setGoogleMap=function(){
    var mapCanvas = document.getElementById('map-canvas');
    var mapOptions = {
      center: new google.maps.LatLng(-34.653089,-55.595481),
      zoom: 9,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    Location.map = new google.maps.Map(mapCanvas, mapOptions);
    Location.placeMarkers();
};

Location.placeMarkers=function(){
    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(-34.501969, -55.452850), 
        map: Location.map,
        draggable: false,
        icon: '/files/site/mapLogo.png'
    });
    var marker2 = new google.maps.Marker({
        position: new google.maps.LatLng(-34.941294, -54.932789), 
        map: Location.map,
        draggable: false,
        icon: '/files/site/mapPuntaLogo.png'
    });
    var marker3 = new google.maps.Marker({
        position: new google.maps.LatLng(-34.902799, -56.165226), 
        map: Location.map,
        draggable: false,
        icon: '/files/site/mapMVDLogo.png'
    });
};