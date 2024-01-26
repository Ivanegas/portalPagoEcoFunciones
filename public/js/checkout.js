    $(document).ready(function () {
        //For Card Number formatted input
        let cardNum = document.querySelector("#creditcard");
        cardNum.onkeyup = function (e) {
            if (this.value == this.lastValue) return;
            var caretPosition = this.selectionStart;
            var sanitizedValue = this.value.replace(/[^0-9]/gi, "");
            var parts = [];

            for (var i = 0, len = sanitizedValue.length; i < len; i += 4) {
                parts.push(sanitizedValue.substring(i, i + 4));
            }

            for (var i = caretPosition - 1; i >= 0; i--) {
                var c = this.value[i];
                if (c < "0" || c > "9") {
                    caretPosition--;
                }
            }
            caretPosition += Math.floor(caretPosition / 4);

            this.value = this.lastValue = parts.join("-");
            this.selectionStart = this.selectionEnd = caretPosition;
        };

        //For Date formatted input
        let expDate = document.querySelector("#expiration")
        expDate.onkeyup = function (e) {
            if (this.value == this.lastValue) return;
            var caretPosition = this.selectionStart;
            var sanitizedValue = this.value.replace(/[^0-9]/gi, "");
            var parts = [];

            for (var i = 0, len = sanitizedValue.length; i < len; i += 2) {
                parts.push(sanitizedValue.substring(i, i + 2));
            }

            for (var i = caretPosition - 1; i >= 0; i--) {
                var c = this.value[i];
                if (c < "0" || c > "9") {
                    caretPosition--;
                }
            }
            caretPosition += Math.floor(caretPosition / 2);

            this.value = this.lastValue = parts.join("/");
            this.selectionStart = this.selectionEnd = caretPosition;
        };

        function verificarCamposLlenos() {
/*         var nombre = $("#nombre").val();
            var email = $("#email").val();
            var tarjeta = $("#creditcard").val();
            var expiracion = $("#expiration").val();
 */
            let nombre = document.querySelector('#nombre').value;
            let credCard = document.querySelector('#creditcard').value;
            let expiration = document.querySelector('#expiration').value;
            let cvv = document.querySelector('#cvv').value;
            /* let credCard = document.querySelector('#creditcard').value; */

            return nombre !== '' && credCard !== '' && expiration !== '' && cvv !== '';
        }

        console.log(verificarCamposLlenos())

        function actualizarEstadoBoton() {
            let btnPagar = document.querySelector('#btnPagar');
            if(verificarCamposLlenos()){
                btnPagar.removeAttribute('disabled');
            }else{
                btnPagar.setAttribute('disabled', true);
            }
        }

        document.querySelector('#nombre').addEventListener('input', actualizarEstadoBoton)
        document.querySelector('#creditcard').addEventListener('input', actualizarEstadoBoton)
        document.querySelector('#expiration').addEventListener('input', actualizarEstadoBoton)
        document.querySelector('#cvv').addEventListener('input', actualizarEstadoBoton)

        // Radio button
        $(".radio-group .radio").click(function () {
            $(this).parent().parent().find(".radio").removeClass("selected");
            $(this).addClass("selected");
        });
    });

    var myLink = document.querySelector('a[href="#"]');
    myLink.addEventListener("click", function (e) {
        e.preventDefault();
    });
