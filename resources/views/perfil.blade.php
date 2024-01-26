@include('template')
    <!-- ======== sidebar-nav start =========== -->
    @include('nav')
    <div class="overlay"></div>
    <!-- ======== sidebar-nav end =========== -->

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
        <!-- ========== header start ========== -->
        @include('header')
        <!-- ========== header end ========== -->

        <!-- ========== section start ========== -->
        <br>
        <br>
        <br>
        <div class="page-content page-container" id="page-content">
            <div class="padding">
                <div class="row container d-flex justify-content-center">
                    <div class="col-xl-6 col-md-12" style="width: 85%;">
                        <div class="card user-card-full">
                            <div class="row m-l-0 m-r-0">
                                <div class="col-sm-4 bg-c-lite-green user-profile">
                                    <div class="card-block text-center text-white">
                                        <div class="m-b-25">
                                            <img src="{{ asset('images/user_image.png')}}" class="img-radius"  alt="" width="150px">
                                        </div>
                                        <h6 class="f-w-600 text-white">{{session('customer_info')[0]->name}}</h6>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Informacion Personal</h6>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Cliente</p>
                                                <h6 class="text-muted f-w-400">{{session('customer_info')[0]->name}}</h6>
                                                <br>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Direccion</p>
                                                <h6 class="text-muted f-w-400">{{session('customer_info')[0]->street_1}}</h6>
                                                <br>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Departamento</p>
                                                <h6 class="text-muted f-w-400"> {{session('customer_info')[0]->city}}</h6>
                                                <br>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Email</p>
                                                <h6 class="text-muted f-w-400">{{session('customer_info')[0]->email}}</h6>
                                                <br>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Telefono</p>
                                                <h6 class="text-muted f-w-400">{{session('customer_info')[0]->phone}}</h6>
                                                <br>
                                            </div>
                                        </div>
                                        <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Informacion del Servicio
                                        </h6>
                                        <br>
                                        <div class="row">
                                            @foreach ($responseCustomerSevices as $customerService)
                                                <div class="col-sm-6">
                                                    <p class="m-b-10 f-w-600">Plan</p>
                                                    <h6 class="text-muted f-w-400">{{$customerService->description}} </h6>
                                                    <br>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p class="m-b-10 f-w-600">Precio</p>
                                                    <h6 class="text-muted f-w-400">${{number_format((float)($customerService->unit_price * 1.13), 2, '.', '')}} </h6>
                                                    <br>
                                                </div>
                                            @endforeach   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ========== section end ========== -->

        <!-- ========== footer start =========== -->
        @include('footer')
        
        <!-- ========== footer end =========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->


