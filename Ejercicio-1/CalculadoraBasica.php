<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Calculadora básica</title>
    <link rel="stylesheet" href="CalculadoraBasica.css" />
</head>

<body>
    <!-- Calculadora Básica. Versión 1.0. 01/12/2020. Héctor Fernández Maillo. Universidad de Oviedo -->
    <header>
        <h1>Calculadora básica</h1>
    </header>

    <article>
        <h2 hidden>Calculadora básica</h2>

        <?php
            // Iniciar SESSION
            session_start();

            /**
             * Definición de la clase CalculadoraBasica
             */
            class CalculadoraBasica {

                protected $pantalla;
                protected $memoria;

                public function __construct() {
                    if (!isset($_SESSION['pantalla'])) {
                        $_SESSION['pantalla'] = "";
                    }
                    $this->pantalla = $_SESSION['pantalla'];

                    if (!isset($_SESSION['memoria'])) {
                        $_SESSION['memoria'] = 0.0;
                    }
                    $this->memoria = $_SESSION['memoria'];
                }

                public function getPantalla() {
                    return $this->pantalla;
                }

                private function appendPantalla($toAppend) {
                    $_SESSION['pantalla'] = $this->pantalla .= $toAppend;
                }

                public function digitos($digito) {
                    $this->appendPantalla($digito);
                }

                public function punto() {
                    $this->appendPantalla(".");
                }

                public function suma() {
                    $this->appendPantalla("+");
                }

                public function resta() {
                    $this->appendPantalla("-");
                }

                public function multiplicacion() {
                    $this->appendPantalla("*");
                }

                public function division() {
                    $this->appendPantalla("/");
                }
                
                private function writePantalla($toWrite) {
                    $_SESSION['pantalla'] = $this->pantalla = $toWrite;
                }

                public function mrc() {
                    $this->writePantalla($this->memoria);
                }

                public function mMenos() {
                    $this->igual();
                    $valor = floatval($this->pantalla);
                    if ($valor != 0) {
                        $_SESSION['memoria'] = $this->memoria -= $valor;
                    }
                }

                public function mMas() {
                    $this->igual();
                    $valor = floatval($this->pantalla);
                    if ($valor != 0) {
                        $_SESSION['memoria'] = $this->memoria += $valor;
                    }
                }

                public function borrar() {
                    $this->writePantalla("");
                }

                public function igual() {
                    try {
                        $this->pantalla = eval("return $this->pantalla ;");
                    } catch (Throwable $e) {
                        $this->pantalla = "Error: " .$e->getMessage();
                    }
                    $_SESSION['pantalla'] = $this->pantalla;
                }

            }

            $calculadora = new CalculadoraBasica();

            // Solo se ejecutará si se ha pulsado un botón
            if (count($_POST) > 0) {
                if(isset($_POST['mrc'])) $calculadora->mrc();
                if(isset($_POST['mMenos'])) $calculadora->mMenos();
                if(isset($_POST['mMas'])) $calculadora->mMas();
                if(isset($_POST['division'])) $calculadora->division();

                if(isset($_POST['digitos7'])) $calculadora->digitos(7);
                if(isset($_POST['digitos8'])) $calculadora->digitos(8);
                if(isset($_POST['digitos9'])) $calculadora->digitos(9);
                if(isset($_POST['multiplicacion'])) $calculadora->multiplicacion();

                if(isset($_POST['digitos4'])) $calculadora->digitos(4);
                if(isset($_POST['digitos5'])) $calculadora->digitos(5);
                if(isset($_POST['digitos6'])) $calculadora->digitos(6);
                if(isset($_POST['resta'])) $calculadora->resta();

                if(isset($_POST['digitos1'])) $calculadora->digitos(1);
                if(isset($_POST['digitos2'])) $calculadora->digitos(2);
                if(isset($_POST['digitos3'])) $calculadora->digitos(3);
                if(isset($_POST['suma'])) $calculadora->suma();

                if(isset($_POST['digitos0'])) $calculadora->digitos(0);
                if(isset($_POST['punto'])) $calculadora->punto();
                if(isset($_POST['borrar'])) $calculadora->borrar();
                if(isset($_POST['igual'])) $calculadora->igual();
            }

            $pantalla = $calculadora->getPantalla();

            // Interfaz con el usuario. En el interior de comillas dobles se deben usar comillas simples
            echo "
                <form action='#' method='post' name='calculadora'>
                    <input type='text' title='Pantalla' value='$pantalla' disabled />
            
                    <input type='submit' name='mrc' value='mrc' />
                    <input type='submit' name='mMenos' value='m-' />
                    <input type='submit' name='mMas' value='m+' />
                    <input type='submit' name='division' value='/' />

                    <input type='submit' class='digito' name='digitos7' value='7' />
                    <input type='submit' class='digito' name='digitos8' value='8' />
                    <input type='submit' class='digito' name='digitos9' value='9' />
                    <input type='submit' name='multiplicacion' value='*' />

                    <input type='submit' class='digito' name='digitos4' value='4' />
                    <input type='submit' class='digito' name='digitos5' value='5' />
                    <input type='submit' class='digito' name='digitos6' value='6' />
                    <input type='submit' name='resta' value='-' />

                    <input type='submit' class='digito' name='digitos1' value='1' />
                    <input type='submit' class='digito' name='digitos2' value='2' />
                    <input type='submit' class='digito' name='digitos3' value='3' />
                    <input type='submit' name='suma' value='+' />

                    <input type='submit' class='digito' name='digitos0' value='0' />
                    <input type='submit' name='punto' value='.' />
                    <input type='submit' name='borrar' value='C' />
                    <input type='submit' name='igual' value='=' />
                </form>
            ";
        ?>
    </article>

    <footer>
        <a href="https://validator.w3.org/check/referer"><img src="https://clouddayscom.files.wordpress.com/2020/06/html5_badge.png" alt="¡HTML5 Válido!" /></a>
        <a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="https://kevloi.github.io/portfolio/static/media/CSS.f6eb4946.png" alt="¡CSS Válido!" /></a>
        <p>Copyright @2020 Héctor Fernández</p>
    </footer>
</body>

</html>
