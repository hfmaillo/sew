<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Calculadora RPN</title>
    <link rel="stylesheet" href="CalculadoraRPN.css" />
</head>

<body>
    <!-- Calculadora RPN. Versión 1.0. 01/12/2020. Héctor Fernández Maillo. Universidad de Oviedo -->
    <header>
        <h1>Calculadora RPN</h1>
    </header>

    <article>
        <h2 hidden>Calculadora RPN</h2>

        <?php
            // Iniciar SESSION
            session_start();

            /**
             * Definición de la clase PilaLIFO
             */
            class PilaLIFO {

                protected $pila;

                public function __construct() { 
                    $this->pila = array();
                }
            
                public function apilar($valor) {
                    array_unshift($this->pila, $valor);
                }
            
                public function desapilar() {
                    return array_shift($this->pila);
                }
            
                public function longitud() {
                    return count($this->pila);
                }
            
                public function mostrar() {
                    $stringPila = "<h3 hidden>Pila</h3>";
                    
                    for ($i = 0; $i < $this->longitud(); $i++) {
                        if ($i == 0) $stringPila .= "<ol>";
                        $stringPila .= "<li>"  .$this->pila[$i]. "</li>";
                        if ($i == $this->longitud() - 1) $stringPila .= "</ol>";
                    }

                    return $stringPila;
                }
            
            }

            /**
             * Definición de la clase CalculadoraRPN
             */
            class CalculadoraRPN {

                protected $pantalla;
                protected $pila;

                public function __construct() {
                    if (!isset($_SESSION['pantalla'])) {
                        $_SESSION['pantalla'] = "";
                    }
                    $this->pantalla = $_SESSION['pantalla'];

                    if (!isset($_SESSION['pila'])) {
                        $_SESSION['pila'] = new PilaLIFO();
                    }
                    $this->pila = $_SESSION['pila'];
                }

                public function getPantalla() {
                    return $this->pantalla;
                }

                public function getPila() {
                    return $this->pila;
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

                private function operacion($operador, $numOperandos) {
                    if ($this->pila->longitud() >= $numOperandos) {
                        $operacion;
                        if ($numOperandos == 1) {
                            $v = $this->pila->desapilar();
                            $operacion = $operador($v);
                        } else { // $numOperandos == 2
                            $v2 = $this->pila->desapilar();
                            $v1 = $this->pila->desapilar();
                            $operacion = $operador($v1, $v2);
                        }
            
                        $this->pila->apilar($operacion);
                    }
                }

                public function suma() {
                    $this->operacion(fn($v1, $v2) => $v1 + $v2, 2);
                }

                public function resta() {
                    $this->operacion(fn($v1, $v2) => $v1 - $v2, 2);
                }

                public function multiplicacion() {
                    $this->operacion(fn($v1, $v2) => $v1 * $v2, 2);
                }

                public function division() {
                    $this->operacion(fn($v1, $v2) => $v1 / $v2, 2);
                }

                public function borrar() {
                    $_SESSION['pantalla'] = $this->pantalla = "";
                }

                public function enter() {
                    $valor = floatval($this->pantalla);
                    if ($valor != 0) {
                        $this->borrar();
                        $this->pila->apilar($valor);
                    }
                }

                public function pi() {
                    $this->appendPantalla(pi());
                }

                public function e() {
                    $this->appendPantalla(exp(1));
                }

                public function seno() {
                    $this->operacion('sin', 1);
                }

                public function coseno() {
                    $this->operacion('cos', 1);
                }

                public function tangente() {
                    $this->operacion('tan', 1);
                }

                public function arcoseno() {
                    $this->operacion('asin', 1);
                }

                public function arcocoseno() {
                    $this->operacion('acos', 1);
                }

                public function arcotangente() {
                    $this->operacion('atan', 1);
                }

                public function raiz() {
                    $this->operacion('sqrt', 1);
                }

                public function potencia() {
                    $this->operacion('pow', 2);
                }

                public function logaritmo() {
                    $this->operacion('log10', 1);
                }

                public function lNatural() {
                    $this->operacion('log', 1);
                }

                public function masMenos() {
                    if (substr($this->pantalla, 0, 1) != "-") {
                        $this->pantalla = "-" .$this->pantalla;
                    } else {
                        $this->pantalla = substr($this->pantalla, 1);
                    }
                    $_SESSION['pantalla'] = $this->pantalla;
                }

            }

            $calculadora = new CalculadoraRPN();

            // Solo se ejecutará si se ha pulsado un botón
            if (count($_POST) > 0) {
                if(isset($_POST['pi'])) $calculadora->pi();
                if(isset($_POST['seno'])) $calculadora->seno();
                if(isset($_POST['coseno'])) $calculadora->coseno();
                if(isset($_POST['tangente'])) $calculadora->tangente();
                if(isset($_POST['e'])) $calculadora->e();

                if(isset($_POST['raiz'])) $calculadora->raiz();
                if(isset($_POST['arcoseno'])) $calculadora->arcoseno();
                if(isset($_POST['arcocoseno'])) $calculadora->arcocoseno();
                if(isset($_POST['arcotangente'])) $calculadora->arcotangente();
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

                if(isset($_POST['masMenos'])) $calculadora->masMenos();
                if(isset($_POST['digitos0'])) $calculadora->digitos(0);
                if(isset($_POST['punto'])) $calculadora->punto();
                if(isset($_POST['borrar'])) $calculadora->borrar();
                if(isset($_POST['enter'])) $calculadora->enter();
            }

            $pantalla = $calculadora->getPantalla();
            $pila = $calculadora->getPila()->mostrar();

            // Interfaz con el usuario. En el interior de comillas dobles se deben usar comillas simples
            echo "
                <form action='#' method='post' name='calculadora'>
                    <section id='pila'>
                        $pila
                    </section>

                    <input type='text' title='Pantalla' value='$pantalla' disabled />

                    <input type='submit' name='pi' value='π' />
                    <input type='submit' name='seno' value='sin' />
                    <input type='submit' name='coseno' value='cos' />
                    <input type='submit' name='tangente' value='tan' />
                    <input type='submit' name='e' value='e' />

                    <input type='submit' name='raiz' value='√' />
                    <input type='submit' name='arcoseno' value='asin' />
                    <input type='submit' name='arcocoseno' value='acos' />
                    <input type='submit' name='arcotangente' value='atan' />
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

                    <input type='submit' name='masMenos' value='±' />
                    <input type='submit' class='digito' name='digitos0' value='0' />
                    <input type='submit' name='punto' value='.' />
                    <input type='submit' name='borrar' value='C' />
                    <input type='submit' name='enter' value='Enter' />
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
