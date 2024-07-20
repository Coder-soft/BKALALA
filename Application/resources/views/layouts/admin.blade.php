<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      @include('admin.includes.head')
   </head>
   <script>
      "use strict";
        const BASE_URL              = "{{ url('/') }}";
   </script>
   <body class="antialiased">
      <div class="page">
         <aside class="navbar navbar-vertical navbar-expand-lg navbar-dark bg-black">
            <div class="container-fluid">
               <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
               <span class="navbar-toggler-icon"></span>
               </button>
               <h1 class="navbar-brand navbar-brand-autodark">
                  <a href="{{ url('/admin') }}">
                  <img src="{{ asset('images/main/'.$settings->logo) }}" width="110" height="32" alt="{{ $settings->site_name }}" class="navbar-brand-image">
                  </a>
               </h1>
               <div class="navbar-nav flex-row d-lg-none">
                  <div class="nav-item dropdown">
                     <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                        <span class="avatar avatar-sm" style="background-image: url({{ asset('path/cdn/avatars/'.Auth::user()->avatar) }})"></span>
                        <div class="d-none d-xl-block ps-2">
                           <div>{{ Auth::user()->name }}</div>
                           <div class="mt-1 small text-muted">
                              @if(Auth::user()->permission == 2) {{__('User')}} @elseif(Auth::user()->permission == 1) {{__('Admin')}} @endif
                           </div>
                        </div>
                     </a>
                     <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a href="{{ url('admin/dashboard') }}" class="dropdown-item">{{__('Dashboard')}}</a>
                        <a href="{{ url('admin/profile') }}" class="dropdown-item">{{__('Update profile')}}</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{__('Logout')}}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                           @csrf
                        </form>
                     </div>
                  </div>
               </div>
               <div class="collapse navbar-collapse" id="navbar-menu">
                  <ul class="navbar-nav pt-lg-3">
                     <li class="nav-item @if(\Request::segment(2) == "dashboard") active @endif">
                     <a class="nav-link" href="{{ url('admin/dashboard') }}" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <polyline points="5 12 3 12 12 3 21 12 19 12" />
                              <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                              <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                           </svg>
                        </span>
                        <span class="nav-link-title">
                        {{__('Dashboard')}}
                        </span>
                     </a>
                     </li>
                     <li class="nav-item @if(\Request::segment(2) == "users") active @endif">
                     <a class="nav-link" href="{{ url('admin/users') }}" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <circle cx="9" cy="7" r="4" />
                              <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                              <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                              <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                           </svg>
                        </span>
                        <span class="nav-link-title">
                        {{__('Manage users')}}
                        </span>
                     </a>
                     </li>
                     <li class="nav-item @if(\Request::segment(2) == "uploads") active @endif">
                     <a class="nav-link" href="{{ url('admin/uploads') }}" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <path d="M7 18a4.6 4.4 0 0 1 0 -9a5 4.5 0 0 1 11 2h1a3.5 3.5 0 0 1 0 7h-1" />
                              <polyline points="9 15 12 12 15 15" />
                              <line x1="12" y1="12" x2="12" y2="21" />
                           </svg>
                        </span>
                        <span class="nav-link-title">
                        {{__('Manage uploads')}}
                        </span>
                     </a>
                     </li>
                     <li class="nav-item @if(\Request::segment(2) == "amazon") active @endif">
                     <a class="nav-link" href="{{ url('admin/amazon') }}" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" aria-labelledby="title"
                              aria-describedby="desc" role="img" xmlns:xlink="http://www.w3.org/1999/xlink">
                              <path data-name="layer2"
                                 d="M48.7 32.852V11.819C48.7 8.214 45.2 0 32.694 0 20.09-.1 13.388 7.713 13.388 14.824l10.5.9s2.3-7.111 7.8-7.111 5.1 4.407 5.1 5.308a45.384 45.384 0 0 0-.1 4.707c-6.9.2-24.208 2.2-24.208 16.826 0 15.624 19.706 16.325 26.208 6.21a4.709 4.709 0 0 0 .9 1.2c2.4 2.5 5.6 5.508 5.6 5.508l8.1-8.012S48.7 36.758 48.7 32.852zm-12-1.8c0 11.518-12 9.715-12 2.5 0-6.71 7.2-8.113 12-8.213z"
                                 fill="#fff"></path>
                              <path data-name="layer1" d="M55.4 52.682c-26.408 12.519-42.714 2-53.217-4.307-.6-.4-1.8.1-.8 1.2C4.885 53.784 16.289 64 31.194 64S55 55.787 56.1 54.385c1.2-1.402.4-2.203-.7-1.703z"
                                 fill="#fff"></path>
                              <path data-name="layer1" d="M62.8 48.576c-.7-.9-4.3-1.1-6.6-.8s-5.7 1.7-5.4 2.5c.1.3.5.2 2 0 1.6-.2 5.9-.7 6.9.5.9 1.2-1.4 6.911-1.8 7.812s.2 1.2.9.5a11.061 11.061 0 0 0 3-4.507c1-2.099 1.5-5.304 1-6.005z"
                                 fill="#fff"></path>
                           </svg>
                        </span>
                        <span class="nav-link-title">
                        {{__('Amazon S3')}}
                        </span>
                     </a>
                     </li>
                     <li class="nav-item @if(\Request::segment(2) == "wasabi") active @endif">
                        <a class="nav-link" href="{{ url('admin/wasabi') }}" >
                           <span class="nav-link-icon d-md-none d-lg-inline-block">
                              <img class="icon" src="{{ asset('images/sections/wasabi.png') }}" alt="wasabi" width="20" height="20">
                           </span>
                           <span class="nav-link-title">
                           {{__('Wasabi S3')}}
                           </span>
                        </a>
                     </li>
                     <li class="nav-item @if(\Request::segment(2) == "backblaze") active @endif">
                        <a class="nav-link" href="{{ url('admin/backblaze') }}" >
                           <span class="nav-link-icon d-md-none d-lg-inline-block">
                              <img class="icon" src="{{ asset('images/sections/backblaze.svg') }}" alt="backblaze">
                           </span>
                           <span class="nav-link-title">
                           {{__('Backblaze')}}
                           </span>
                        </a>
                     </li>
                     <li class="nav-item @if(\Request::segment(2) == "ads") active @endif">
                        <a class="nav-link" href="{{ url('admin/ads') }}" >
                           <span class="nav-link-icon d-md-none d-lg-inline-block">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                 <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                 <polyline points="7 8 3 12 7 16" /><polyline points="17 8 21 12 17 16" />
                                 <line x1="14" y1="4" x2="10" y2="20" />
                              </svg> 
                           </span>
                           <span class="nav-link-title">
                           {{__('Manage Ads')}}
                           </span>
                        </a>
                        </li>
                     <li class="nav-item @if(\Request::segment(2) == "messages") active @endif">
                     <a class="nav-link" href="{{ url('admin/messages') }}" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10" />
                              <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2" />
                           </svg>
                        </span>
                        <span class="nav-link-title">
                        {{__('Inbox Messages')}}
                        </span>
                     </a>
                     </li>
                     <li class="nav-item @if(\Request::segment(2) == "pages") active @endif">
                     <a class="nav-link" href="{{ url('admin/pages') }}" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <path d="M15 3v4a1 1 0 0 0 1 1h4" />
                              <path d="M18 17h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h4l5 5v7a2 2 0 0 1 -2 2z" />
                              <path d="M16 17v2a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2" />
                           </svg>
                        </span>
                        <span class="nav-link-title">
                        {{__('Website pages')}}
                        </span>
                     </a>
                     </li>
                     <li class="nav-item @if(\Request::segment(2) == "settings") active @endif">
                     <a class="nav-link" href="{{ url('admin/settings') }}" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                              <circle cx="12" cy="12" r="3" />
                           </svg>
                        </span>
                        <span class="nav-link-title">
                        {{__('Website settings')}}
                        </span>
                     </a>
                     </li>
                     <li class="nav-item @if(\Request::segment(2) == "profile") active @endif">
                     <a class="nav-link" href="{{ url('admin/profile') }}" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                              <circle cx="12" cy="12" r="3" />
                           </svg>
                        </span>
                        <span class="nav-link-title">
                        {{__('Admin profile')}}
                        </span>
                     </a>
                     </li>
                  </ul>
               </div>
            </div>
         </aside>
         <header class="navbar navbar-expand-md navbar-light d-none d-lg-flex d-print-none">
            <div class="container-xl">
               <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="navbar-nav flex-row order-md-last">
                  <div class="nav-item d-none d-md-flex me-3">
                     <a href="{{ url('admin/messages') }}" class="nav-link px-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                           <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                           <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10" />
                           <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2" />
                        </svg>
                        @if($messages > 0 )
                        <span class="badge bg-red faa-flash animated"></span>
                        @endif
                     </a>
                  </div>
                  <div class="nav-item dropdown">
                     <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                        <span class="avatar avatar-sm" style="background-image: url({{ asset('path/cdn/avatars/'.Auth::user()->avatar) }})"></span>
                        <div class="d-none d-xl-block ps-2">
                           <div>{{ Auth::user()->name }}</div>
                           <div class="mt-1 small text-muted">
                              @if(Auth::user()->permission == 2) {{__('User')}} @elseif(Auth::user()->permission == 1) {{__('Admin')}} @endif
                           </div>
                        </div>
                     </a>
                     <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a href="{{ url('admin/dashboard') }}" class="dropdown-item">{{__('Dashboard')}}</a>
                        <a href="{{ url('admin/profile') }}" class="dropdown-item">{{__('Update profile')}}</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form2').submit();">{{__('Logout')}}</a>
                        <form id="logout-form2" action="{{ route('logout') }}" method="POST" class="d-none">
                           @csrf
                        </form>
                     </div>
                  </div>
               </div>
               <div class="collapse navbar-collapse" id="navbar-menu">
                  <div class="ms-md-auto py-2 py-md-0 me-md-4 order-first order-md-last flex-grow-1">
                     <form action="{{ route('uploads') }}" method="GET">
                        <div class="input-icon">
                           <span class="input-icon-addon">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                 <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                 <circle cx="10" cy="10" r="7"></circle>
                                 <line x1="21" y1="21" x2="15" y2="15"></line>
                              </svg>
                           </span>
                           <input type="text" name="q" class="form-control" placeholder="Search on uploads...">
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </header>
         <div class="content">
            <div class="container-xl">
               <h2>@yield('title')</h2>
               <ol class="breadcrumb breadcrumb-alternate mb-3" aria-label="breadcrumbs">
                  <?php $segments = ''; ?>
                  @foreach(Request::segments() as $segment)
                  <?php $segments .= '/'.$segment; ?>
                  <li class="breadcrumb-item">
                     <a href="{{ url($segments) }}">{{$segment}}</a>
                  </li>
                  @endforeach
               </ol>
               @yield('content')
            </div>
         </div>
      </div>
      @include('admin.includes.footer')
   </body>
</html>