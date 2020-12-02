// MapaKML.js
// MapaKML
// Version 1.0. 24/11/2020. Hector Fernandez Maillo. Universidad de Oviedo
"use strict";
class MapaKML {

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
            
            if (nombre[nombre.length - 1] == "kml") {
                this.crearMapa();
                this.mostrarKML(archivo);
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

    mostrarKML(archivo) {
        var self = this;

        var lector = new FileReader();
        lector.onload = function (evento) {
            var xml = $(lector.result);           

            $("Placemark", xml).each(function () {
                var coordenadas = $('coordinates', $(this))[0].childNodes[0].data;
                var puntos = coordenadas.split("\n");
                var ruta = new Array();

                for (var i = 0; i < puntos.length; i++) {
                    var punto = puntos[i].split(",");
                    if (punto.length >= 2) {
                        var p = {
                            lat: parseFloat(punto[1]),
                            lng: parseFloat(punto[0])
                        };
                        ruta.push(p);
                    }
                }

                var polyline = new google.maps.Polyline({
                    path: ruta,
                    geodesic: true,
                    map: self.mapa
                });
            })
        }      
        lector.readAsText(archivo);
    }

}
var mapa = new MapaKML();
