// Ejercicio14.js
// Ejercicio14
// Version 1.0. 24/11/2020. Hector Fernandez Maillo. Universidad de Oviedo
"use strict";
class Distancia {

    constructor () {
        this.distUno = 111.3;
        navigator.geolocation.getCurrentPosition(this.getPosicion.bind(this), this.verErrores.bind(this));
    }

    getPosicion(posicion) {
        this.longitud = posicion.coords.longitude; 
        this.latitud  = posicion.coords.latitude;     
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

    comprobarSoporteApi() {
        if (window.File && window.FileReader && window.FileList && window.Blob) {  
            // El navegador soporta el API File
            $("h1 + p").after("<p>Este navegador soporta el API File</p>");
        } else {
            $("h1 + p").after("<p>¡¡¡ Este navegador NO soporta el API File y este programa puede no funcionar correctamente !!!</p>");
        }
    }

    cargarArchivo() {
        $("section").remove();

        var archivos = document.getElementById("subirArchivo").files;

        if (archivos.length > 0) {
            var archivo = archivos[0];
            var nombre = archivo.name.split(".");
            
            if (nombre[nombre.length - 1] == "json") {
                this.calcularDistancia(archivo);
            }
        }
    }

    calcularDistancia(archivo) {
        var self = this;

        var lector = new FileReader();
        lector.onload = function (evento) {
            var json = JSON.parse(lector.result);           
            self.lonJson = json.coord.lon;
            self.latJson = json.coord.lat;

            var distancia = Math.round(self.distUno * Math.hypot(self.longitud - self.lonJson, self.latitud - self.latJson));
            
            var section = document.createElement("section");

            var h3 = document.createElement("h3");
            h3.innerHTML = archivo.name;
            $(section).append(h3);

            var stringCoordenadas = "<ul><li>Coordenadas usuario:<ul><li>Longitud: ";
                stringCoordenadas += self.longitud;
                stringCoordenadas += " grados</li><li>Latitud: ";
                stringCoordenadas += self.latitud;
                stringCoordenadas += " grados</li></ul></li><li>Coordenadas punto:<ul><li>Longitud: ";
                stringCoordenadas += self.lonJson;
                stringCoordenadas += " grados</li><li>Latitud: ";
                stringCoordenadas += self.latJson;
                stringCoordenadas += " grados</li></ul></li></ul>";
            $(section).append(stringCoordenadas);

            if (!isNaN(distancia)) {
                var canvas = document.createElement("canvas");
                var canvas1 = canvas.getContext('2d');
                canvas1.font = 'italic 2.5em sans-serif';
                canvas1.strokeStyle = "rgba(167, 39, 11, 1)";
                canvas1.strokeText(distancia + " kilómetros", 5, 30);
                $(section).append(canvas);
            }

            $("article").append(section);
        }      
        lector.readAsText(archivo);
    }

}
var distancia = new Distancia();
