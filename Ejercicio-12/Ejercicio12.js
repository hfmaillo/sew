// Ejercicio12.js
// Ejercicio 12
// Version 1.0. 17/11/2020. Hector Fernandez Maillo. Universidad de Oviedo
"use strict";
class File {

    comprobarSoporteApi() {
        if (window.File && window.FileReader && window.FileList && window.Blob) {  
            // El navegador soporta el API File
            $("h1").after("<p>Este navegador soporta el API File</p>");
        } else {
            $("h1").after("<p>¡¡¡ Este navegador NO soporta el API File y este programa puede no funcionar correctamente !!!</p>");
        }
    }

    cargarArchivos() {
        $("section").remove();

        var archivos = document.getElementById("subirArchivos").files;

        for (var i = 0; i < archivos.length; i++) {
            var archivo = archivos[i];
            this.mostrarArchivo(archivo);
        }
    }

    mostrarArchivo(archivo) {
        var section = document.createElement("section");

        var h2 = document.createElement("h2");
        h2.innerHTML = archivo.name;
        $(section).append(h2);

        var stringPropiedades = "<ul><li>Tamaño: " + archivo.size + " bytes</li>";
            stringPropiedades += "<li>Tipo: " + archivo.type + "</li>";
            stringPropiedades += "<li>Fecha de la última modificación: " + archivo.lastModifiedDate + "</li>";
        
        var tipoTexto = /text.*/;
        var tipoJson = /application.json/;
        if (archivo.type.match(tipoTexto) || archivo.type.match(tipoJson)) {
            stringPropiedades += "<li>Contenido:</li></ul>";
            var lector = new FileReader();
            lector.onload = function (evento) {
                // El evento "onload" se lleva a cabo cada vez que se completa con éxito una operación de lectura
                // La propiedad "result" es donde se almacena el contenido del archivo
                // Esta propiedad solamente es válida cuando se termina la operación de lectura
                var pre = document.createElement("pre");
                pre.innerText = lector.result;
                $(section).append(stringPropiedades);
                $(section).append(pre);
                $("article").append(section);
            }      
            lector.readAsText(archivo);
        } else {
            stringPropiedades += "</ul>";
            $(section).append(stringPropiedades);
            $("article").append(section);
        }
    }

}
var file = new File();
