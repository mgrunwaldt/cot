    $(document).ready(function(){
        var URL = "192.168.43.173";
        var trayecto = "MONTEVIDEO - PUNTA DEL ESTE"
        var title = "TRAYECTO: " + trayecto;
        var subTitleTop = "Siguiente Parada:";
        var subTitleBottom = "BUS STOP";
        var previousStop = "asd";
        var actualStop = "asd2";
        var nextStop = "asd3";
        var previousDistance = 100;
        var longitudes = [-55.08290774, -55.06590774, -55.0649066924, -55.06290774, -55.04290774];
        var index = 0;
        
        setInterval(function() {

            var infoArray = getLatitudLongitude();
            var latitude = -34.8753169056;
            var longitude = longitudes[index%5];
            index++;
            $.ajax({
                type:"GET",
                dataType: 'json',
               // dataType: 'jsonp',
               // jsonp: 'json_callback',
                url:"http://"+URL+":8888/location/update-bus",
                data:{
                    'latitude':latitude,
                    'longitude':longitude,
                    'deviceId':"27762",
                    'previousDistance':previousDistance
                },
                success: function(json) {
                    var animation = json.data.showAnimation;
                   // previousDistance = data.data.previousDistance;
                    actualStop = json.data.stopName;
                    nextStop = json.data.nextStop;
                    previousStop = json.data.previousStop;
                   // alert("El animation es" +animation);

                    switch(animation){
                        case 0:
                            document.getElementById('container').style.display = "none";
                            break;
                        case 1:
                            document.getElementById('container').style.display = "block";
                            setAnimations(false,true,true);
                            setData("Siguiente Parada:", actualStop);
                            break;
                        case 2:
                            document.getElementById('container').style.display = "block";
                            setAnimations(true,false,true);
                            setData("Parada Actual:", actualStop);
                            break;
                        case 3:
                            document.getElementById('container').style.display = "block";
                            setAnimations(true,true,false);
                            setData("Siguiente Parada:", nextStop);
                            break;
                        case 4:
                            document.getElementById('container').style.display = "block";
                            break;
                        case 5:
                            document.getElementById('container').style.display = "block";
                            break;
                        default:
                            break;

                    }

                //data.data.showAnimation int de 1 a 5
                //data.data.previousDistance me lo tengo que guardar en una var
                //data.data.stopName la que estoy llegando
                //idem prevousStop y nextStop    

            },error: function(error){
                alert(error);
            }, // log algo error.message
            });
            
        }, 5000);

        document.getElementById('title').innerHTML = title;
        

     

        function setAnimations(first, second, third){
            document.getElementById('animation1').hidden = first;
            document.getElementById('animation2').hidden = second;
            document.getElementById('animation3').hidden = third;
        }

        function setData(stopState,mainStop){
            document.getElementById('topText').innerHTML = stopState;
            document.getElementById('bottomText').innerHTML = mainStop;
            document.getElementById('previousStop').innerHTML = previousStop;
            document.getElementById('actualStop').innerHTML = actualStop;
            document.getElementById('nextStop').innerHTML = nextStop;
        }
    });
    