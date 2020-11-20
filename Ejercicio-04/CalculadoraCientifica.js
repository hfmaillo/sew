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
        this.pantalla = this.memoria.toString();
        document.getElementById("pantalla").value = this.pantalla;
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
class CalculadoraCientifica extends CalculadoraBasica {

    pi() {
        this.pantalla += "Math.PI";
        document.getElementById("pantalla").value = this.pantalla;
    }

    e() {
        this.pantalla += "Math.E";
        document.getElementById("pantalla").value = this.pantalla;
    }

    seno() {
        this.pantalla += "Math.sin(";
        document.getElementById("pantalla").value = this.pantalla;
    }

    coseno() {
        this.pantalla += "Math.cos(";
        document.getElementById("pantalla").value = this.pantalla;
    }

    tangente() {
        this.pantalla += "Math.tan(";
        document.getElementById("pantalla").value = this.pantalla;
    }

    pIzquierdo() {
        this.pantalla += "(";
        document.getElementById("pantalla").value = this.pantalla;
    }

    pDerecho() {
        this.pantalla += ")";
        document.getElementById("pantalla").value = this.pantalla;
    }

    arcoseno() {
        this.pantalla += "Math.asin(";
        document.getElementById("pantalla").value = this.pantalla;
    }

    arcocoseno() {
        this.pantalla += "Math.acos(";
        document.getElementById("pantalla").value = this.pantalla;
    }

    arcotangente() {
        this.pantalla += "Math.atan(";
        document.getElementById("pantalla").value = this.pantalla;
    }

    raiz() {
        this.pantalla += "Math.sqrt(";
        document.getElementById("pantalla").value = this.pantalla;
    }

    potencia() {
        this.pantalla += "Math.pow(";
        document.getElementById("pantalla").value = this.pantalla;
    }

    logaritmo() {
        this.pantalla += "Math.log10(";
        document.getElementById("pantalla").value = this.pantalla;
    }

    lNatural() {
        this.pantalla += "Math.log(";
        document.getElementById("pantalla").value = this.pantalla;
    }

    coma() {
        this.pantalla += ",";
        document.getElementById("pantalla").value = this.pantalla;
    }

}
var calculadora = new CalculadoraCientifica();
