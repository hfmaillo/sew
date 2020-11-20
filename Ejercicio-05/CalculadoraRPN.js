// CalculadoraRPN.js
// Calculadora RPN
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
        return (this.pila.pop());
    }

    longitud() {
        return (this.pila.length);
    }

    mostrar() {
        var stringPila = "<h3 hidden>Pila</h3>" + "<ol>";
        for (var i = this.longitud() - 1; i >= 0; i--) stringPila += "<li>" + this.pila[i] + "</li>";
        stringPila += "</ol>";
        return stringPila;
    }

}
class CalculadoraRPN {

    constructor() {
        this.pantalla = "";
        this.pila = new PilaLIFO();
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
        if (this.pila.longitud() >= 2) {
            var v2 = this.pila.desapilar();
            var v1 = this.pila.desapilar();
            var suma = v1 + v2;
            this.pila.apilar(suma);
            document.getElementById("pila").innerHTML = this.pila.mostrar();
        }
    }

    resta() {
        if (this.pila.longitud() >= 2) {
            var v2 = this.pila.desapilar();
            var v1 = this.pila.desapilar();
            var resta = v1 - v2;
            this.pila.apilar(resta);
            document.getElementById("pila").innerHTML = this.pila.mostrar();
        }
    }

    multiplicacion() {
        if (this.pila.longitud() >= 2) {
            var v2 = this.pila.desapilar();
            var v1 = this.pila.desapilar();
            var multiplicacion = v1 * v2;
            this.pila.apilar(multiplicacion);
            document.getElementById("pila").innerHTML = this.pila.mostrar();
        }
    }

    division() {
        if (this.pila.longitud() >= 2) {
            var v2 = this.pila.desapilar();
            var v1 = this.pila.desapilar();
            var division = v1 / v2;
            this.pila.apilar(division);
            document.getElementById("pila").innerHTML = this.pila.mostrar();
        }
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
        this.pantalla += Math.PI;
        document.getElementById("pantalla").value = this.pantalla;
    }

    e() {
        this.pantalla += Math.E;
        document.getElementById("pantalla").value = this.pantalla;
    }

    seno() {
        if (this.pila.longitud() >= 1) {
            var valor = this.pila.desapilar();
            var seno = Math.sin(valor);
            this.pila.apilar(seno);
            document.getElementById("pila").innerHTML = this.pila.mostrar();
        }
    }

    coseno() {
        if (this.pila.longitud() >= 1) {
            var valor = this.pila.desapilar();
            var coseno = Math.cos(valor);
            this.pila.apilar(coseno);
            document.getElementById("pila").innerHTML = this.pila.mostrar();
        }
    }

    tangente() {
        if (this.pila.longitud() >= 1) {
            var valor = this.pila.desapilar();
            var tangente = Math.tan(valor);
            this.pila.apilar(tangente);
            document.getElementById("pila").innerHTML = this.pila.mostrar();
        }
    }

    arcoseno() {
        if (this.pila.longitud() >= 1) {
            var valor = this.pila.desapilar();
            var arcoseno = Math.asin(valor);
            this.pila.apilar(arcoseno);
            document.getElementById("pila").innerHTML = this.pila.mostrar();
        }
    }

    arcocoseno() {
        if (this.pila.longitud() >= 1) {
            var valor = this.pila.desapilar();
            var arcocoseno = Math.acos(valor);
            this.pila.apilar(arcocoseno);
            document.getElementById("pila").innerHTML = this.pila.mostrar();
        }
    }

    arcotangente() {
        if (this.pila.longitud() >= 1) {
            var valor = this.pila.desapilar();
            var arcotangente = Math.atan(valor);
            this.pila.apilar(arcotangente);
            document.getElementById("pila").innerHTML = this.pila.mostrar();
        }
    }

    raiz() {
        if (this.pila.longitud() >= 1) {
            var valor = this.pila.desapilar();
            var raiz = Math.sqrt(valor);
            this.pila.apilar(raiz);
            document.getElementById("pila").innerHTML = this.pila.mostrar();
        }
    }

    potencia() {
        if (this.pila.longitud() >= 2) {
            var v2 = this.pila.desapilar();
            var v1 = this.pila.desapilar();
            var potencia = Math.pow(v1, v2);
            this.pila.apilar(potencia);
            document.getElementById("pila").innerHTML = this.pila.mostrar();
        }
    }

    logaritmo() {
        if (this.pila.longitud() >= 1) {
            var valor = this.pila.desapilar();
            var logaritmo = Math.log10(valor);
            this.pila.apilar(logaritmo);
            document.getElementById("pila").innerHTML = this.pila.mostrar();
        }
    }

    lNatural() {
        if (this.pila.longitud() >= 1) {
            var valor = this.pila.desapilar();
            var lNatural = Math.log(valor);
            this.pila.apilar(lNatural);
            document.getElementById("pila").innerHTML = this.pila.mostrar();
        }
    }

    masMenos() {
        if (this.pantalla.substring(0, 1) != "-") {
            this.pantalla = "-" + this.pantalla;
        }
        else {
            this.pantalla = this.pantalla.substring(1);
        }
        document.getElementById("pantalla").value = this.pantalla;
    }

}
var calculadora = new CalculadoraRPN();
