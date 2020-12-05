// CalculadoraBasica.js
// Calculadora basica
// Version 1.0. 03/11/2020. Hector Fernandez Maillo. Universidad de Oviedo
"use strict";
class Calculadora {

    constructor() {
        this.pantalla = "";
        this.memoria = 0.0;
    }

    appendPantalla(toAppend) {
        this.pantalla += toAppend;
        document.getElementById("pantalla").value = this.pantalla;
    }

    digitos(digito) {
        this.appendPantalla(digito);
    }

    punto() {
        this.appendPantalla(".");
    }

    suma() {
        this.appendPantalla("+");
    }

    resta() {
        this.appendPantalla("-");
    }

    multiplicacion() {
        this.appendPantalla("*");
    }

    division() {
        this.appendPantalla("/");
    }

    writePantalla(toWrite) {
        this.pantalla = toWrite;
        document.getElementById("pantalla").value = this.pantalla;
    }

    mrc() {
        this.writePantalla(this.memoria.toString());
    }

    mMenos() {
        this.igual();
        var valor = parseFloat(this.pantalla);
        if (!isNaN(valor)) {
            this.memoria -= valor;
        }
    }

    mMas() {
        this.igual();
        var valor = parseFloat(this.pantalla);
        if (!isNaN(valor)) {
            this.memoria += valor;
        }
    }

    borrar() {
        this.writePantalla("");
    }

    igual() {
        try {
            this.pantalla = eval(this.pantalla).toString();
        }
        catch (err) {
            this.pantalla = "Error = " + err;
        }
        document.getElementById("pantalla").value = this.pantalla;
    }

}
var calculadora = new Calculadora();
