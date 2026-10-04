/* Datos de ejemplo del maestro de libros (equivalen al "articulos.json" del profe).
   Es una variable de TEXTO con sintaxis JSON; más adelante este texto lo va a devolver el servidor.
   El campo codGenero tiene que existir en la tabla auxiliar de géneros (generos.js).
   Los "+" y las comillas simples son solo para escribir el texto en varias líneas. */
var textoJSONLibros = '{"libros": ' +
'[' +
'{"codLibro":"LIB-0001","codGenero":"NOV","titulo":"Rayuela","fechaAlta":"2020-06-15","ejemplares":233},' +
'{"codLibro":"LIB-0002","codGenero":"NOV","titulo":"Pedro Páramo","fechaAlta":"2020-06-15","ejemplares":400},' +
'{"codLibro":"LIB-0003","codGenero":"CIF","titulo":"Fahrenheit 451","fechaAlta":"2020-02-01","ejemplares":180},' +
'{"codLibro":"LIB-0004","codGenero":"CIF","titulo":"Dune","fechaAlta":"2020-06-15","ejemplares":301},' +
'{"codLibro":"LIB-0005","codGenero":"POL","titulo":"El nombre de la rosa","fechaAlta":"2020-06-15","ejemplares":201},' +
'{"codLibro":"LIB-0006","codGenero":"POL","titulo":"Asesinato en el Orient Express","fechaAlta":"2020-02-02","ejemplares":86},' +
'{"codLibro":"LIB-0007","codGenero":"FAN","titulo":"El Hobbit","fechaAlta":"2020-06-24","ejemplares":555},' +
'{"codLibro":"LIB-0008","codGenero":"FAN","titulo":"Harry Potter y la piedra filosofal","fechaAlta":"2020-02-02","ejemplares":275},' +
'{"codLibro":"LIB-0009","codGenero":"HIS","titulo":"Sapiens: de animales a dioses","fechaAlta":"2020-02-02","ejemplares":275},' +
'{"codLibro":"LIB-0010","codGenero":"HIS","titulo":"Las venas abiertas de América Latina","fechaAlta":"2021-03-10","ejemplares":120},' +
'{"codLibro":"LIB-0011","codGenero":"POE","titulo":"Veinte poemas de amor y una canción desesperada","fechaAlta":"2021-03-12","ejemplares":95},' +
'{"codLibro":"LIB-0012","codGenero":"INF","titulo":"El Principito","fechaAlta":"2021-05-20","ejemplares":410},' +
'{"codLibro":"LIB-0013","codGenero":"INF","titulo":"Matilda","fechaAlta":"2021-05-20","ejemplares":150},' +
'{"codLibro":"LIB-0014","codGenero":"TEC","titulo":"Clean Code","fechaAlta":"2022-01-18","ejemplares":60},' +
'{"codLibro":"LIB-0015","codGenero":"TEC","titulo":"Eloquent JavaScript","fechaAlta":"2022-01-18","ejemplares":45}' +
']' +
'}';
