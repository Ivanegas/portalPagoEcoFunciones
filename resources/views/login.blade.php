@include('template')
    <!-- ======== Preloader =========== -->
    <div class="overlay"></div>
    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
      <!-- ========== section start ========== -->
      <section class="signin-section">
        <div class="container-fluid" style="padding-left: 0px; padding-right: 20%">
          <!-- ========== title-wrapper start ========== -->
          <br>
          <!-- ========== title-wrapper end ========== -->

          <div class="row g-0 auth-row">
            <div class="col-lg-6" style="background-color: #000;">
              <div class="auth-cover-wrapper bg-primary-100">
                <div class="auth-cover">
                  <div class="cover-image">
                    <img src="{{ asset('images/logoSinFondo.png') }}" alt="Click logo">
                  </div>
                </div>
              </div>
            </div>
            <!-- end col -->
            <div class="col-lg-6">
              <div class="signin-wrapper">
                <div class="form-wrapper">
                  <h6 class="mb-15">Inicio de Sesion</h6>
                  <form method="POST" action="{{ route('login') }}" id="frm_login" class="frm_login">
                  @csrf
                    <div class="row">
                      <div class="col-12">
                        <div class="input-style-1">
                          <label>Correo</label>
                          <input  type="text" name="username" id="username" placeholder="Correo" required />
                        </div>
                      </div>
                      <!-- end col -->
                      <div class="col-12">
                        <div class="input-style-1">
                          <label>Contraseña</label>
                          <input type="password" name="password" id="password"  placeholder="********" required/>
                        </div>
                      </div>
                      <!-- end col -->
                      <!-- end col -->
                      <!-- end col -->
                      <div class="col-12">
                        <div class="button-group d-flex justify-content-center flex-wrap">
                          <button class="main-btn primary-btn btn-hover w-100 text-center" style="background-color: #000">
                            Entrar
                          </button>
                        </div>
                      </div>
                    </div>
                    <!-- end row -->
                  </form>
                </div>
              </div>
            </div>
            <!-- end col -->
          </div>
          <!-- end row -->
        </div>
      </section>