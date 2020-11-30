// CalculadoraMatematicaAvanzada.js
// Calculadora matematica avanzada
// Version 1.0. 10/11/2020. Hector Fernandez Maillo. Universidad de Oviedo
"use strict";
class PilaLIFO { 

    constructor () { 
        this.pila = new Array();
    }

    apilar(valor) {
        this.pila.push(valor);
    }

    desapilar() {
        return this.pila.pop();
    }

    longitud() {
        return this.pila.length;
    }

    mostrar() {
        var stringPila = "<h3 hidden>Pila</h3>" + "<ol>";
        
        for (var i = this.longitud() - 1; i >= 0; i--) {
            stringPila += "<li>" + this.pila[i] + "</li>";
        }

        stringPila += "</ol>";
        return stringPila;
    }

}
class CalculadoraRPN {

    constructor() {
        this.pantalla = "";
        this.pila = new PilaLIFO();
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

    operacion(operador) {
        var numOperandos = operador.length;

        if (this.pila.longitud() >= numOperandos) {
            var operacion;
            if (numOperandos == 1) {
                var v = this.pila.desapilar();
                operacion = operador(v);
            } else { // numOperandos == 2
                var v2 = this.pila.desapilar();
                var v1 = this.pila.desapilar();
                operacion = operador(v1, v2);
            }

            this.pila.apilar(operacion);
            document.getElementById("pila").innerHTML = this.pila.mostrar();
        }
    }

    suma() {
        this.operacion((v1, v2) => v1 + v2);
    }

    resta() {
        this.operacion((v1, v2) => v1 - v2);
    }

    multiplicacion() {
        this.operacion((v1, v2) => v1 * v2);
    }

    division() {
        this.operacion((v1, v2) => v1 / v2);
    }

    borrar() {
        this.pantalla = "";
        document.getElementById("pantalla").value = this.pantalla;
    }

    enter() {
        var valor = parseFloat(this.pantalla);
        if (!isNaN(valor)) {
            this.borrar();
            this.pila.apilar(valor);
            document.getElementById("pila").innerHTML = this.pila.mostrar();
        }
    }
    
    pi() {
        this.appendPantalla(Math.PI);
    }

    e() {
        this.appendPantalla(Math.E);
    }

    seno() {
        this.operacion(Math.sin);
    }

    coseno() {
        this.operacion(Math.cos);
    }

    tangente() {
        this.operacion(Math.tan);
    }

    arcoseno() {
        this.operacion(Math.asin);
    }

    arcocoseno() {
        this.operacion(Math.acos);
    }

    arcotangente() {
        this.operacion(Math.atan);
    }

    raiz() {
        this.operacion(Math.sqrt);
    }

    potencia() {
        this.operacion(Math.pow);
    }

    logaritmo() {
        this.operacion(Math.log10);
    }

    lNatural() {
        this.operacion(Math.log);
    }

    masMenos() {
        if (this.pantalla.substring(0, 1) != "-") {
            this.pantalla = "-" + this.pantalla;
        } else {
            this.pantalla = this.pantalla.substring(1);
        }
        document.getElementById("pantalla").value = this.pantalla;
    }

}
class CalculadoraMatematicaAvanzada extends CalculadoraRPN {

    vAbsoluto() {
        this.operacion(Math.abs);
    }

    hipotenusa() {
        this.operacion(Math.hypot);
    }

    rCubica() {
        this.operacion(Math.cbrt);
    }

    lNaturalMasUno() {
        this.operacion(Math.log1p);
    }

    sHiperbolico() {
        this.operacion(Math.sinh);
    }

    cHiperbolico() {
        this.operacion(Math.cosh);
    }

    tHiperbolica() {
        this.operacion(Math.tanh);
    }

    pDos() {
        this.operacion(v => Math.pow(2, v));
    }

    lBinario() {
        this.operacion(Math.log2);
    }

    pDiez() {
        this.operacion(v => Math.pow(10, v));
    }

    exponente() {
        this.operacion(Math.exp);
    }

    random() {
        this.appendPantalla(Math.random());
    }

}
var calculadora = new CalculadoraMatematicaAvanzada();
