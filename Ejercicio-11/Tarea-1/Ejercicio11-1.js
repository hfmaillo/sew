// Ejercicio11.js
// Ejercicio 11
// Version 1.0. 17/11/2020. Hector Fernandez Maillo. Universidad de Oviedo
"use strict";
class GeoLocalizacion { 

    constructor () {
        navigator.geolocation.getCurrentPosition(this.getPosicion.bind(this));
    }

    getPosicion(posicion) {
        this.longitud         = posicion.coords.longitude; 
        this.latitud          = posicion.coords.latitude;  
        this.precision        = posicion.coords.accuracy;
        this.altitud          = posicion.coords.altitude;
        this.precisionAltitud = posicion.coords.altitudeAccuracy;
        this.rumbo            = posicion.coords.heading;
        this.velocidad        = posicion.coords.speed;       
    }

    getLongitud() {
        return this.longitud;
    }

    getLatitud() {
        return this.latitud;
    }

    getAltitud() {
        return this.altitud;
    }

    verTodo(dondeVerlo) {        
        $("input[type='button']").remove();
        var ubicacion = $("#" + dondeVerlo);
        var datos = '<ul>'; 
        datos += '<li>Longitud: '+this.longitud +' grados</li>'; 
        datos += '<li>Latitud: '+this.latitud +' grados</li>';
        datos += '<li>Precisión de la latitud y longitud: '+ this.precision +' metros</li>';
        datos += '<li>Altitud: '+ this.altitude +' metros</li>';
        datos += '<li>Precisión de la altitud: '+ this.precisionAltitud +' metros</li>'; 
        datos += '<li>Rumbo: '+ this.rumbo +' grados</li>'; 
        datos += '<li>Velocidad: '+ this.velocidad +' metros/segundo</li>';
        datos += '</ul>';
        ubicacion.append(datos);
    }

}
var geo = new GeoLocalizacion();
