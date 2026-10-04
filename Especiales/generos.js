/* Tabla auxiliar parametrizable: géneros de libros (equivale a la "familia de artículos").
   Es una variable de TEXTO con sintaxis JSON; más adelante este texto lo va a devolver el servidor.
   Los "+" y las comillas simples son solo para escribir el texto en varias líneas. */
var textoJSONGeneros = '{"generos": ' +
'[' +
'{"codGenero":"NOV","descripcionGenero":"Novela"},' +
'{"codGenero":"CIF","descripcionGenero":"Ciencia ficción"},' +
'{"codGenero":"POL","descripcionGenero":"Policial y misterio"},' +
'{"codGenero":"FAN","descripcionGenero":"Fantasía"},' +
'{"codGenero":"HIS","descripcionGenero":"Historia"},' +
'{"codGenero":"POE","descripcionGenero":"Poesía"},' +
'{"codGenero":"INF","descripcionGenero":"Literatura infantil"},' +
'{"codGenero":"TEC","descripcionGenero":"Técnicos e informática"}' +
']' +
'}';
