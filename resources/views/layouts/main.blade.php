<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<link rel="icon" type="image/png" href="/favicon.png">

		<title>@yield('title', 'emmards')</title>
		<meta property="og:title" content="@yield('title', trans('meta.title'))" />
		<meta property=”og:url” content="{{ URL::full() }}" />
		<meta property="og:type" content="blog" />
		<meta property="og:image" content="@yield('meta_image', url(trans('meta.image')))" />
		<meta name="description" content="@yield('meta_description', trans('meta.description'))">
		<meta name="keywords" content="@yield('meta_keywords', trans('meta.keywords'))">
  		<meta name="author" content="{{ trans('meta.author') }}">
		<link href="{{ URL::full() }}" rel="canonical">
		@if(Request::is('ura*'))
		<meta name="robots" content="noindex, nofollow" />
		@else
		<meta name="robots" content="index, follow" />
		@endif
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.0/css/all.css">
		<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@300;400;600;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="{{ asset('css/main.min.css?d=22061820257') }}" crossorigin="anonymous">

	</head>
	<body>
		<nav id="navbar" class="navbar navbar-expand-lg navbar-light bg-white py-3 sticky-top">
			<div class="container-fluid">
				<a class="navbar-brand font-weight-bolder" href="/">emmards</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
					<ul class="navbar-nav ms-auto text-uppercase font-weight-bolder">
						<li class="nav-item">
							<a class="nav-link" href="{{ route('front.about') }}">About</a>
						</li>
						@if(Auth::check())	
						<li class="nav-item">
							<a class="nav-link" href="{{ route('front.post') }}">Blog</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="{{ route('front.post.archive-page') }}">Archive</a>
						</li>
						<li class="nav-item dropdown">
							<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
								{{ Auth::user()->name }}
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="{{ route('admin.post.create') }}">New Post</a>
								<a class="dropdown-item" href="{{ route('admin.photo.create') }}">New Photo</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="{{ route('admin.post.index') }}">Post</a>
								<a class="dropdown-item" href="{{ route('admin.photo.index') }}">Photo</a>
								<a class="dropdown-item" href="{{ route('admin.tag') }}">Tag</a>
								<a class="dropdown-item" href="{{ route('admin.subscription') }}">Subscription</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="{{ route('logout') }}"
									onclick="event.preventDefault();
													document.getElementById('logout-form').submit();">
									{{ __('Logout') }}
								</a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									@csrf
								</form>
							</div>
						</li>
						@endif
					</ul>
					@if(false)
					<form class="form-inline my-2 my-lg-0" action="{{ route('front.post.search') }}">
						<div class="input-group">
							<input class="form-control border-right-0 border-top-0 rounded-0" type="search" id="txt_search" name="query" value="{{ isset($search) ? $search : '' }}" placeholder="Search" aria-label="Search">
							<div class="input-group-append">
								<div class="input-group-text border-top-0 border-right-0 border-left-0 rounded-0 bg-transparent border-none"><i class="fa fa-sm fa-search"></i></div>
							</div>
						</div>
					</form>
					@endif
				</div>
			</div>
		</nav>
		<div class="content-wrapper">
			@yield('content')
		</div>
		<!-- footer -->
		<footer>
			@if(false)
			<div class="subscribe pt-2" style="background: #EFEFEF;">
				<div class="container">
					<div class="row">
						<div class="col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-12 py-3">
							<div class="text-center mb-3">
								<h4>Subscribe to Updates</h4>
								<div>I will send you an update by sending an email a week. Unsubscribe any time.</div>
							</div>
							<form method="POST" class="mb-5" id="subscribeform">
								<div class="form-group">
									<input type="text" name="name" class="form-control" required placeholder="Your Name" />
								</div>
								<div class="form-group">
									<input type="email" name="email" class="form-control" required placeholder="Your Email" />
								</div>
								<div>
									<button class="btn btn-primary btn-block btn-theme">Subscribe</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			@endif
			<div class="footer">
				<div class="container py-3">
					<div class="row">
						<div class="col-12 py-3 text-center">
							<div class="mb-2">
								<a href="{{ route('front.about') }}" class="text-dark mx-1">About Me</a>
								<a href="{{ route('front.post') }}" class="text-dark mx-1">Blog</a>
								<a href="{{ route('front.post.archive-page') }}" class="text-dark mx-1">Archive</a>
							</div>
							
							<div>
								<ul class="list-unstyled">
							</div>
							<div>&copy; <a href="{{URL('/')}}" class="text-dark">emmards</a> {{ \Carbon\Carbon::now()->format('Y') }}</div>
							@if(false)<div><a href="javasrcipt:void(0)" id="back-to-top" class="text-dark">back to top</a></div>@endif
						</div>
					</div>
				</div>
			</div>
		</footer>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="{{ asset('js/app.js') }}" defer></script>
		<script type="text/javascript">
			var current_scroll = 0;
			$(function() {
				$(document).on('scroll', function() {
					var st = window.pageYOffset || document.documentElement.scrollTop; 
					if (st > 0) {
						$('#navbar').addClass('border-bottom');
					} else {
						$('#navbar').removeClass('border-bottom');
					}
					current_scroll = st <= 0 ? 0 : st;
				});
			});
			$('#back-to-top').click(function(){ 
				$('html,body').animate({ scrollTop: 0 }, 'slow');
				return false; 
			});
		</script>
		@if(env('APP_ENV') == 'prd' && !Request::is('ura*'))
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-68688180-2"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', 'UA-68688180-2');
		</script>
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5e3cfb0e20d60d56"></script>
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5e3cfc95aedbf846"></script>
		@endif
		<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
		<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
		<script type="text/javascript">
			// init Masonry
			var $grid = $('.grid').masonry({
				itemSelector: '.grid-item',
				percentPosition: true,
				columnWidth: '.grid-sizer',
			});
			// layout Masonry after each image loads
			$grid.imagesLoaded().progress( function() {
				$grid.masonry();
				getImageDimension();
			});  

			function getImageDimension() {
				$('.grid-item').each(function() {
					let img = $(this).children()[0];
					if($(img).height() < $(img).width()) {
						$(this).addClass('landscape');
					}
				});
			}
		</script>
		@yield('script')
	</body>
</html>