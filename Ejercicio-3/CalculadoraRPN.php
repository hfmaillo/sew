<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Calculadora científica</title>
    <link rel="stylesheet" href="CalculadoraCientifica.css" />
</head>

<body>
    <!-- Calculadora Científica. Versión 1.0. 01/12/2020. Héctor Fernández Maillo. Universidad de Oviedo -->
    <header>
        <h1>Calculadora científica</h1>
    </header>

    <article>
        <h2 hidden>Calculadora científica</h2>

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

                protected function appendPantalla($toAppend) {
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
                
                protected function writePantalla($toWrite) {
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

            /**
             * Definición de la clase CalculadoraCientifica
             */
            class CalculadoraCientifica extends CalculadoraBasica {

                public function pi() {
                    $this->appendPantalla("pi()");
                }

                public function e() {
                    $this->appendPantalla("exp(1)");
                }

                public function seno() {
                    $this->appendPantalla("sin(");
                }

                public function coseno() {
                    $this->appendPantalla("cos(");
                }

                public function tangente() {
                    $this->appendPantalla("tan(");
                }

                public function pIzquierdo() {
                    $this->appendPantalla("(");
                }

                public function pDerecho() {
                    $this->appendPantalla(")");
                }

                public function arcoseno() {
                    $this->appendPantalla("asin(");
                }

                public function arcocoseno() {
                    $this->appendPantalla("acos(");
                }

                public function arcotangente() {
                    $this->appendPantalla("atan(");
                }

                public function raiz() {
                    $this->appendPantalla("sqrt(");
                }

                public function potencia() {
                    $this->appendPantalla("pow(");
                }

                public function logaritmo() {
                    $this->appendPantalla("log10(");
                }

                public function lNatural() {
                    $this->appendPantalla("log(");
                }

                public function coma() {
                    $this->appendPantalla(",");
                }

            }

            $calculadora = new CalculadoraCientifica();

            // Solo se ejecutará si se ha pulsado un botón
            if (count($_POST) > 0) {
                if(isset($_POST['pi'])) $calculadora->pi();
                if(isset($_POST['e'])) $calculadora->e();
                if(isset($_POST['seno'])) $calculadora->seno();
                if(isset($_POST['coseno'])) $calculadora->coseno();
                if(isset($_POST['tangente'])) $calculadora->tangente();

                if(isset($_POST['pIzquierdo'])) $calculadora->pIzquierdo();
                if(isset($_POST['pDerecho'])) $calculadora->pDerecho();
                if(isset($_POST['arcoseno'])) $calculadora->arcoseno();
                if(isset($_POST['arcocoseno'])) $calculadora->arcocoseno();
                if(isset($_POST['arcotangente'])) $calculadora->arcotangente();

                if(isset($_POST['raiz'])) $calculadora->raiz();
                if(isset($_POST['mrc'])) $calculadora->mrc();
                if(isset($_POST['mMenos'])) $calculadora->mMenos();
                if(isset($_POST['mMas'])) $calculadora->mMas();
                if(isset($_POST['division'])) $calculadora->division();

                if(isset($_POST['potencia'])) $calculadora->potencia();
                if(isset($_POST['digitos7'])) $calculadora->digitos(7);
                if(isset($_POST['digitos8'])) $calculadora->digitos(8);
                if(isset($_POST['digitos9'])) $calculadora->digitos(9);
                if(isset($_POST['multiplicacion'])) $calculadora->multiplicacion();

                if(isset($_POST['logaritmo'])) $calculadora->logaritmo();
                if(isset($_POST['digitos4'])) $calculadora->digitos(4);
                if(isset($_POST['digitos5'])) $calculadora->digitos(5);
                if(isset($_POST['digitos6'])) $calculadora->digitos(6);
                if(isset($_POST['resta'])) $calculadora->resta();

                if(isset($_POST['lNatural'])) $calculadora->lNatural();
                if(isset($_POST['digitos1'])) $calculadora->digitos(1);
                if(isset($_POST['digitos2'])) $calculadora->digitos(2);
                if(isset($_POST['digitos3'])) $calculadora->digitos(3);
                if(isset($_POST['suma'])) $calculadora->suma();

                if(isset($_POST['coma'])) $calculadora->coma();
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

                    <input type='submit' name='pi' value='π' />
                    <input type='submit' name='e' value='e' />
                    <input type='submit' name='seno' value='sin' />
                    <input type='submit' name='coseno' value='cos' />
                    <input type='submit' name='tangente' value='tan' />

                    <input type='submit' name='pIzquierdo' value='(' />
                    <input type='submit' name='pDerecho' value=')' />
                    <input type='submit' name='arcoseno' value='asin' />
                    <input type='submit' name='arcocoseno' value='acos' />
                    <input type='submit' name='arcotangente' value='atan' />

                    <input type='submit' name='raiz' value='√' />
                    <input type='submit' name='mrc' value='mrc' />
                    <input type='submit' name='mMenos' value='m-' />
                    <input type='submit' name='mMas' value='m+' />
                    <input type='submit' name='division' value='/' />

                    <input type='submit' name='potencia' value='x^y' />
                    <input type='submit' class='digito' name='digitos7' value='7' />
                    <input type='submit' class='digito' name='digitos8' value='8' />
                    <input type='submit' class='digito' name='digitos9' value='9' />
                    <input type='submit' name='multiplicacion' value='*' />

                    <input type='submit' name='logaritmo' value='log' />
                    <input type='submit' class='digito' name='digitos4' value='4' />
                    <input type='submit' class='digito' name='digitos5' value='5' />
                    <input type='submit' class='digito' name='digitos6' value='6' />
                    <input type='submit' name='resta' value='-' />

                    <input type='submit' name='lNatural' value='ln' />
                    <input type='submit' class='digito' name='digitos1' value='1' />
                    <input type='submit' class='digito' name='digitos2' value='2' />
                    <input type='submit' class='digito' name='digitos3' value='3' />
                    <input type='submit' name='suma' value='+' />

                    <input type='submit' name='coma' value=',' />
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
