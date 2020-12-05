// CalculadoraCientifica.js
// Calculadora cientifica
// Version 1.0. 03/11/2020. Hector Fernandez Maillo. Universidad de Oviedo
"use strict";
class CalculadoraBasica {

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
class CalculadoraCientifica extends CalculadoraBasica {

    pi() {
        this.appendPantalla("Math.PI");
    }

    e() {
        this.appendPantalla("Math.E");
    }

    seno() {
        this.appendPantalla("Math.sin(");
    }

    coseno() {
        this.appendPantalla("Math.cos(");
    }

    tangente() {
        this.appendPantalla("Math.tan(");
    }

    pIzquierdo() {
        this.appendPantalla("(");
    }

    pDerecho() {
        this.appendPantalla(")");
    }

    arcoseno() {
        this.appendPantalla("Math.asin(");
    }

    arcocoseno() {
        this.appendPantalla("Math.acos(");
    }

    arcotangente() {
        this.appendPantalla("Math.atan(");
    }

    raiz() {
        this.appendPantalla("Math.sqrt(");
    }

    potencia() {
        this.appendPantalla("Math.pow(");
    }

    logaritmo() {
        this.appendPantalla("Math.log10(");
    }

    lNatural() {
        this.appendPantalla("Math.log(");
    }

    coma() {
        this.appendPantalla(",");
    }

}
var calculadora = new CalculadoraCientifica();
