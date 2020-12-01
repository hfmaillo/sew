// Ejercicio11-3.js
// Ejercicio 11-3
// Version 1.0. 17/11/2020. Hector Fernandez Maillo. Universidad de Oviedo
"use strict";
class GeoLocalizacion { 

    constructor () {
        navigator.geolocation.getCurrentPosition(this.getPosicion.bind(this), this.verErrores.bind(this));
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

    verErrores(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                this.mensaje = "El usuario no permite la petición de geolocalización";
                break;
            case error.POSITION_UNAVAILABLE:
                this.mensaje = "Información de geolocalización no disponible";
                break;
            case error.TIMEOUT:
                this.mensaje = "La petición de geolocalización ha caducado";
                break;
            case error.UNKNOWN_ERROR:
                this.mensaje = "Se ha producido un error desconocido";
                break;
        }
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

    getMapaEstaticoGoogle(dondeVerlo) {
        $("input[type='button']").remove();
        var ubicacion = $("#" + dondeVerlo);       
        var apiKey = "&key=AIzaSyC6j4mF6blrc4kZ54S6vYZ2_FpMY9VzyRU";
        // URL: obligatoriamente https
        var url = "https://maps.googleapis.com/maps/api/staticmap?";
        // Parámetros
        // Centro del mapa (obligatorio si no hay marcadores)
        var centro = "center=" + this.latitud + "," + this.longitud;
        // Zoom (obligatorio si no hay marcadores)
        // Zoom: 1 (el mundo), 5 (continentes), 10 (ciudad), 15 (calles), 20 (edificios)
        var zoom ="&zoom=15";
        // Tamaño del mapa en pixeles (obligatorio)
        var tamaño= "&size=800x600";
        // Escala (opcional)
        // Formato (opcional): PNG,JPEG,GIF
        // Tipo de mapa (opcional)
        // Idioma (opcional)
        // Region (opcional)
        // Marcadores (opcional)
        var marcador = "&markers=color:red%7Clabel:S%7C" + this.latitud + "," + this.longitud;
        // Rutas. path (opcional)
        // Visible (optional)
        // Style (opcional)
        var sensor = "&sensor=false";        
        this.imagenMapa = url + centro + zoom + tamaño + marcador + sensor + apiKey;
        ubicacion.append("<img src='"+ this.imagenMapa +"' alt='Mapa estático'/>");
    }

}
var geo = new GeoLocalizacion();
