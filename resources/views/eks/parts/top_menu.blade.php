<header>
        <div class="header-area ">
            <div id="sticky-header" class="main-header-area">
                <div class="container-fluid">
                    <div class="header_bottom_border">
                        <div class="row align-items-center">
                            <div class="col-xl-1 col-lg-1">
                                <div class="logo">
                                    <a href="{{ route('home') }}" title="{{ env('APP_NAME') }}">
										{{ env('APP_LOGO') }}
										@php
											$appMenu = explode(',',env('APP_MENU'));
										@endphp
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-9 col-lg-9">
                                <div class="main-menu  d-none d-lg-block">
                                    <nav>
                                        <ul id="navigation">
                                            <li><a class="active" href="{{ route('home') }}">Home</a></li>
											@foreach($appMenu as $apm)
												@php
												$auMn = explode(':',$apm);
												@endphp
											<li><a href="{{ route('home') }}/{{ str_replace(' ','+',$auMn[0]) }}">{{ $auMn[1] }}</a></li>
											@endforeach
											<li><a href="{{ route('page.shop') }}">Shop</a></li>
											<li><a href="{{ route('page.about') }}">About</a></li>
                                            <li><a href="{{ route('page.contact') }}">Contact</a></li>
                                            
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            
                            <div class="seach_icon">
                                <a data-toggle="modal" data-target="#exampleModalCenter" href="#">
                                    <i class="fa fa-search"></i>
                                </a>
                            </div>
                            <div class="col-12">
                                <div class="mobile_menu d-block d-lg-none"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </header>
    