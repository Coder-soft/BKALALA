<meta charset="UTF-8">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
@if(\Request::segment(1) != "user" && \Request::segment(1) != "download")
<meta name="description" content="{{ $seo->seo_description ?? "" }}">
<meta name="keywords" content="{{ $seo->seo_keywords?? "" }}">
<meta property="og:title" content="{{ $seo->seo_title ?? "" }}" />
<meta property="og:type" content="website" />
<meta property="og:site_name" content="{{ $settings->site_name ?? "" }}" />
<meta property="og:url" content="{{ url('/') }}" />
<meta property="og:image" content="{{ asset('images/main/'.$settings->logo) }}" />
<meta name="twitter:card" content="summary">
<meta name="twitter:description" content="{{ $seo->seo_description ?? "" }}">
<meta name="twitter:title" content="{{ $settings->site_name }} — {{ $seo->seo_title }}">
<meta name="twitter:site" content="{{ url('/') }}">
@endif
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $settings->site_name }} — @yield('title')</title>
<link href="{{ asset('images/main/'.$settings->favicon) }}" rel="shortcut icon">
<link href="{{ asset('images/main/'.$settings->favicon) }}" type="image/png" rel="icon" sizes="192x192">
<link rel="apple-touch-icon" href="{{ asset('images/main/'.$settings->favicon) }}" sizes="180x180">
<link href="{{ asset('assets/libs/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/fontawesome/font-awesome.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/fontawesome/font-awesome-animation.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/app-vendors.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/ibob.css') }}" rel="stylesheet"/>
@if(\Request::segment(2) == "files")
<link href="{{ asset('assets/css/user/main.css') }}" rel="stylesheet"/>
@endif