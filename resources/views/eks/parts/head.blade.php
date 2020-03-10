<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<link rel="canonical" href="{{ url() }}">
    <title>{{ @$q }}  {{ env('APP_NAME','John Deere Video') }}</title>
    
	<?php 
	$m_title 	= isset($q) ? $q.' - '.env('APP_NAME','John Deere Video') : env('APP_NAME','John Deere Video');
	$d_desc 	= isset($desc) ? $desc.' - '.env('KEYWORDS') : env('KEYWORDS');
	$m_desc 	= strip_tags(str_replace('*dot*','.',urldecode($d_desc))) .' '. $m_title ?? $m_title ;
	?>
	
	<meta name="description" content="{{ $m_desc }}">
	<meta name='keywords' content='{{ implode(',',explode(' ',$m_title)) }}'/>
	
	
	<meta property='og:url' content="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"/>
	<meta property='og:title' content="{{ $m_title }}"/>
	<meta property='og:description' content='{{ $m_desc }}'/>
	<meta property='og:image' content=''/>
	<meta property='og:type' content='video'/>
	<meta property='og:site_name' content="{{ env('APP_NAME','John Deere Video') }}"/>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('theme/images/favicon.png') }}">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ url('theme/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('theme/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ url('theme/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ url('theme/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ url('theme/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ url('theme/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ url('theme/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ url('theme/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ url('theme/css/gijgo.css') }}">
    <link rel="stylesheet" href="{{ url('theme/css/animate.css') }}">
    <link rel="stylesheet" href="{{ url('theme/css/slick.css') }}">
    <link rel="stylesheet" href="{{ url('theme/css/slicknav.css') }}">

    <link rel="stylesheet" href="{{ url('theme/css/style.css') }}">
    <!-- <link rel="stylesheet" href="{{ url('theme/css/responsive.css') }}"> -->
	
	<style>
	@media (max-width: 1500px) and (min-width: 1200px){
		.header-area .main-header-area{
			padding: 0px !important;
		}	
	}
	.newletter_area{
		padding:30px;
	}
	.popular_places_area {
		padding-top: 70px;
	}
	.popular_places_area .single_place .place_info .rating_days .days a{
		font-size:12px;
	}
	.popular_places_area .single_place .place_info .rating_days .days{
		font-size:12px;
	}
	.popular_places_area .single_place .place_info h3{
		font-size:18px;
	}
	.place_info p{
		line-height:22px;
	}
	.section-padding {
		padding-top: 50px;
		padding-bottom: 50px;
	}
	.newletter_area {
		background-image: url({{ url('theme/images/newsletter.png') }});
	}
	</style>