// MapaGeoJSON.js
// MapaGeoJSON
// Version 1.0. 24/11/2020. Hector Fernandez Maillo. Universidad de Oviedo
"use strict";
class MapaGeoJSON {

    comprobarSoporteApi() {
        if (window.File && window.FileReader && window.FileList && window.Blob) {  
            // El navegador soporta el API File
            $("h1").after("<p>Este navegador soporta el API File</p>");
        } else {
            $("h1").after("<p>¡¡¡ Este navegador NO soporta el API File y este programa puede no funcionar correctamente !!!</p>");
        }
    }

    cargarArchivo() {
        var archivos = document.getElementById("subirArchivo").files;

        if (archivos.length > 0) {
            var archivo = archivos[0];
            var nombre = archivo.name.split(".");
            
            if (nombre[nombre.length - 1] == "GeoJSON") {
                this.crearMapa();
                this.mostrarGeoJSON(archivo);
            } else {
                $("div").html("");
            }
        } else {
            $("div").html("");
        }
    }

    crearMapa() {
        var madrid = {lat: 40.4378698, lng: -3.8196212};
        this.mapa = new google.maps.Map(document.getElementById('mapa'), {zoom: 6, center: madrid});
    }

    mostrarGeoJSON(archivo) {
        var self = this;

        var lector = new FileReader();
        lector.onload = function (evento) {
            var geojson = JSON.parse(lector.result);           
            self.mapa.data.addGeoJson(geojson);
        }      
        lector.readAsText(archivo);
    }

}
var mapa = new MapaGeoJSON();
