// CalculadoraBasica.js
// Calculadora basica
// Version 1.0. 03/11/2020. Hector Fernandez Maillo. Universidad de Oviedo
"use strict";
class Calculadora {

    constructor() {
        this.pantalla = "";
        this.memoria = 0.0;
    }

    digitos(digito) {
        this.pantalla += digito;
        document.getElementById("pantalla").value = this.pantalla;
    }

    punto() {
        this.pantalla += ".";
        document.getElementById("pantalla").value = this.pantalla;
    }

    suma() {
        this.pantalla += "+";
        document.getElementById("pantalla").value = this.pantalla;
    }

    resta() {
        this.pantalla += "-";
        document.getElementById("pantalla").value = this.pantalla;
    }

    multiplicacion() {
        this.pantalla += "*";
        document.getElementById("pantalla").value = this.pantalla;
    }

    division() {
        this.pantalla += "/";
        document.getElementById("pantalla").value = this.pantalla;
    }

    mrc() {
        this.pantalla = this.memoria.toString();
        document.getElementById("pantalla").value = this.pantalla;
    }

    mMenos() {
        this.igual();
        try {
            this.memoria -= parseFloat(this.pantalla);
        }
        catch(err) {
            this.memoria -= 0.0;
        }
    }

    mMas() {
        this.igual();
        try {
            this.memoria += parseFloat(this.pantalla);
        }
        catch(err) {
            this.memoria += 0.0;
        }
    }

    borrar() {
        this.pantalla = "";
        document.getElementById("pantalla").value = this.pantalla;
    }

    igual() {
        try {
            this.pantalla = eval(this.pantalla).toString();
        }
        catch(err) {
            this.pantalla = "Error = " + err;
        }
        document.getElementById("pantalla").value = this.pantalla;
    }

}
var calculadora = new Calculadora();
