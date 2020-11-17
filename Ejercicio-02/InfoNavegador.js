// InfoNavegador.js
// Informacion de navegador
// Version 1.0. 03/11/2020. Hector Fernandez Maillo. Universidad de Oviedo
var navegador = new Object();
navegador.nombre = navigator.appName;
navegador.idioma = navigator.language;
navegador.version = navigator.appVersion;
navegador.plataforma = navigator.platform;
navegador.vendedor = navigator.vendor;
navegador.agente = navigator.userAgent;
navegador.javaActivo = navigator.javaEnabled();
