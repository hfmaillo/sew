// Ejercicio10.js
// Ejercicio 10
// Version 1.0. 17/11/2020. Hector Fernandez Maillo. Universidad de Oviedo
"use strict";
class Moneda { 

    constructor () {
        this.apikey = "5859555379feb1d0967bd391c16a71eb";
        this.currencies = "&currencies=USD,EUR,JPY,GBP,AUD,CHF";
        this.format = "&format=1";
        this.url = "http://api.currencylayer.com/live?access_key=" + this.apikey + this.currencies + this.format;
    }

    cargarCambio() {
        var self = this;

        $.ajax({
            dataType: "json",
            url: this.url,
            method: 'GET',
            success: function(datos) {
                self.usd = datos.quotes.USDUSD;
                self.eur = datos.quotes.USDEUR;
                self.jpy = datos.quotes.USDJPY;
                self.gbp = datos.quotes.USDGBP;
                self.aud = datos.quotes.USDAUD;
                self.chf = datos.quotes.USDCHF;

                $("#USDUSD").val(self.usd);
                $("#USDEUR").val(self.eur);
                $("#USDJPY").val(self.jpy);
                $("#USDGBP").val(self.gbp);
                $("#USDAUD").val(self.aud);
                $("#USDCHF").val(self.chf);
                },
            error: function() {
                var stringError = "<p>¡Tenemos problemas! No puedo obtener JSON de <a href='https://currencylayer.com/'>CurrencyLayer</a></p>"
                
                $("section").remove();
                $("article").append(stringError);
                }
        });
    }

    seleccionar(moneda) {
        $("input[type='text']").each(function() {
            $(this).attr("disabled", $(this).attr("id") != moneda)
        });
    }

    convertir() {
        var valor = parseFloat($("input[type='text']:enabled").val());

        if (!isNaN(valor)) {
            switch ($("input[type='text']:enabled").attr("id")) {
                case "USDUSD":
                    valor /= this.usd;
                    break;
                case "USDEUR":
                    valor /= this.eur;
                    break;
                case "USDJPY":
                    valor /= this.jpy;
                    break;
                case "USDGBP":
                    valor /= this.gbp;
                    break;
                case "USDAUD":
                    valor /= this.aud;
                    break;
                case "USDCHF":
                    valor /= this.chf;
                    break;
            }

            $("#USDUSD").val(this.usd * valor);
            $("#USDEUR").val(this.eur * valor);
            $("#USDJPY").val(this.jpy * valor);
            $("#USDGBP").val(this.gbp * valor);
            $("#USDAUD").val(this.aud * valor);
            $("#USDCHF").val(this.chf * valor);
        }
    }

}
var moneda = new Moneda();
