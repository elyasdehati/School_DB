<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <style>
            #side-menu li a{
                transition: background 0.3s ease;
                border-radius: 8px;
                color: #fff !important;
                position: relative;
            }

            #side-menu li a span,
            #side-menu li a i{
                color: #fff !important;
            }

            #side-menu li a:hover{
                background: rgba(255,255,255,0.12);
            }

            #side-menu li a.active::before{
                content: "";
                position: absolute;
                left: 0;
                top: 6px;
                bottom: 6px;
                width: 4px;
                background: #ffffff;
                border-radius: 10px;
            }

            #side-menu li a.active{
                background: rgba(255,255,255,0.18);
            }

            #side-menu li a.active span,
            #side-menu li a.active i,
            #side-menu li a:hover span,
            #side-menu li a:hover i{
                color: #fff !important;
            }
        </style>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <div class="logo-box">
                <a href="{{ route('dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('upload/logo/logo.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg d-flex align-items-center mt-2">
                        <img src="{{ asset('upload/logo/logo.png') }}" alt="" height="60">

                        <span style="margin-left:20px; font-size:23px; font-weight:bold; color:rgb(212, 212, 212);">
                            WDIO
                        </span>
                    </span>
                </a>
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('upload/logo/logo.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('upload/logo/logo.png') }}" alt="" height="24">
                    </span>
                </a>
            </div>

            <ul id="side-menu">

                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i data-feather="home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('all.projects') }}" class="{{ request()->routeIs('all.projects') ? 'active' : '' }}">
                        <i data-feather="file-text"></i>
                        <span> Projects </span>
                    </a>
                </li>

                <li>
                    <a href="#catalog" data-bs-toggle="collapse">
                        <i data-feather="menu"></i>
                        <span> Catalog Management </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="catalog">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.provinces') }}" class="{{ request()->routeIs('all.provinces') ? 'active' : '' }}">
                                    <span class="px-2"> Province </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('all.language') }}" class="{{ request()->routeIs('all.language') ? 'active' : '' }}">
                                    <span class="px-2"> Language </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('all.class.type') }}" class="{{ request()->routeIs('all.class.type') ? 'active' : '' }}">
                                    <span class="px-2"> Class Type </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('all.thematic.area') }}" class="{{ request()->routeIs('all.thematic.area') ? 'active' : '' }}">
                                    <span class="px-2"> Thematic Area </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('all.residence') }}" class="{{ request()->routeIs('all.residence') ? 'active' : '' }}">
                                    <span class="px-2"> Residence Type </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('all.infas') }}" class="{{ request()->routeIs('all.infas') ? 'active' : '' }}">
                                    <span class="px-2"> Infrastructure  </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('all.training.type') }}" class="{{ request()->routeIs('all.training.type') ? 'active' : '' }}">
                                    <span class="px-2"> Training Type  </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('all.status') }}" class="{{ request()->routeIs('all.status') ? 'active' : '' }}">
                                    <span class="px-2"> Status </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('all.project.status') }}" class="{{ request()->routeIs('all.project.status') ? 'active' : '' }}">
                                    <span class="px-2">Project Status </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
</div>