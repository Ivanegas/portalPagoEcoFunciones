<header class="header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-5 col-md-5 col-6">
              <div class="header-left d-flex align-items-center">
                <div class="menu-toggle-btn mr-15">
                  <button id="menu-toggle" class="main-btn primary-btn btn-hover" style="background-color: black">
                    <i class="lni lni-chevron-left me-2"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="col-lg-7 col-md-7 col-6">
              <div class="header-right">
                <!-- profile start -->
                <div class="profile-box ml-15">
                  <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="profile-info">
                      <div class="info">
                        <div class="image">
                          <img src="{{ asset('images/perfil.png')}}" alt="">
                        </div>
                        <div>
                          <h6 class="fw-500">{{session('customer_info')[0]-> name}}</h6>
                        </div>
                      </div>
                    </div>
                  </button>
                </div>
                <!-- profile end -->
              </div>
            </div>
          </div>
        </div>
</header>