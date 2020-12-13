<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viajes autobús</title>
    <link rel="stylesheet" href="Ejercicio7.css" />
</head>

<body>
    <!-- Ejercicio 7. Versión 1.0. 15/12/2020. Héctor Fernández Maillo. Universidad de Oviedo -->
    <header>
        <h1>Viajes autobús</h1>
    </header>

    <?php
        /**
         * Definición de la clase BaseDatos
         */
        class BaseDatos {

            // Datos de la base de datos
            private const SERVERNAME = "localhost";
            private const USERNAME = "DBUSER2020";
            private const PASSWORD = "DBPSWD2020";
            private const DATABASE = "sew";

            public function ejecutar($titulo, $funcion, $database = TRUE) {
                echo "<h2>$titulo</h2>";

                // Conexión al SGBD local con XAMPP con el usuario creado
                if ($database === TRUE) {
                    $db = new mysqli(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DATABASE);
                } else {
                    $db = new mysqli(self::SERVERNAME, self::USERNAME, self::PASSWORD);
                }
                // Comprobamos conexión
                if ($db->connect_error) {
                    echo "<h3>ERROR de conexión: " .$db->connect_error. "</h3>";
                    exit();
                } else {
                    echo "<h3>Conexión establecida con " .$db->host_info. "</h3>";
                }

                $funcion($db);

                // Cerrar la conexión
                $db->close();
            }

            private function crearBaseDatos($db) {
                // Se crea la base de datos de trabajo "sew" utilizando ordenación en español
                $cadenaSQL = "CREATE DATABASE IF NOT EXISTS sew COLLATE utf8_spanish_ci";
                if ($db->query($cadenaSQL) === TRUE) {
                    echo "<p>Base de datos 'sew' creada con éxito.</p>";
                } else {
                    echo "<p>ERROR en la creación de la base de datos 'sew'. Error: " .$db->error. ".</p>";
                    exit();
                }
            }

            private function crearTablas($db) {
                // Crear la tabla "tarifa"
                $crearTablaTarifa = "CREATE TABLE IF NOT EXISTS tarifa (id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                                  tipo VARCHAR(255) NOT NULL,
                                  precio DOUBLE NOT NULL,
                                  PRIMARY KEY (id),
                                  UNIQUE (tipo))";
                self::crearTabla($db, $crearTablaTarifa, 'tarifa');

                // Crear la tabla "linea"
                $crearTablaLinea = "CREATE TABLE IF NOT EXISTS linea (id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                                 numero VARCHAR(3) NOT NULL,
                                 origen VARCHAR(255) NOT NULL,
                                 destino VARCHAR(255) NOT NULL,
                                 PRIMARY KEY (id),
                                 UNIQUE (numero))";
                self::crearTabla($db, $crearTablaLinea, 'linea');

                // Crear la tabla "viaje"
                $crearTablaViaje = "CREATE TABLE IF NOT EXISTS viaje (id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                                 fecha DATE NOT NULL,
                                 hora TIME NOT NULL,
                                 tarifaTipo VARCHAR(255) NOT NULL,
                                 lineaNumero VARCHAR(255) NOT NULL,
                                 PRIMARY KEY (id),
                                 FOREIGN KEY (tarifaTipo) REFERENCES tarifa(tipo),
                                 FOREIGN KEY (lineaNumero) REFERENCES linea(numero),
                                 UNIQUE (fecha,hora))";                                 
                self::crearTabla($db, $crearTablaViaje, 'viaje');
            }

            private function crearTabla($db, $crearTabla, $nombre) {
                if ($db->query($crearTabla) === TRUE) {
                    echo "<p>Tabla '$nombre' creada con éxito.</p>";
                } else {
                    echo "<p>ERROR en la creación de la tabla '$nombre'. Error: " .$db->error. ".</p>";
                    exit();
                }
            }

            private function insertar($db) {
                echo "<p>Formulario para insertar datos en la tabla 'viaje' que pertenece a la base de datos 'sew'.</p>";
                self::campoFecha();
                self::campoHora();
                self::campoTarifaTipo($db);
                self::campoLineaNumero($db);
                echo "<input type='submit' name='insertar' value='Insertar' />";
            }

            private function campoFecha() {
                echo "<p>Fecha: <input type='date' title='Fecha' name='fecha' max='" .date("Y-m-d"). "' required /></p>";
            }

            private function campoHora() {
                echo "<p>Hora: <input type='time' title='Hora' name='hora' required /></p>";
            }

            private function campoTarifaTipo($db) {
                echo "
                    <p>Tipo Tarifa: 
                        <label for='tarifaTipo' hidden>Tipo Tarifa:</label>
                        <select id='tarifaTipo' name='tarifaTipo'>
                ";
                // Consultar la tabla 'tarifa'
                $resultado = $db->query("SELECT * FROM tarifa");
                while ($fila = $resultado->fetch_assoc()) {
                    echo "
                            <option value='" .$fila["tipo"]. "'>" .$fila["tipo"]." (".number_format($fila["precio"], 2)." €)". "</option>
                    ";
                }
                echo "
                        </select>
                    </p>
                ";
            }

            private function campoLineaNumero($db) {
                echo "
                    <p>Número Línea: 
                        <label for='lineaNumero' hidden>Número Línea:</label>
                        <select id='lineaNumero' name='lineaNumero'>
                ";
                // Consultar la tabla 'linea'
                $resultado = $db->query("SELECT * FROM linea");
                while ($fila = $resultado->fetch_assoc()) {
                    echo "
                            <option value='" .$fila["numero"]. "'>" .$fila["numero"]." (".$fila["origen"]." - ".$fila["destino"].")". "</option>
                    ";
                }
                echo "
                        </select>
                    </p>
                ";
            }

            private function insertarDatos($db) {
                if (self::getViajeByFechaHora($db, $_POST["fecha"], $_POST["hora"]) == NULL) {
                    // Prepara la sentencia de inserción
                    $consultaPre = $db->prepare("INSERT INTO viaje (fecha, hora, tarifaTipo, lineaNumero) VALUES (?,?,?,?)");

                    // Añade los parámetros de la variable predefinida $_POST
                    $consultaPre->bind_param('ssss', $_POST["fecha"], $_POST["hora"], $_POST["tarifaTipo"], $_POST["lineaNumero"]);

                    // Ejecuta la sentencia
                    $consultaPre->execute();

                    // Muestra los resultados
                    echo "<p>Filas insertadas: " .$consultaPre->affected_rows. ".</p>";

                    $consultaPre->close();
                } else {
                    echo "<p>La fecha " .$_POST["fecha"]. " y la hora " .$_POST["hora"]. " ya tienen un viaje asociado.</p>";
                }
            }

            private function getViajeByFechaHora($db, $fecha, $hora) {
                // Prepara la consulta
                $consultaPre = $db->prepare("SELECT * FROM viaje WHERE fecha = ? AND hora = ?");

                // ss indica que se le pasan dos string
                $consultaPre->bind_param('ss', $fecha, $hora);

                // Ejecuta la consulta
                $consultaPre->execute();

                // Obtiene los resultados como un objeto de la clase mysqli_result
                $resultado = $consultaPre->get_result();

                // Cierre de la consulta
                $consultaPre->close();

                return $resultado->fetch_assoc();
            }

            public function buscar() {
                echo "<h2>Buscar Datos</h2>";
                echo "<p>Formulario para buscar datos en la tabla 'viaje' que pertenece a la base de datos 'sew'.</p>";
                $this->campoFecha();
                echo "<input type='submit' name='buscar' value='Buscar' />";
            }

            private function buscarDatos($db) {
                // Prepara la consulta
                $consultaPre = $db->prepare("SELECT * FROM viaje WHERE fecha = ? ORDER BY hora");

                // Obtiene el parámetro de la variable predefinida $_POST
                // s indica que se le pasa un string
                $consultaPre->bind_param('s', $_POST["fecha"]);

                // Ejecuta la consulta
                $consultaPre->execute();

                // Obtiene los resultados como un objeto de la clase mysqli_result
                $resultado = $consultaPre->get_result();

                //Visualización de los resultados de la búsqueda
                if ($resultado->fetch_assoc() != NULL) {
                    echo "<p>Las filas de la tabla 'viaje' que coinciden con la búsqueda son:</p>";
                    $resultado->data_seek(0); // Se posiciona al inicio del resultado de búsqueda
                    self::mostrarTabla($resultado);
                } else {
                    echo "<p>Búsqueda sin resultados.</p>";
                }

                // Cierre de la consulta
                $consultaPre->close();
            }

            private function mostrarTabla($resultado) {
                echo "
                    <table>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Tipo Tarifa</th>
                            <th>Número Línea</th>
                        </tr>
                ";
                while ($fila = $resultado->fetch_assoc()) {
                    echo "
                        <tr>
                            <td>" .$fila["fecha"]. "</td>
                            <td>" .$fila["hora"]. "</td>
                            <td>" .$fila["tarifaTipo"]. "</td>
                            <td>" .$fila["lineaNumero"]. "</td>
                        </tr>
                    ";
                }
                echo "
                    </table>
                ";
            }

            private function generarInforme($db) {
                // Consultar la tabla 'viaje'
                $resultado = $db->query("SELECT * FROM viaje");

                // Compruebo los datos recibidos
                if ($resultado->num_rows > 0) {
                    // Mostrar los datos en un informe
                    echo "<p>A continuación, se muestra un informe con datos relevantes de los viajes:</p>";
                    echo "<ul>";
                    echo "<li>Último viaje: " .self::getUltimoViaje($db). "</li>";
                    echo "<li>Top-3 líneas: " .self::getTopTres($db, "lineaNumero", $resultado->num_rows). "</li>";
                    echo "<li>Top-3 tarifas: " .self::getTopTres($db, "tarifaTipo", $resultado->num_rows). "</li>";
                    echo "</ul>";
                } else {
                    echo "<p>Tabla vacía.</p>";
                }
            }

            private function getUltimoViaje($db) {
                // Consultar la tabla 'viaje'
                $resultado = $db->query("SELECT * FROM viaje ORDER BY fecha DESC, hora DESC");
                $fila = $resultado->fetch_assoc();
                return "
                    <ul>
                        <li>Fecha: " .$fila["fecha"]. "</li>
                        <li>Hora: " .$fila["hora"]. "</li>
                        <li>Tipo Tarifa: " .$fila["tarifaTipo"]. "</li>
                        <li>Número Línea: " .$fila["lineaNumero"]. "</li>
                    </ul>
                ";
            }

            private function getTopTres($db, $columna, $numRows) {
                // Consultar la tabla 'viaje'
                $resultado = $db->query("SELECT COUNT(id) AS total, $columna FROM viaje GROUP BY $columna ORDER BY total DESC LIMIT 3");
                $topTres = "<ul>";
                while ($fila = $resultado->fetch_assoc()) {
                    $porcentaje = ($fila["total"] / $numRows) * 100;
                    $topTres .= "<li>" .$fila[$columna]. " ($porcentaje %)</li>";
                }
                $topTres .= "</ul>";
                return $topTres;
            }

            public function cargar() {
                echo "<h2>Cargar Archivo</h2>";
                echo "<p>Archivo de texto en formato CSV a cargar desde la máquina cliente.</p>";
                echo "<input type='file' title='Archivo' name='archivo' />";
                echo "<input type='submit' name='cargarTarifa' value='Cargar tarifa' />";
                echo "<input type='submit' name='cargarLinea' value='Cargar linea' />";
                echo "<input type='submit' name='cargarViaje' value='Cargar viaje' />";
            }

            private function cargarArchivo($db, $insert, $select, $bindParam) {
                if ($_FILES) {
                    $info = new SplFileInfo($_FILES['archivo']['name']);

                    if ($info->getExtension() == 'csv') {
                        // Prepara la sentencia de inserción
                        $consultaPre = $db->prepare($insert);

                        $archivo = fopen($_FILES['archivo']['tmp_name'], 'rb');

                        // Consultar la tabla (antes)
                        $resultado = $db->query($select);
                        $antes = $resultado->num_rows;
                        
                        fgets($archivo);
                        while (($linea = fgetcsv($archivo)) !== false) {
                            // Añade los parámetros de la variable $linea
                            $bindParam($consultaPre, $linea);
                        
                            // Ejecuta la sentencia
                            $consultaPre->execute();
                        }    
                        
                        // Consultar la tabla (después)
                        $resultado = $db->query($select);
                        $despues = $resultado->num_rows - $antes;
                        // Muestra los resultados
                        echo "<p>Filas cargadas: " .$despues. ".</p>";

                        fclose($archivo);

                        $consultaPre->close();
                    } else {
                        echo "<p>Ningún archivo seleccionado o el archivo seleccionado no está en formato CSV.</p>";
                    }
                }
            }

            private function cargarTarifa($db) {
                $insert = "INSERT INTO tarifa (tipo, precio) VALUES (?,?)";
                $select = "SELECT * FROM tarifa";
                self::cargarArchivo($db, $insert, $select, 'BaseDatos::bindParamTarifa');
            }

            private function bindParamTarifa($consultaPre, $linea) {
                $consultaPre->bind_param('sd', $linea[0], $linea[1]);
            }

            private function cargarLinea($db) {
                $insert = "INSERT INTO linea (numero, origen, destino) VALUES (?,?,?)";
                $select = "SELECT * FROM linea";
                self::cargarArchivo($db, $insert, $select, 'BaseDatos::bindParamLinea');
            }

            private function bindParamLinea($consultaPre, $linea) {
                $consultaPre->bind_param('sss', $linea[0], $linea[1], $linea[2]);
            }

            private function cargarViaje($db) {
                $insert = "INSERT INTO viaje (fecha, hora, tarifaTipo, lineaNumero) VALUES (?,?,?,?)";
                $select = "SELECT * FROM viaje";
                self::cargarArchivo($db, $insert, $select, 'BaseDatos::bindParamViaje');
            }

            private function bindParamViaje($consultaPre, $linea) {
                $consultaPre->bind_param('ssss', $linea[0], $linea[1], $linea[2], $linea[3]);
            }

            private function exportarArchivo($db) {
                $archivo = fopen("viaje.csv", 'wb');

                if (!$archivo) {
                    echo "<p>La orden no puede ser procesada.</p>";
                } else {
                    // Consultar la tabla 'viaje'
                    $resultado = $db->query("SELECT * FROM viaje ORDER BY fecha, hora");

                    fputs($archivo, "fecha,hora,tarifaTipo,lineaNumero\n");
                    while ($fila = $resultado->fetch_assoc()) {
                        fputcsv($archivo, array_slice($fila, 1));
                    }
                }

                // Muestra los resultados
                echo "<p>Filas exportadas: " .$resultado->num_rows. ".</p>";

                fclose($archivo);                
            }

            public function pressBoton() {
                // Solo se ejecutará si se ha pulsado un botón
                if (count($_POST) > 0) {
                    if(isset($_POST['crearBaseDatos'])) $this->ejecutar('Crear Base Datos', 'BaseDatos::crearBaseDatos', FALSE);
                    if(isset($_POST['crearTablas'])) $this->ejecutar('Crear Tablas', 'BaseDatos::crearTablas');
                    if(isset($_POST['insertarDatos'])) $this->ejecutar('Insertar Datos', 'BaseDatos::insertar');
                    if(isset($_POST['insertar'])) $this->ejecutar('Insertar Datos', 'BaseDatos::insertarDatos');
                    if(isset($_POST['buscarDatos'])) $this->buscar();
                    if(isset($_POST['buscar'])) $this->ejecutar('Buscar Datos', 'BaseDatos::buscarDatos');
                    if(isset($_POST['generarInforme'])) $this->ejecutar('Generar Informe', 'BaseDatos::generarInforme');
                    if(isset($_POST['cargarArchivo'])) $this->cargar();
                    if(isset($_POST['cargarTarifa'])) $this->ejecutar('Cargar Archivo', 'BaseDatos::cargarTarifa');
                    if(isset($_POST['cargarLinea'])) $this->ejecutar('Cargar Archivo', 'BaseDatos::cargarLinea');
                    if(isset($_POST['cargarViaje'])) $this->ejecutar('Cargar Archivo', 'BaseDatos::cargarViaje');
                    if(isset($_POST['exportarArchivo'])) $this->ejecutar('Exportar Archivo', 'BaseDatos::exportarArchivo');
                } else {
                    echo "
                        <h2>Elija una Opción del Menú</h2>
                        <p>Por favor, escoja una de las opciones del menú que aparece en el lateral izquierdo de esta página.</p>
                    ";
                }
            }

        }

        // Interfaz con el usuario. En el interior de comillas dobles se deben usar comillas simples
        echo "
            <form action='#' method='post' name='baseDatos' enctype='multipart/form-data'>
                <nav>
                    <h2>Menú</h2>
                    <p hidden>Menú</p>
                    <input type='submit' name='crearBaseDatos' value='Crear base datos' />
                    <input type='submit' name='crearTablas' value='Crear tablas' />
                    <input type='submit' name='insertarDatos' value='Insertar datos' />
                    <input type='submit' name='buscarDatos' value='Buscar datos' />
                    <input type='submit' name='generarInforme' value='Generar informe' />
                    <input type='submit' name='cargarArchivo' value='Cargar archivo' />
                    <input type='submit' name='exportarArchivo' value='Exportar archivo' />
                </nav>

                <section>
        ";

        $bd = new BaseDatos();
        $bd->pressBoton();

        echo "
                </section>
            </form>
        ";
    ?>

    <footer>
        <a href="https://validator.w3.org/check/referer"><img src="https://clouddayscom.files.wordpress.com/2020/06/html5_badge.png" alt="¡HTML5 Válido!" /></a>
        <a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="https://kevloi.github.io/portfolio/static/media/CSS.f6eb4946.png" alt="¡CSS Válido!" /></a>
        <p>Copyright @2020 Héctor Fernández</p>
    </footer>
</body>

</html>
