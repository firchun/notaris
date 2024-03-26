   <!-- Header start -->
   <header id="header" class="header-one">
       <div class="bg-white">
           <div class="container">
               <div class="logo-area">
                   <div class="row align-items-center">
                       <div class="logo col-lg-3 text-center text-lg-left mb-3 mb-md-5 mb-lg-0">
                           <a class="d-block" href="{{ url('/') }}">
                               <img loading="lazy" src="{{ asset('/') }}img/logo.jpg" alt="Constra"
                                   style="height: 100px;">
                           </a>
                       </div><!-- logo end -->

                       <div class="col-lg-9 header-right">
                           <h2>NOTARIS & PPAT AHMAD ALI MUDDIN, SH., M.Kn</h2>
                       </div><!-- header right end -->
                   </div><!-- logo area end -->

               </div><!-- Row end -->
           </div><!-- Container end -->
       </div>

       <div class="site-navigation">
           <div class="container">
               <div class="row">
                   <div class="col-lg-12">
                       <nav class="navbar navbar-expand-lg navbar-dark p-0">
                           <button class="navbar-toggler" type="button" data-toggle="collapse"
                               data-target=".navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false"
                               aria-label="Toggle navigation">
                               <span class="navbar-toggler-icon"></span>
                           </button>

                           <div id="navbar-collapse" class="collapse navbar-collapse">
                               <ul class="nav navbar-nav mr-auto">
                                   <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Beranda</a></li>
                                   <li class="nav-item"><a class="nav-link"
                                           href="{{ url('/pengajuan_layanan') }}">Pengajuan Layanan</a>
                                   </li>
                                   <li class="nav-item"><a class="nav-link" href="{{ url('/tracking') }}">Tracking</a>
                                   </li>
                                   <li class="nav-item"><a class="nav-link" href="{{ url('/tentang_kami') }}">Tentang
                                           Kami</a></li>
                                   <li class="nav-item"><a class="nav-link" href="{{ url('/kontak_kami') }}">Kontak
                                           Kami</a></li>
                               </ul>
                           </div>
                       </nav>
                   </div>
                   <!--/ Col end -->
               </div>
               <!--/ Row end -->

               <div style="position: absolute;right:18px;top:10px;">
                   @auth
                       <a class="btn btn-primary" href="{{ url('/home') }}">Dashboard</a>
                   @else
                       <a class="btn btn-primary" href="{{ route('login') }}">Login</a>
                   @endauth
               </div><!-- login end -->


           </div>
           <!--/ Container end -->

       </div>
       <!--/ Navigation end -->
   </header>
   <!--/ Header end -->
