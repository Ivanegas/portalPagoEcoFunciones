@include('template')
<!-- ======== sidebar-nav start =========== -->
@include('nav') 
<div class="overlay"></div>


  <!-- ======== main-wrapper start =========== -->
  <main class="main-wrapper">

    <!-- ========== header start ========== -->
    @include('header')
    <!-- ========== header end ========== -->

    <!-- ========== header end ========== -->

    <!-- ========== section start ========== -->
    <section class="table-components">
      <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
          <div class="row align-items-center">
            <div class="col-md-6">
              <div class="title">
                <h2>Mis facturas</h2>
              </div>
            </div>
            <!-- end col -->
            <!-- end col -->
          </div>
          <!-- end row -->
        </div>
        <!-- ========== title-wrapper end ========== -->

        <!-- ========== tables-wrapper start ========== -->
        <div class="row">
          <div class="col-lg-12">
            <div class="card-style mb-30">
              <div class="table-wrapper table-responsive">
                <table class="table">
                  <thead style="background-color: black;">
                    <tr>
                      <th>
                        <h6 style="color: white;">#</h6>
                      </th>
                      <th>
                        <h6 style="color: white;">Numero de Factura</h6>
                      </th>
                      <th>
                        <h6 style="color: white;">Fecha de Creación</h6>
                      </th>
                      <th>
                        <h6 style="color: white;">Fecha de Vencimiento</h6>
                      </th>
                      <th>
                        <h6 style="color: white;">Monto</h6>
                      </th>
                      <th>
                        <h6 style="color: white;">Estado</h6>
                      </th>
                      <th>
                        <h6 style="color: white;">Seleccionar Factura</h6>
                      </th>
                      <th>
                        <h6 style="color: white;">Acciones</h6>
                      </th>
                    </tr>
                    <!-- end table row-->
                  </thead>
                  <tbody>
                  @foreach ($invoices as $invoice)
                    <tr>
                      <td> {{ $invoice->id }} </td>
                      <td class="min-width"> <p>{{ $invoice->number }}</p></td>
                      <td class="min-width"> <p><a href="#0">{{ date('d-m-Y', strtotime($invoice->date_created)) }}</a></p></td>
                      <td class="min-width"> <p>{{ date('d-m-Y', strtotime($invoice->date_till)) }}</p> </td>
                      <td class="min-width"> ${{ number_format((float)$invoice->total , 2, '.', '')}} </td>
                      <td>
                        <div class="action">
                          @if ($invoice->status == 'not_paid')
                           <span class="status-btn active-btn">No pagado</span>
                          @endif
                          @if ($invoice->status == 'paid')
                            <span class="status-btn active-btn">Pagada</span>
                          @endif
                          @if ($invoice->status == 'Pending')
                          <span class="status-btn active-btn">Pendiente</span>
                          @endif
                          @if ($invoice->status == 'Deleted')
                          <span class="status-btn active-btn">Eliminada</span>
                          @endif
                          
                          <!--span class="status-btn active-btn">Pendiente</span-->
                        </div>
                      </td>
                      <td>
                        <center>
                          <div class="check-input-primary">
                            @if ($invoice->status != 'paid')
                            <input name="facturas" type="checkbox" value=" {{ $invoice->number }} "  tu-attr-precio="{{ $invoice->total }}"  tu-attr-id="{{$invoice->id}} " class="mis-checkboxes"></td>
                              <!--input name="facturas" class="form-check-input" type="checkbox" value=" {{ $invoice->number }} "  tu-attr-precio="{{ $invoice->total }}"  tu-attr-id="{{$invoice->id}} " class="mis-checkboxes"></td-->
                            @endif
                          </div>
                        </center>
                      </td>
                      <td>
                        <div class="action">
                          <center>
                          <a href="{{ route('pdfinvoices', ['invoiceID' =>  $invoice->id ]) }}" title="Descargar Factura" style="color: black">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-down" viewBox="0 0 16 16">
  <path d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293z"/>
  <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
</svg>
                            </a>
                          </center>
                        </div>
                      </td>
                    </tr>
                    <!-- end table row -->
                    <!-- end table row -->
                    @endforeach     
                  </tbody>

                  <form   method="POST" action="{{ route('payInvoices') }}"  >
                    @csrf
                    <th colspan="5"></th> 
                    <th> Total a pagar:  </th>
                    <th colspan="1" > 
                    <input  style="background: #393e46; border-radius: 25px; color: white; width:150px; height: 55px; text-align: center;" id="total" name=" total" type="text"  placeholder="0.00" class="form-control"  value="$ 0.00"  readonly/>
                    </th>
                    
                    <input type="hidden" class="form-control" id="email" name="email" value="{{session('customer_info')[0]->email}}" required/>
            
                    <input  type="hidden"  class="form-control"  name="invoicesGrid"  id="invoicesGrid"  value=""><br>

                    <th>
                        <input class="btn btn-dark" id="btnPagar" type="submit" value="Pagar" >       
                    </th>
                
                  </form>
                </table>
                <!-- end table -->
              </div>
            </div>
            <!-- end card -->
          </div>
          <!-- end col -->
        </div>
        <!-- end row -->
      </div>
      <!-- ========== tables-wrapper end ========== -->
      </div>
      <!-- end container -->
    </section>
    <!-- ========== section end ========== -->


    <!-- ========== footer start =========== -->
      @include('footer')
    <!-- ========== footer end =========== -->
  </main>
  <!-- ======== main-wrapper end =========== -->
  @include('sweetalert::alert')
    
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  {{-- <script>
        
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

  </script> --}}