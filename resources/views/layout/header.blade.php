<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> +2 95 01 88 821</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> info@domain.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="/"><img src="/images/home/logo.png" alt="" /></a>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
								@if(Auth::guest())
								<li><a href="{{ Route('login') }}" class="{{ Request::is('login') ? 'active' : '' }}"><i class="fa fa-lock"></i> Login/Register</a></li>
								@else
								<li><a href="{{ route('account') }}" class="{{ Request::is('account') ? 'active' : '' }}"><i class="fa fa-user"></i> Account</a></li>
								<li><a href="{{ route('orders') }}" class="{{ Request::is('orders') ? 'active' : '' }}"><i class="fa fa-star"></i> Orders</a></li>
								<li>
									<a href="{{ route('cart') }}" class="{{ Request::is('cart') ? 'active' : '' }}">
										<i class="fa fa-shopping-cart"></i> Cart ({{ Auth::user()->cart->count() }})
									</a>
								</li>
								<li>
									<form action="{{ Route('logout') }}" id="logout" method="post">
										@csrf()
									</form>
									<a onclick="document.getElementById('logout').submit();" href="#"><i class="fa fa-lock"></i> Logout</a>
								</li>
								@endif
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="/" class="{{ Request::is('/') ? 'active' : '' }}">Home</a></li>
								<li class="dropdown"><a href="#" class="{{ Request::is('category/*') ? 'active' : '' }}">Categories<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
										@foreach($categories as $category)
										<li><a href="/category/{{ $category->category_name }}">{{ $category->category_name }}</a></li>
										@endforeach
                                    </ul>
                                </li>
                                <li class="dropdown"><a href="#" class="{{ Request::is('brand/*') ? 'active' : '' }}">Brands<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
										@foreach($brands as $brand)
                                        <li><a href="/brand/{{ $brand->brand_name }}">{{ $brand->brand_name }}</a></li>
										@endforeach
                                    </ul>
                                </li>
								<li><a class="{{ Request::is('contact_us') ? 'active' : '' }}" href="/contact_us">Contact</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="search_box pull-right">
						<form action="/search" method="get">
							<input type="text" name="q" placeholder="Search"/>
						</form>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->