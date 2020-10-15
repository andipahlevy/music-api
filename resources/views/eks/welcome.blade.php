<!doctype html>
<html class="no-js" lang="zxx">

<head>
    @include('eks.parts.head')
    @include('eks.parts.style')
</head>

<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    @include('eks.parts.top_menu')
	

	@include('eks.parts.'.$mainPage)
</body>

</html>