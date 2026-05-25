 <header class="th-header header-layout2">
 	<div class="header-top">
 		<div class="container">
 			<div
 				class="row gy-2 justify-content-center justify-content-lg-between align-items-center">
 				<div class="col-auto">
 					<div class="header-links">
 						<ul>
 							<li><i class="fa-solid fa-envelope"></i><a
 									href="mailto:medovahealth@gmail.com">medovahealth@gmail.com</a>
 							</li>
 							<li class="d-none d-md-inline-block"><i
 									class="fa-solid fa-location-dot"></i>
 								<span>562 Washington Boulevard, New
 									York</span>
 							</li>

 						</ul>
 					</div>
 				</div>
 				<div class="col-auto">
 					<div class="header-button">
						<a href="#" class="th-btn" data-bs-toggle="modal" data-bs-target="#bookDemoModal"><img
								src="{{ asset('frontend/assets/img/icon/alarm.svg') }}"
								alt=""> {{ __('main.book_demo') }}</a>
 						<form class="search-form">
 							<input type="text"
 								placeholder="{{ __('main.search') }}">
 							<button type="submit"><i
 									class="fa-light fa-magnifying-glass"></i></button>
 						</form>

 					</div>
 				</div>
 			</div>
 		</div>
 	</div>
 	<div class="sticky-wrapper">
 		<!-- Main Menu Area -->
 		<div class="container">
 			<div class="menu-area">
 				<div class="row align-items-center justify-content-between">
 					<div class="col-auto">
 						<div class="header-logo">
 							<a href="{{ route('frontend.home') }}"><img
 									src="{{ asset('frontend/assets/img/logo.png') }}"
 									style="height:50px; width:100px;"
 									alt="Randevu "></a>
 						</div>
 					</div>
 					<div class="col-auto">
 						<nav class="main-menu style2 d-none d-lg-inline-block">
 							<ul>
 								<li><a href="{{ route('frontend.home') }}">
 										{{ __('main.home') }}</a>
 								</li>
 								<li><a href="{{ route('frontend.about') }}">
 										{{ __('main.about') }}</a>
 								</li>
 								<li><a href="{{ route('frontend.services') }}">
 										{{ __('main.services') }}</a>
 								</li>
 								<li><a href="{{ route('frontend.faq') }}">
 										{{ __('main.faq') }}</a>
 								</li>

 								<li><a href="{{ route('frontend.subscription') }}">
 										{{ __('main.subscription') }}</a>
 								</li>

 								<li><a href="{{ route('frontend.contact') }}">
 										{{ __('main.contact') }}</a>
 								</li>
 								<!-- multi language menu -->
 								@include('frontend.layout.partials.multi-language-menu')

 							</ul>
 						</nav>
 						<div class="header-button">
 							<button type="button"
 								class="th-menu-toggle d-inline-block d-lg-none"><i
 									class="far fa-bars"></i></button>
 						</div>
 					</div>
 					<div class="col-auto d-none d-xl-block">
 						<div class="header-button">
							<a href="#"
								class="th-btn style2" data-bs-toggle="modal" data-bs-target="#bookDemoModal">{{ __('main.book_demo') }}</a>
 							<!-- <a href="#"
 								class="icon-btn sideMenuToggler d-none d-lg-block"><img
 									src="{{ asset('frontend/assets/img/icon/grid.svg') }}"
 									alt=""></a> -->

 						</div>
 					</div>
 				</div>
 			</div>
 		</div>
 	</div>
 </header>
