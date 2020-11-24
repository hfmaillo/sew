// Ejercicio7.js
// Los Goonies
// Version 1.0. 10/11/2020. Hector Fernandez Maillo. Universidad de Oviedo
"use strict";
class Pelicula { 

    constructor () { 
    }

    ocultar() {
        $(":header").hide();
        $("p").hide();
    }

    mostrar() {
        $(":header").show();
        $("p").show();
    }

    modificar() {
        $("p:first").css({left:0, backgroundColor:'white'});
        $("h2").text("Recaudación y Estreno");
    }

    añadir() {
        if ($("section:eq(1)").attr("id") == undefined) {
            $("section:first").after("<section id=\"musica\"><p id=\"before\">El tema principal de la película es «The Goonies 'R' Good Enough», interpretado por la cantante estadounidense <a href=\"https://es.wikipedia.org/wiki/Cyndi_Lauper\">Cyndi Lauper</a>. En el single de la canción se incluyó también el tema «What a Thrill», que igualmente aparece en el largometraje.</p></section>");
            $("#before").before("<h2>Música</h2>");
        }
    }

    eliminar() {
        $("#musica").remove();
    }

    recorrer() {
        $("*", document.body).each(function() {
            var etiquetaPadre = $(this).parent().get(0).tagName;
            $(this).prepend(document.createTextNode("Etiqueta padre : <"  + etiquetaPadre + "> elemento : <" + $(this).get(0).tagName +"> valor: "));
        });
    }

    sumar() {
        if ($.trim($("table + p").text()).length == 0) {
            var filas = 0;
            $("table tr").each(function() {
                filas++;
            });

            var columnas = 0;
            $("table th").each(function() {
                columnas++;
            });

            $("table").after("<p>La tabla tiene " + filas + " filas + " + columnas + " columnas = " + (filas + columnas) + "</p>");
        }
    }

}
var pelicula = new Pelicula();
