   <!-- Header start -->
   <header id="header" class="header-one">
       <div class="bg-white">
           <div class="container">
               <div class="logo-area">
                   <div class="row align-items-center">
                       <div class="logo col-lg-3 text-center text-lg-left mb-3 mb-md-5 mb-lg-0">
                           <a class="d-block" href="{{ url('/') }}">
                               <img loading="lazy" src="{{ asset('/') }}img/logo.png" alt="Constra"
                                   style="height: 100px;">
                           </a>
                       </div><!-- logo end -->

                       <div class="col-lg-9 header-right">
                           <h2>NOTARIS & PPAT Dr. H. AHMAD ALI MUDDIN, SH., M.Kn</h2>
                       </div><!-- header right end -->
                   </div><!-- logo area end -->

               </div><!-- Row end -->
           </div><!-- Container end -->
       </div>

       <div class="site-navigation ">
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
                                   <li class="nav-item {{ request()->is('/') ? 'active' : '' }}"><a class="nav-link"
                                           href="{{ url('/') }}">Beranda</a></li>
                                   {{-- <li class="nav-item"><a class="nav-link"
                                           href="{{ url('/pengajuan_layanan') }}">Pengajuan Layanan</a>
                                   </li> --}}
                                   <li class="nav-item {{ request()->is('tracking') ? 'active' : '' }}"><a
                                           class="nav-link" href="{{ url('/tracking') }}">Tracking
                                           Dokumen</a>
                                   </li>
                                   <li class="nav-item {{ request()->is('harga') ? 'active' : '' }}"><a class="nav-link"
                                           href="{{ url('/harga') }}">Harga</a></li>
                                   <li class="nav-item {{ request()->is('tentang_kami') ? 'active' : '' }}"><a
                                           class="nav-link" href="{{ url('/tentang_kami') }}">Tentang
                                           Kami</a></li>
                                   <li class="nav-item {{ request()->is('kontak_kami') ? 'active' : '' }}"><a
                                           class="nav-link" href="{{ url('/kontak_kami') }}">Kontak
                                           Kami</a></li>
                                   <li class="nav-item {{ request()->is('panduan') ? 'active' : '' }}"><a
                                           class="nav-link" href="{{ url('/panduan') }}">Panduan</a></li>
                                   @if (Auth::check())
                                       @if (Auth::user()->role == 'User')
                                           <li class="nav-item {{ request()->is('pengajuan_user') ? 'active' : '' }}">
                                               <a class="nav-link " href="{{ url('/pengajuan_user') }}">Pengajuan
                                                   Anda</a>
                                           </li>
                                       @endif
                                   @endif
                               </ul>
                           </div>
                       </nav>
                   </div>
                   <!--/ Col end -->
               </div>
               <!--/ Row end -->

               <div style="position: absolute;right:18px;top:10px;">
                   @auth
                       @if (Auth::user()->role == 'User')
                           <a class="btn btn-warning" href="{{ url('/profile_user') }}">Akun</a>
                           <a class="btn btn-danger" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                               <i class="bx bx-power-off me-2 text-danger"></i>
                               <span class="align-middle">Log Out</span>
                           </a>
                           <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                               @csrf
                           </form>
                       @else
                           <a class="btn btn-primary" href="{{ url('/home') }}">Dashboard</a>
                       @endif
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
