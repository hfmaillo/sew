// MasInfoNavegador.js
// Informacion de navegador
// Version 1.0. 03/11/2020. Hector Fernandez Maillo. Universidad de Oviedo
document.getElementsByTagName("p")[0].innerHTML = "Versión: ";
document.write(navegador.version);
document.write("</p>");
document.write("<p>Plataforma: ");
document.write(navegador.plataforma);
document.write("</p>");
document.write("<p>Vendedor: ");
document.write(navegador.vendedor);
document.write("</p>");
document.write("<p>Agente: ");
document.write(navegador.agente);
document.write("</p>");
document.write("<p>Java activo: ");
document.write(navegador.javaActivo);
