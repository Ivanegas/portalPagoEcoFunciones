        
    $(document).ready(function() {

      // Validacion de boton de pago cuando tiene amount igual a 0
      if( $("#total").val() == "$ 0.00" ) {
          $("#btnPagar").hide();
      } 

      $("input:checkbox").on('click', function() {
          var ids = [];
          var prices = [];
          var invoicesGrid = {};

          var tot = $('#total');
          tot.val(0);
      
          $('input[name=facturas]').each(function () {

              if($(this).is(':checked')) { 
                  
                  var id = $.trim($(this).attr("tu-attr-id"));
                  var price = $.trim($(this).attr("tu-attr-precio"));

                  if(id in invoicesGrid == false) {
                      invoicesGrid[id] = price; 
                  } else {
                  $('#invoicesGrid').val('');
                  }

                  $('#invoicesGrid').val(JSON.stringify(invoicesGrid));
              } // Crear json

              if($(this).hasClass('mis-checkboxes')) {
                  tot.val(($(this).is(':checked') ? parseFloat($(this).attr('tu-attr-precio')) : 0) + parseFloat(tot.val()));  
              }
              else {
                  tot.val(parseFloat(tot.val()) + (isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val())));
              }

          });

          var totalParts = parseFloat(tot.val()).toFixed(2).split('.');
          tot.val('' + totalParts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '.' +  (totalParts.length > 1 ? totalParts[1] : '00'));   
          $("#btnPagar").show();  // Mostrar btnPagar
      });
      
    });