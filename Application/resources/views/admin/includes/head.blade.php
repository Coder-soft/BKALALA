<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $settings->site_name }} — {{__('Admin')}} - @yield('title')</title>
<link href="{{ asset('images/main/'.$settings->favicon) }}" rel="icon">
<link href="{{ asset('assets/libs/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/fontawesome/font-awesome.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/fontawesome/font-awesome-animation.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/app-vendors.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/admin/main.css') }}" rel="stylesheet"/>
