// Ejercicio8.js
// Ejercicio 8
// Version 1.0. 10/11/2020. Hector Fernandez Maillo. Universidad de Oviedo
"use strict";
class Meteo { 

    constructor () {
        this.apikey = "9764a06139e443bca27c766cfbabc533";
        this.codigoPais = "ES";
        this.unidades = "&units=metric";
        this.idioma = "&lang=es";
    }

    verJSON(ciudad){
        this.ciudad = ciudad;
        this.url = "https://api.openweathermap.org/data/2.5/weather?q=" + this.ciudad + "," + this.codigoPais + this.unidades + this.idioma + "&APPID=" + this.apikey;

        var article = document.createElement("article");
        $("footer").before(article);
        var h2 = document.createElement("h2");
        h2.innerHTML = this.ciudad;
        $(article).append(h2);

        $.ajax({
            dataType: "json",
            url: this.url,
            method: 'GET',
            success: function(datos) {
                //Presentación de los datos contenidos en JSON
                
                var stringIcono = "<img src='https://openweathermap.org/img/w/" + datos.weather[0].icon + ".png' alt='" + datos.weather[0].description + "' />";
                var stringDatos = "<ul><li>País: " + datos.sys.country + "</li>";
                    stringDatos += "<li>Latitud: " + datos.coord.lat + " grados</li>";
                    stringDatos += "<li>Longitud: " + datos.coord.lon + " grados</li>";
                    stringDatos += "<li>Temperatura: " + datos.main.temp + " grados Celsius</li>";
                    stringDatos += "<li>Temperatura máxima: " + datos.main.temp_max + " grados Celsius</li>";
                    stringDatos += "<li>Temperatura mínima: " + datos.main.temp_min + " grados Celsius</li>";
                    stringDatos += "<li>Presión: " + datos.main.pressure + " milibares</li>";
                    stringDatos += "<li>Humedad: " + datos.main.humidity + " %</li>";
                    stringDatos += "<li>Amanece a las: " + new Date(datos.sys.sunrise *1000).toLocaleTimeString() + "</li>";
                    stringDatos += "<li>Oscurece a las: " + new Date(datos.sys.sunset *1000).toLocaleTimeString() + "</li>";
                    stringDatos += "<li>Dirección del viento: " + datos.wind.deg + " grados</li>";
                    stringDatos += "<li>Velocidad del viento: " + datos.wind.speed + " metros/segundo</li>";
                    stringDatos += "<li>Hora de la medida: " + new Date(datos.dt *1000).toLocaleTimeString() + "</li>";
                    stringDatos += "<li>Fecha de la medida: " + new Date(datos.dt *1000).toLocaleDateString() + "</li>";
                    stringDatos += "<li>Descripción: " + datos.weather[0].description + "</li>";
                    stringDatos += "<li>Visibilidad: " + datos.visibility + " metros</li>";
                    stringDatos += "<li>Nubosidad: " + datos.clouds.all + " %</li></ul>";
                
                $(article).append(stringIcono);
                $(article).append(stringDatos);
                },
            error: function() {
                $(h2).html("¡Tenemos problemas! No puedo obtener JSON de <a href='https://openweathermap.org'>OpenWeatherMap</a>");
                }
        });
    }

}
var meteo = new Meteo();
