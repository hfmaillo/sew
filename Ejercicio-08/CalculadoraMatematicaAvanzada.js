// CalculadoraMatematicaAvanzada.js
// Calculadora matematica avanzada
// Version 1.0. 10/11/2020. Hector Fernandez Maillo. Universidad de Oviedo
"use strict";
class Mapa { 

    constructor () { 
        this.mapa = new Map();
    }

    insertar(clave, valor) {
        this.mapa.set(clave, valor);
    }

    obtener(clave) {
        return this.mapa.get(clave);
    }

    tamaño() {
        return this.mapa.size;
    }

    existe(clave) {
        return this.mapa.has(clave);
    }

}
class CalculadoraMatematicaAvanzada {

    constructor() {
        this.derivadas = new Mapa();
        this.loadDerivadas();
    }

    loadDerivadas() {
        this.derivadas.insertar("x^2", "2*x");
        this.derivadas.insertar("x", "1");
    }

    derivada() {
        var str = document.getElementById('expresion').value;
        // var expresionRegular = new RegExp('\s*+\s*');
        var array = str.split("+");
        
        var result = "";
        for (var i = 0; i < array.length; i++) {
            if (this.derivadas.existe(array[i])) {
                if (result.length != 0) {
                    result += "+";
                }

                result += this.derivadas.obtener(array[i]);
            } else if (isNaN(parseFloat(array[i]))) {
                result = "Error";
                break;
            }
        }

        document.getElementById('resultado').value = result;
    }

}
var calculadora = new CalculadoraMatematicaAvanzada();
