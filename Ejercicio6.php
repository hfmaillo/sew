<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pruebas usabilidad</title>
    <link rel="stylesheet" href="Ejercicio6.css" />
</head>

<body>
    <!-- Ejercicio 6. Versión 1.0. 15/12/2020. Héctor Fernández Maillo. Universidad de Oviedo -->
    <header>
        <h1>Pruebas usabilidad</h1>
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

            private function crearTabla($db) {
                // Crear la tabla "PruebasUsabilidad"
                $crearTabla = "CREATE TABLE IF NOT EXISTS PruebasUsabilidad (id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                            dni VARCHAR(9) NOT NULL,
                            nombre VARCHAR(255) NOT NULL,
                            apellidos VARCHAR(255) NOT NULL,
                            email VARCHAR(255) NOT NULL,
                            telefono INT UNSIGNED NOT NULL,
                            edad TINYINT UNSIGNED NOT NULL,
                            sexo ENUM('Femenino','Masculino','Otro') NOT NULL,
                            periciaInformatica ENUM('0','1','2','3','4','5','6','7','8','9','10') NOT NULL,
                            tiempoEmpleado INT UNSIGNED NOT NULL,
                            tareaCorrecta BOOLEAN NOT NULL,
                            comentarios VARCHAR(255) NOT NULL,
                            propuestas VARCHAR(255) NOT NULL,
                            valoracion ENUM('0','1','2','3','4','5','6','7','8','9','10') NOT NULL,
                            PRIMARY KEY (id),
                            UNIQUE (dni))";
                if ($db->query($crearTabla) === TRUE) {
                    echo "<p>Tabla 'PruebasUsabilidad' creada con éxito.</p>";
                } else {
                    echo "<p>ERROR en la creación de la tabla 'PruebasUsabilidad'. Error: " .$db->error. ".</p>";
                    exit();
                }
            }

            public function insertar() {
                echo "<h2>Insertar Datos</h2>";
                echo "<p>Formulario para insertar datos en la tabla 'PruebasUsabilidad' que pertenece a la base de datos 'sew'.</p>";
                $this->campoDni();
                $this->campoNombre();
                $this->campoApellidos();
                $this->campoEmail();
                $this->campoTelefono();
                $this->campoEdad();
                $this->campoSexo();
                $this->campoPericiaInformatica();
                $this->campoTiempoEmpleado();
                $this->campoTareaCorrecta();
                $this->campoComentarios();
                $this->campoPropuestas();
                $this->campoValoracion();
                echo "<input type='submit' name='insertar' value='Insertar' />";
            }

            private function campoDni($dni = "") {
                $dni .= "'";
                if ($dni != "'") {
                    $dni .= " readonly";
                }
                echo "<p>DNI: <input type='text' title='DNI' name='dni' placeholder='12345678A' pattern='[0-9]{8}[A-Z]{1}' value='$dni required /></p>";
            }

            private function campoNombre($nombre = "") {
                echo "<p>Nombre: <input type='text' title='Nombre' name='nombre' value='$nombre' required /></p>";
            }

            private function campoApellidos($apellidos = "") {
                echo "<p>Apellidos: <input type='text' title='Apellidos' name='apellidos' value='$apellidos' required /></p>";
            }

            private function campoEmail($email = "") {
                echo "<p>E-mail: <input type='email' title='E-mail' name='email' placeholder='ejemplo@dominio.com' value='$email' required /></p>";
            }

            private function campoTelefono($telefono = "") {
                echo "<p>Teléfono: <input type='tel' title='Teléfono' name='telefono' placeholder='123456789' pattern='[0-9]{9}' value='$telefono' required /></p>";
            }

            private function campoEdad($edad = "") {
                echo "<p>Edad: <input type='number' title='Edad' name='edad' min='0' max='100' value='$edad' required /></p>";
            }

            private function campoSexo($sexo = "") {
                $fChecked = ($sexo == 'Femenino') ? 'checked' : '';
                $mChecked = ($sexo == 'Masculino') ? 'checked' : '';
                $oChecked = ($sexo == 'Otro') ? 'checked' : '';
                echo "
                    <fieldset>
                        <legend>Sexo:</legend>
                        <p><input type='radio' title='Femenino' name='sexo' id='femenino' value='Femenino' " .$fChecked. " />Femenino</p> 
                        <p><input type='radio' title='Masculino' name='sexo' id='masculino' value='Masculino' " .$mChecked. " />Masculino</p> 
                        <p><input type='radio' title='Otro' name='sexo' id='otro' value='Otro' " .$oChecked. " />Otro</p>
                    </fieldset>
                ";
            }

            private function campoPericiaInformatica($periciaInformatica = "") {
                echo "<p>Pericia Informática (0-10): <input type='number' title='Pericia Informática' name='periciaInformatica' min='0' max='10' value='$periciaInformatica' required /></p>";
            }

            private function campoTiempoEmpleado($tiempoEmpleado = "") {
                echo "<p>Tiempo Empleado (s): <input type='number' title='Tiempo Empleado' name='tiempoEmpleado' min='0' value='$tiempoEmpleado' required /></p>";
            }

            private function campoTareaCorrecta($tareaCorrecta = "") {
                $checked = ($tareaCorrecta == '1') ? 'checked' : '';
                echo "<p><input type='checkbox' title='Tarea Correcta' name='tareaCorrecta' " .$checked. " />Tarea Correcta</p>";
            }

            private function campoComentarios($comentarios = "") {
                echo "<p>Comentarios: <textarea title='Comentarios' name='comentarios' rows='5' cols='50'>$comentarios</textarea></p>";
            }

            private function campoPropuestas($propuestas = "") {
                echo "<p>Propuestas: <textarea title='Propuestas' name='propuestas' rows='5' cols='50'>$propuestas</textarea></p>";
            }

            private function campoValoracion($valoracion = "") {
                echo "<p>Valoración (0-10): <input type='number' title='Valoración' name='valoracion' min='0' max='10' value='$valoracion' required /></p>";
            }

            private function insertarDatos($db) {
                if (self::getPruebaByDni($db, $_POST["dni"]) == NULL) {
                    // Prepara la sentencia de inserción
                    $consultaPre = $db->prepare("INSERT INTO PruebasUsabilidad (dni, nombre, apellidos, email, telefono, edad, sexo, periciaInformatica, tiempoEmpleado, tareaCorrecta, comentarios, propuestas, valoracion) 
                                 VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    if ($consultaPre === FALSE) {
                        echo "<p>ERROR en la inserción de los datos en la tabla 'PruebasUsabilidad'. Error: " .$db->error. ".</p>";
                        exit();
                    }

                    // Añade los parámetros de la variable predefinida $_POST
                    $sexo = isset($_POST["sexo"]) ? $_POST["sexo"] : 'Otro';
                    $tareaCorrecta = isset($_POST["tareaCorrecta"]) ? '1' : '0';
                    $consultaPre->bind_param('ssssiissiisss',
                                 $_POST["dni"], $_POST["nombre"], $_POST["apellidos"], $_POST["email"], $_POST["telefono"], $_POST["edad"], $sexo, 
                                 $_POST["periciaInformatica"], $_POST["tiempoEmpleado"], $tareaCorrecta, $_POST["comentarios"], $_POST["propuestas"], $_POST["valoracion"]);

                    // Ejecuta la sentencia
                    $consultaPre->execute();

                    // Muestra los resultados
                    echo "<p>Filas insertadas: " .$consultaPre->affected_rows. ".</p>";

                    $consultaPre->close();
                } else {
                    echo "<p>El DNI " .$_POST["dni"]. " ya tiene una prueba asociada.</p>";
                }
            }

            private function getPruebaByDni($db, $dni) {
                // Prepara la consulta
                $consultaPre = $db->prepare("SELECT * FROM PruebasUsabilidad WHERE dni = ?");
                if ($consultaPre === FALSE) {
                    echo "<p>ERROR en la búsqueda de los datos en la tabla 'PruebasUsabilidad'. Error: " .$db->error. ".</p>";
                    exit();
                }

                // s indica que se le pasa un string
                $consultaPre->bind_param('s', $dni);

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
                echo "<p>Formulario para buscar datos en la tabla 'PruebasUsabilidad' que pertenece a la base de datos 'sew'.</p>";
                $this->campoNombre();
                echo "<input type='submit' name='buscar' value='Buscar' />";
            }

            private function buscarDatos($db) {
                // Prepara la consulta
                $consultaPre = $db->prepare("SELECT * FROM PruebasUsabilidad WHERE nombre = ?");
                if ($consultaPre === FALSE) {
                    echo "<p>ERROR en la búsqueda de los datos en la tabla 'PruebasUsabilidad'. Error: " .$db->error. ".</p>";
                    exit();
                }

                // Obtiene el parámetro de la variable predefinida $_POST
                // s indica que se le pasa un string
                $consultaPre->bind_param('s', $_POST["nombre"]);

                // Ejecuta la consulta
                $consultaPre->execute();

                // Obtiene los resultados como un objeto de la clase mysqli_result
                $resultado = $consultaPre->get_result();

                //Visualización de los resultados de la búsqueda
                if ($resultado->fetch_assoc() != NULL) {
                    echo "<p>Las filas de la tabla 'PruebasUsabilidad' que coinciden con la búsqueda son:</p>";
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
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>E-mail</th>
                            <th>Teléfono</th>
                            <th>Edad</th>
                            <th>Sexo</th>
                            <th>Pericia Informática</th>
                            <th>Tiempo Empleado</th>
                            <th>Tarea Correcta</th>
                            <th>Comentarios</th>
                            <th>Propuestas</th>
                            <th>Valoración</th>
                        </tr>
                ";
                while ($fila = $resultado->fetch_assoc()) {
                    $tareaCorrecta = ($fila["tareaCorrecta"] == '1') ? 'Sí' : 'No';
                    echo "
                        <tr>
                            <td>" .$fila["dni"]. "</td>
                            <td>" .$fila["nombre"]. "</td>
                            <td>" .$fila["apellidos"]. "</td>
                            <td>" .$fila["email"]. "</td>
                            <td>" .$fila["telefono"]. "</td>
                            <td>" .$fila["edad"]. "</td>
                            <td>" .$fila["sexo"]. "</td>
                            <td>" .$fila["periciaInformatica"]. "</td>
                            <td>" .$fila["tiempoEmpleado"]. "</td>
                            <td>" .$tareaCorrecta. "</td>
                            <td>" .$fila["comentarios"]. "</td>
                            <td>" .$fila["propuestas"]. "</td>
                            <td>" .$fila["valoracion"]. "</td>
                        </tr>
                    ";
                }
                echo "
                    </table>
                ";
            }

            public function modificarDni() {
                echo "<h2>Modificar Datos</h2>";
                echo "<p>Introduzca un DNI para modificar datos de la prueba asociada, si existe, en la tabla 'PruebasUsabilidad' que pertenece a la base de datos 'sew'.</p>";
                $this->campoDni();
                echo "<input type='submit' name='modificarDni' value='Modificar' />";
            }

            private function modificar($db) {
                $fila = self::getPruebaByDni($db, $_POST["dni"]);
                if ($fila != NULL) {
                    echo "<p>Formulario para modificar datos en la tabla 'PruebasUsabilidad' que pertenece a la base de datos 'sew'.</p>";
                    self::campoDni($fila["dni"]);
                    self::campoNombre($fila["nombre"]);
                    self::campoApellidos($fila["apellidos"]);
                    self::campoEmail($fila["email"]);
                    self::campoTelefono($fila["telefono"]);
                    self::campoEdad($fila["edad"]);
                    self::campoSexo($fila["sexo"]);
                    self::campoPericiaInformatica($fila["periciaInformatica"]);
                    self::campoTiempoEmpleado($fila["tiempoEmpleado"]);
                    self::campoTareaCorrecta($fila["tareaCorrecta"]);
                    self::campoComentarios($fila["comentarios"]);
                    self::campoPropuestas($fila["propuestas"]);
                    self::campoValoracion($fila["valoracion"]);
                    echo "<input type='submit' name='modificar' value='Modificar' />";
                } else {
                    echo "<p>El DNI " .$_POST["dni"]. " no tiene ninguna prueba asociada todavía.</p>";
                }
            }

            private function modificarDatos($db) {
                // Prepara la sentencia de modificación
                $consultaPre = $db->prepare("UPDATE PruebasUsabilidad 
                                SET nombre = ?, apellidos = ?, email = ?, telefono = ?, edad = ?, sexo = ?, periciaInformatica = ?, tiempoEmpleado = ?, tareaCorrecta = ?, comentarios = ?, propuestas = ?, valoracion = ? 
                                WHERE dni = ?");
                if ($consultaPre === FALSE) {
                    echo "<p>ERROR en el modificado de los datos en la tabla 'PruebasUsabilidad'. Error: " .$db->error. ".</p>";
                    exit();
                }

                // Añade los parámetros de la variable predefinida $_POST
                $sexo = isset($_POST["sexo"]) ? $_POST["sexo"] : 'Otro';
                $tareaCorrecta = isset($_POST["tareaCorrecta"]) ? '1' : '0';
                $consultaPre->bind_param('sssiissiissss',
                                $_POST["nombre"], $_POST["apellidos"], $_POST["email"], $_POST["telefono"], $_POST["edad"], $sexo, $_POST["periciaInformatica"], 
                                $_POST["tiempoEmpleado"], $tareaCorrecta, $_POST["comentarios"], $_POST["propuestas"], $_POST["valoracion"], $_POST["dni"]);

                // Ejecuta la sentencia
                $consultaPre->execute();

                // Muestra los resultados
                echo "<p>Filas modificadas: " .$consultaPre->affected_rows. ".</p>";

                $consultaPre->close();
            }

            public function eliminar() {
                echo "<h2>Eliminar Datos</h2>";
                echo "<p>Formulario para eliminar datos en la tabla 'PruebasUsabilidad' que pertenece a la base de datos 'sew'.</p>";
                $this->campoNombre();
                echo "<input type='submit' name='eliminar' value='Eliminar' />";
            }

            private function eliminarDatos($db) {
                // Prepara la consulta
                $consultaPre = $db->prepare("SELECT * FROM PruebasUsabilidad WHERE nombre = ?");
                if ($consultaPre === FALSE) {
                    echo "<p>ERROR en la búsqueda de los datos en la tabla 'PruebasUsabilidad'. Error: " .$db->error. ".</p>";
                    exit();
                }

                // Obtiene el parámetro de la variable predefinida $_POST
                // s indica que se le pasa un string
                $consultaPre->bind_param('s', $_POST["nombre"]);

                // Ejecuta la consulta
                $consultaPre->execute();

                // Obtiene los resultados como un objeto de la clase mysqli_result
                $resultado = $consultaPre->get_result();

                //Visualización de los resultados de la búsqueda
                if ($resultado->fetch_assoc() != NULL) {
                    echo "<p>Las filas de la tabla 'PruebasUsabilidad' que van a ser eliminadas son:</p>";
                    $resultado->data_seek(0); // Se posiciona al inicio del resultado de búsqueda
                    self::mostrarTabla($resultado);

                    // Realiza el borrado
                    // Prepara la sentencia SQL de borrado
                    $consultaPre = $db->prepare("DELETE FROM PruebasUsabilidad WHERE nombre = ?");
                    if ($consultaPre === FALSE) {
                        echo "<p>ERROR en el borrado de los datos en la tabla 'PruebasUsabilidad'. Error: " .$db->error. ".</p>";
                        exit();
                    }

                    // Obtiene el parámetro de la variable predefinida $_POST
                    // s indica que se le pasa un string
                    $consultaPre->bind_param('s', $_POST["nombre"]);

                    // Ejecuta la consulta
                    $consultaPre->execute();
                    echo "<p>Borrados los datos.</p>";
                } else {
                    echo "<p>Búsqueda sin resultados. No se ha borrado nada.</p>";
                }

                // Cierre de la consulta
                $consultaPre->close();

                // Consultar la tabla 'PruebasUsabilidad'
                $resultado = $db->query("SELECT * FROM PruebasUsabilidad");
                if ($resultado === FALSE) {
                    echo "<p>ERROR en la búsqueda de los datos en la tabla 'PruebasUsabilidad'. Error: " .$db->error. ".</p>";
                    exit();
                }

                // Compruebo los datos recibidos
                if ($resultado->num_rows > 0) {
                    // Mostrar los datos en una tabla
                    echo "<p>Los datos de la tabla 'PruebasUsabilidad' son:</p>";
                    self::mostrarTabla($resultado);
                } else {
                    echo "<p>Tabla vacía.</p>";
                }
            }

            private function generarInforme($db) {
                // Consultar la tabla 'PruebasUsabilidad'
                $resultado = $db->query("SELECT * FROM PruebasUsabilidad");
                if ($resultado === FALSE) {
                    echo "<p>ERROR en la búsqueda de los datos en la tabla 'PruebasUsabilidad'. Error: " .$db->error. ".</p>";
                    exit();
                }

                // Compruebo los datos recibidos
                if ($resultado->num_rows > 0) {
                    // Mostrar los datos en un informe
                    echo "<p>A continuación, se muestra un informe con datos relevantes de las pruebas:</p>";
                    echo "<ul>";
                    echo "<li>Edad media de los usuarios: " .self::getMedia("edad", $resultado). ".</li>";
                    $resultado->data_seek(0);
                    echo "<li>Frecuencia del % de cada tipo de sexo entre los usuarios: " .self::getPorcentajeSexo($resultado). ".</li>";
                    $resultado->data_seek(0);
                    echo "<li>Valor medio del nivel o pericia informática de los usuarios: " .self::getMedia("periciaInformatica", $resultado). ".</li>";
                    $resultado->data_seek(0);
                    echo "<li>Tiempo medio para la tarea: " .self::getMedia("tiempoEmpleado", $resultado). " s.</li>";
                    $resultado->data_seek(0);
                    echo "<li>Porcentaje de usuarios que han realizado la tarea correctamente: " .self::getPorcentajeTareaCorrecta($resultado). " %.</li>";
                    $resultado->data_seek(0);
                    echo "<li>Valor medio de la puntuación de los usuarios sobre la aplicación: " .self::getMedia("valoracion", $resultado). ".</li>";
                    echo "</ul>";
                } else {
                    echo "<p>Tabla vacía.</p>";
                }
            }

            private function getMedia($campo, $resultado) {
                $media = 0;

                while ($fila = $resultado->fetch_assoc()) {
                    $media += $fila[$campo];
                }
                
                return $media / $resultado->num_rows;
            }

            private function getPorcentajeSexo($resultado) {
                $pFemenino = $pMasculino = $pOtro = 0;

                while ($fila = $resultado->fetch_assoc()) {
                    switch ($fila["sexo"]) {
                        case 'Femenino':
                            $pFemenino++;
                            break;
                        case 'Masculino':
                            $pMasculino++;
                            break;
                        default:
                            $pOtro++;
                    }
                }

                $pFemenino = ($pFemenino / $resultado->num_rows) * 100;
                $pMasculino = ($pMasculino / $resultado->num_rows) * 100;
                $pOtro = ($pOtro / $resultado->num_rows) * 100;
                
                return "Femenino (" .$pFemenino. " %) / Masculino (" .$pMasculino. " %) / Otro (" .$pOtro. " %)";
            }

            private function getPorcentajeTareaCorrecta($resultado) {
                $porcentaje = 0;

                while ($fila = $resultado->fetch_assoc()) {
                    if ($fila["tareaCorrecta"] == '1') {
                        $porcentaje++;
                    }
                }

                return ($porcentaje / $resultado->num_rows) * 100;
            }

            public function cargar() {
                echo "<h2>Cargar Archivo</h2>";
                echo "<p>Archivo de texto en formato CSV a cargar desde la máquina cliente.</p>";
                echo "<input type='file' title='Archivo' name='archivo' />";
                echo "<input type='submit' name='cargar' value='Cargar' />";
            }

            private function cargarArchivo($db) {
                if ($_FILES) {
                    $info = new SplFileInfo($_FILES['archivo']['name']);

                    if ($info->getExtension() == 'csv') {
                        // Prepara la sentencia de inserción
                        $consultaPre = $db->prepare("INSERT INTO PruebasUsabilidad (dni, nombre, apellidos, email, telefono, edad, sexo, periciaInformatica, tiempoEmpleado, tareaCorrecta, comentarios, propuestas, valoracion) 
                                     VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
                        if ($consultaPre === FALSE) {
                            echo "<p>ERROR en la inserción de los datos en la tabla 'PruebasUsabilidad'. Error: " .$db->error. ".</p>";
                            exit();
                        }

                        $archivo = fopen($_FILES['archivo']['tmp_name'], 'rb');

                        // Consultar la tabla 'PruebasUsabilidad' (antes)
                        $query = "SELECT * FROM PruebasUsabilidad";
                        $resultado = $db->query($query);
                        if ($resultado === FALSE) {
                            echo "<p>ERROR en la búsqueda de los datos en la tabla 'PruebasUsabilidad'. Error: " .$db->error. ".</p>";
                            exit();
                        }
                        $antes = $resultado->num_rows;
                        
                        fgets($archivo);
                        while (($linea = fgetcsv($archivo)) !== false) {
                            // Añade los parámetros de la variable $linea
                            $tareaCorrecta = ($linea[9] == 'Sí') ? '1' : '0';
                            $consultaPre->bind_param('ssssiissiisss',
                                        $linea[0], $linea[1], $linea[2], $linea[3], $linea[4], $linea[5], $linea[6], 
                                        $linea[7], $linea[8], $tareaCorrecta, $linea[10], $linea[11], $linea[12]);
                        
                            // Ejecuta la sentencia
                            $consultaPre->execute();
                        }    
                        
                        // Consultar la tabla 'PruebasUsabilidad' (después)
                        $resultado = $db->query($query);
                        if ($resultado === FALSE) {
                            echo "<p>ERROR en la búsqueda de los datos en la tabla 'PruebasUsabilidad'. Error: " .$db->error. ".</p>";
                            exit();
                        }
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

            private function exportarArchivo($db) {
                $archivo = fopen("pruebasUsabilidad.csv", 'wb');

                if (!$archivo) {
                    echo "<p>La orden no puede ser procesada.</p>";
                } else {
                    // Consultar la tabla 'PruebasUsabilidad'
                    $resultado = $db->query("SELECT * FROM PruebasUsabilidad");
                    if ($resultado === FALSE) {
                        echo "<p>ERROR en la búsqueda de los datos en la tabla 'PruebasUsabilidad'. Error: " .$db->error. ".</p>";
                        exit();
                    }

                    fputs($archivo, "dni,nombre,apellidos,email,telefono,edad,sexo,periciaInformatica,tiempoEmpleado,tareaCorrecta,comentarios,propuestas,valoracion\n");
                    while ($fila = $resultado->fetch_assoc()) {
                        if ($fila["tareaCorrecta"] == '1') {
                            $fila["tareaCorrecta"] = 'Sí';
                        } else {
                            $fila["tareaCorrecta"] = 'No';
                        }

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
                    if(isset($_POST['crearTabla'])) $this->ejecutar('Crear Tabla', 'BaseDatos::crearTabla');
                    if(isset($_POST['insertarDatos'])) $this->insertar();
                    if(isset($_POST['insertar'])) $this->ejecutar('Insertar Datos', 'BaseDatos::insertarDatos');
                    if(isset($_POST['buscarDatos'])) $this->buscar();
                    if(isset($_POST['buscar'])) $this->ejecutar('Buscar Datos', 'BaseDatos::buscarDatos');
                    if(isset($_POST['modificarDatos'])) $this->modificarDni();
                    if(isset($_POST['modificarDni'])) $this->ejecutar('Modificar Datos', 'BaseDatos::modificar');
                    if(isset($_POST['modificar'])) $this->ejecutar('Modificar Datos', 'BaseDatos::modificarDatos');
                    if(isset($_POST['eliminarDatos'])) $this->eliminar();
                    if(isset($_POST['eliminar'])) $this->ejecutar('Eliminar Datos', 'BaseDatos::eliminarDatos');
                    if(isset($_POST['generarInforme'])) $this->ejecutar('Generar Informe', 'BaseDatos::generarInforme');
                    if(isset($_POST['cargarArchivo'])) $this->cargar();
                    if(isset($_POST['cargar'])) $this->ejecutar('Cargar Archivo', 'BaseDatos::cargarArchivo');
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
                    <input type='submit' name='crearTabla' value='Crear tabla' />
                    <input type='submit' name='insertarDatos' value='Insertar datos' />
                    <input type='submit' name='buscarDatos' value='Buscar datos' />
                    <input type='submit' name='modificarDatos' value='Modificar datos' />
                    <input type='submit' name='eliminarDatos' value='Eliminar datos' />
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
