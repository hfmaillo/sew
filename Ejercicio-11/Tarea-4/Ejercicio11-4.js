// Ejercicio11-4.js
// Ejercicio 11-4
// Version 1.0. 17/11/2020. Hector Fernandez Maillo. Universidad de Oviedo
var mapaDinamicoGoogle = new Object();
function initMap() {
    var gijon = {lat: 43.5314231, lng: -5.703474};
    var mapaGijon = new google.maps.Map(document.getElementById('mapa'),{zoom: 8,center:gijon});
    var marcador = new google.maps.Marker({position:gijon,map:mapaGijon});
}
mapaDinamicoGoogle.initMap = initMap;
