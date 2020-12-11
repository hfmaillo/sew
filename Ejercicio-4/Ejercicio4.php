<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cambio de moneda</title>
    <link rel="stylesheet" href="Ejercicio4.css" />
</head>

<body>
    <!-- Ejercicio 4. Versión 1.0. 01/12/2020. Héctor Fernández Maillo. Universidad de Oviedo -->
    <header>
        <h1>Cambio de moneda</h1>
        <p>Seleccione una moneda, introduzca un valor y ¡le mostraremos su conversión a otras 5 monedas!</p>
    </header>

    <article>
        <h2 hidden>Cambio de moneda</h2>

        <?php
            // Iniciar SESSION
            session_start();

            /**
             * Definición de la clase Moneda
             */
            class Moneda {

                protected $moneda;
                protected $valor;
                protected $json;
                protected $usd;
                protected $eur;
                protected $jpy;
                protected $gbp;
                protected $aud;
                protected $chf;

                public function __construct() {
                    if (!isset($_SESSION['moneda'])) {
                        $_SESSION['moneda'] = "EUR";
                    }
                    $this->moneda = $_SESSION['moneda'];

                    if (!isset($_SESSION['valor'])) {
                        $_SESSION['valor'] = "EUR: ";
                    }
                    $this->valor = $_SESSION['valor'];

                    $apikey = "5859555379feb1d0967bd391c16a71eb";
                    $currencies = "&currencies=USD,EUR,JPY,GBP,AUD,CHF";
                    $format = "&format=1";
                    $url = "http://api.currencylayer.com/live?access_key=" .$apikey .$currencies .$format;
                    $this->cargarCambio($url);
                }

                public function getValor() {
                    return $this->valor;
                }

                private function cargarCambio($url) {
                    if (!isset($_SESSION['json'])) {
                        // Se solicita el archivo JSON de la url que se pasa como parámetro y se recibe como un string
                        $datos = file_get_contents($url);
                        // Se convierte el JSON en un objeto PHP
                        $_SESSION['json'] = json_decode($datos);
                    }
                    $this->json = $_SESSION['json'];

                    if ($this->json != null) {
                        # Datos contenidos en el JSON
                        $this->usd = $this->json->quotes->USDUSD;
                        $this->eur = $this->json->quotes->USDEUR;
                        $this->jpy = $this->json->quotes->USDJPY;
                        $this->gbp = $this->json->quotes->USDGBP;
                        $this->aud = $this->json->quotes->USDAUD;
                        $this->chf = $this->json->quotes->USDCHF;
                    }
                }

                private function appendValor($toAppend) {
                    $_SESSION['valor'] = $this->valor .= $toAppend;
                }

                public function digitos($digito) {
                    $this->appendValor($digito);
                }

                public function punto() {
                    $this->appendValor(".");
                }

                public function borrar() {
                    $_SESSION['valor'] = $this->valor = $this->moneda .": ";
                }

                public function seleccionar($moneda) {
                    $_SESSION['moneda'] = $this->moneda = $moneda;
                    $valor = substr($this->valor, 5);
                    $this->borrar();
                    $this->appendValor($valor);
                }

                public function convertir() {
                    if ($this->json != null) {
                        $valor = floatval(substr($this->valor, 5));

                        switch ($this->moneda) {
                            case "USD":
                                $valor /= $this->usd;
                                break;
                            case "EUR":
                                $valor /= $this->eur;
                                break;
                            case "JPY":
                                $valor /= $this->jpy;
                                break;
                            case "GBP":
                                $valor /= $this->gbp;
                                break;
                            case "AUD":
                                $valor /= $this->aud;
                                break;
                            case "CHF":
                                $valor /= $this->chf;
                                break;
                        }

                        $convUSD = $valor * $this->usd;
                        $convEUR = $valor * $this->eur;
                        $convJPY = $valor * $this->jpy;
                        $convGBP = $valor * $this->gbp;
                        $convAUD = $valor * $this->aud;
                        $convCHF = $valor * $this->chf;

                        return "
                            <ul>
                                <li>EUR: $convEUR</li>
                                <li>USD: $convUSD</li>
                                <li>JPY: $convJPY</li>
                                <li>GBP: $convGBP</li>
                                <li>AUD: $convAUD</li>
                                <li>CHF: $convCHF</li>
                            </ul>
                        ";
                    } else {
                        return "
                            <p>Error en el archivo JSON recibido</p>
                        ";
                    }
                }

                public function pressBoton() {
                    $conversion = "";
                    // Solo se ejecutará si se ha pulsado un botón
                    if (count($_POST) > 0) {
                        if(isset($_POST['seleccionarEUR'])) $this->seleccionar("EUR");
                        if(isset($_POST['seleccionarUSD'])) $this->seleccionar("USD");
                        if(isset($_POST['seleccionarJPY'])) $this->seleccionar("JPY");
                        if(isset($_POST['seleccionarGBP'])) $this->seleccionar("GBP");
                        if(isset($_POST['seleccionarAUD'])) $this->seleccionar("AUD");
                        if(isset($_POST['seleccionarCHF'])) $this->seleccionar("CHF");

                        if(isset($_POST['digitos7'])) $this->digitos(7);
                        if(isset($_POST['digitos8'])) $this->digitos(8);
                        if(isset($_POST['digitos9'])) $this->digitos(9);

                        if(isset($_POST['digitos4'])) $this->digitos(4);
                        if(isset($_POST['digitos5'])) $this->digitos(5);
                        if(isset($_POST['digitos6'])) $this->digitos(6);

                        if(isset($_POST['digitos1'])) $this->digitos(1);
                        if(isset($_POST['digitos2'])) $this->digitos(2);
                        if(isset($_POST['digitos3'])) $this->digitos(3);

                        if(isset($_POST['digitos0'])) $this->digitos(0);
                        if(isset($_POST['punto'])) $this->punto();
                        if(isset($_POST['borrar'])) $this->borrar();

                        if(isset($_POST['convertir'])) $conversion = $this->convertir();
                    }
                    return $conversion;
                }

            }

            $moneda = new Moneda();
            $conversion = $moneda->pressBoton(); 
            $valor = $moneda->getValor();

            // Interfaz con el usuario. En el interior de comillas dobles se deben usar comillas simples
            echo "
                <form action='#' method='post' name='moneda'>
                    <div>
                        <input type='submit' name='seleccionarEUR' value='EUR' />
                        <input type='submit' name='seleccionarUSD' value='USD' />
                        <input type='submit' name='seleccionarJPY' value='JPY' />
                        <input type='submit' name='seleccionarGBP' value='GBP' />
                        <input type='submit' name='seleccionarAUD' value='AUD' />
                        <input type='submit' name='seleccionarCHF' value='CHF' />
                    </div>

                    <div id='valor'>
                        <input type='text' title='Pantalla' value='$valor' disabled />

                        <input type='submit' class='digito' name='digitos7' value='7' />
                        <input type='submit' class='digito' name='digitos8' value='8' />
                        <input type='submit' class='digito' name='digitos9' value='9' />

                        <input type='submit' class='digito' name='digitos4' value='4' />
                        <input type='submit' class='digito' name='digitos5' value='5' />
                        <input type='submit' class='digito' name='digitos6' value='6' />

                        <input type='submit' class='digito' name='digitos1' value='1' />
                        <input type='submit' class='digito' name='digitos2' value='2' />
                        <input type='submit' class='digito' name='digitos3' value='3' />

                        <input type='submit' class='digito' name='digitos0' value='0' />
                        <input type='submit' name='punto' value='.' />
                        <input type='submit' name='borrar' value='C' />
                    </div>

                    <div>
                        <input type='submit' name='convertir' value='Convertir' />
                        $conversion
                    </div>
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
