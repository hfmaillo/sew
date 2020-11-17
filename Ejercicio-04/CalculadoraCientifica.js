// CalculadoraCientifica.js
// Calculadora cientifica
// Version 1.0. 03/11/2020. Hector Fernandez Maillo. Universidad de Oviedo
"use strict";
class CalculadoraBasica {

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
        this.pantalla = this.memoria;
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
            this.pantalla = eval(this.pantalla);
        }
        catch(err) {
            this.pantalla = "Error = " + err;
        }
        document.getElementById("pantalla").value = this.pantalla;
    }

}
class CalculadoraCientifica extends CalculadoraBasica {

    pi() {
        this.pantalla += Math.PI;
        document.getElementById("pantalla").value = this.pantalla;
    }

    seno() {
        this.pantalla += Math.PI;
        document.getElementById("pantalla").value = this.pantalla;
    }

    coseno() {
        this.pantalla += Math.PI;
        document.getElementById("pantalla").value = this.pantalla;
    }

    tangente() {
        this.pantalla += Math.PI;
        document.getElementById("pantalla").value = this.pantalla;
    }

    arcoSeno() {
        this.pantalla += Math.PI;
        document.getElementById("pantalla").value = this.pantalla;
    }

    arcoCoseno() {
        this.pantalla += Math.PI;
        document.getElementById("pantalla").value = this.pantalla;
    }

    arcoTangente() {
        this.pantalla += Math.PI;
        document.getElementById("pantalla").value = this.pantalla;
    }

    e() {
        this.pantalla += Math.PI;
        document.getElementById("pantalla").value = this.pantalla;
    }

    log() {
        this.pantalla += Math.PI;
        document.getElementById("pantalla").value = this.pantalla;
    }

    exp() {
        this.pantalla += Math.PI;
        document.getElementById("pantalla").value = this.pantalla;
    }

    pow() {
        this.pantalla += Math.PI;
        document.getElementById("pantalla").value = this.pantalla;
    }

    random() {
        this.pantalla += Math.PI;
        document.getElementById("pantalla").value = this.pantalla;
    }

}
var calculadora = new CalculadoraCientifica();
