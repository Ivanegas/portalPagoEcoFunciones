@include('template')
<!-- ======== sidebar-nav start =========== -->
  @include('nav') 
  <div class="overlay"></div>
      <!-- ======== main-wrapper start =========== -->
      <main class="main-wrapper">

      <!-- ========== header start ========== -->
      @include('header')
      <!-- ========== header end ========== -->

        <!-- ========== section start ========== -->
        <section class="section">
          <br>
          <div class="card-style text-center"
            style="background-image: url('{{ asset('images/image.png') }}'); background-repeat: no-repeat; background-size: cover; height:500px;">
            <div class="error-box" style="margin-top: 20%;">
              <h1 class="fw-700 mb-15 text-white">ECO Networks</h1>
              <h6 class="mb-10 text-white">El interner más rapido de todo El Salvador</h6>
            </div>
          </div>
          <!-- end container -->
        </section>
        <!-- ========== section end ========== -->

        
        <!-- ========== footer start =========== -->
        @include('footer')
        <!-- ========== footer end =========== -->
      </main>

