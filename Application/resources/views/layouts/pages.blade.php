<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      @include('includes.head')
   </head>
   @if($ads->mobile_ads != null)
   {!! $ads->mobile_ads !!}
   @endif
   <body @if(Request::path()== "/") class="filebob_home_body" @endif @if(\Request::segment(1) == 'ib') class="bg-white" @endif>
   @if(Request::path()== "/")
   <script>
      "use strict";
        const SITE_URL              = "{{ url('/') }}";
        const MAX_FILES             = {{ $settings->onetime_uploads }};
        const MAX_SIZE              = {{ $settings->max_filesize }};
        const BIG_FILES_DETECTED    = "This File Type not Allowed."; 
   </script>
   @endif
   @if(\Request::segment(1) == "download")
   <script>
      "use strict";
      const DOWN_URL              = "{{ route('download.action', $file->file_id ?? "") }}";
      const DOWN_TXT              = "{{__('Download File ('.formatBytes($file->file_size ?? "").')')}}";
   </script>
   @endif
   @if($__env->yieldContent('title') != "Page not found")
   <header class="navbar navbar-expand-md navbar-light d-print-none @if(\Request::segment(1) == 'download') sticky-top @endif">
      <div class="@if(\Request::segment(1) == "download") container @else  container-fluid @endif">
         @if(\Request::segment(1) != 'addition') 
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
         <span class="navbar-toggler-icon"></span>
         </button>
         @endif
         <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal @if(\Request::segment(1) != 'addition') me-md-3 @endif">
            <a href="{{ url('/') }}">
            <img src="{{ asset('images/main/'.$settings->logo) }}" width="110" height="32" alt="{{ $settings->site_name }}" class="navbar-brand-image">
            </a> @if(\Request::segment(1) == 'addition') <span class="filebob__setup text-muted"> {{__('| SetUp')}}</span> @endif
         </h1>
         <div class="navbar-nav flex-row order-md-last">
            @guest
            <li class="nav-item pe-0 pe-md-2 d-mobile-none">
               <a href="{{ url('/login') }}" class="btn">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                     <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                     <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                     <path d="M20 12h-13l3 -3m0 6l-3 -3" />
                  </svg>
                  {{__('Sign in')}}
               </a>
            </li>
            @if (Route::has('register'))
            <li class="nav-item d-mobile-none">
               <a href="{{ url('/register') }}" class="btn btn-primary">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                     <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                     <circle cx="9" cy="7" r="4" />
                     <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                     <path d="M16 11h6m-3 -3v6" />
                  </svg>
                  {{__('Create account')}}
               </a>
            </li>
            @endif
            <li class="nav-item pe-1 d-md-none mobile-icon">
               <a href="{{ url('/login') }}">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                     <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                     <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                     <path d="M20 12h-13l3 -3m0 6l-3 -3" />
                  </svg>
               </a>
            </li>
            @else
            @if(\Request::segment(1) != 'addition') 
            <li class="nav-item pe-0 pe-md-3 d-mobile-none">
               <a href="{{ url('user/files') }}" class="btn">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 4h3l2 2h5a2 2 0 0 1 2 2v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" /><path d="M17 17v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h2" /></svg>
                  {{__('File Manager')}}
               </a>
            </li>
            @endif
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
                  @if(\Request::segment(1) != 'addition') 
                  <a href="{{ url('user/dashboard') }}" class="dropdown-item">{{__('Dashboard')}}</a>
                  <a href="{{ url('user/files') }}" class="dropdown-item">{{__('File Manager')}}</a>
                  <a href="{{ url('user/settings') }}" class="dropdown-item">{{__('Settings')}}</a>
                  <div class="dropdown-divider"></div>
                  @endif
                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{__('Logout')}}</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                     @csrf
                  </form>
               </div>
            </div>
            @endguest
         </div>
         @if(\Request::segment(1) != 'addition') 
         <div class="collapse navbar-collapse order-md-first" id="navbar-menu">
            <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
               <ul class="navbar-nav">
                  <li class="nav-item @if(Request::path()== '/') active @endif">
                     <a class="nav-link" href="{{ url('/') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <polyline points="5 12 3 12 12 3 21 12 19 12" />
                              <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                              <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                           </svg>
                        </span>
                        <span class="nav-link-title">{{__('Home')}}</span>
                     </a>
                  </li>
                  <li class="nav-item dropdown @if(\Request::segment(1) == 'page') active @endif">
                     <a class="nav-link dropdown-toggle" href="#navbar-third" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <circle cx="12" cy="12" r="9" />
                              <line x1="12" y1="8" x2="12.01" y2="8" />
                              <polyline points="11 12 12 12 12 16 13 16" />
                           </svg>
                        </span>
                        <span class="nav-link-title d-lg-none d-xl-inline-block">{{__('About')}}</span>
                     </a>
                     <div class="dropdown-menu">
                        @if($composerPages->count() > 0)
                        @foreach ($composerPages as $composerPage)
                        <a class="dropdown-item  @if(\Request::segment(2) == $composerPage->slug) active @endif" href="{{ url('page/'.$composerPage->slug) }}">{{ $composerPage->title }}</a>
                        @endforeach
                        @else 
                        <div class="text-center">{{__('No Pages')}}</div>
                        @endif
                     </div>
                  </li>
                  @if(Request::path()== '/')
                  <li class="nav-item">
                     <a class="nav-link" href="#modal-full-width" data-bs-toggle="modal" data-bs-target="#modal-full-width">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <path d="M7 18a4.6 4.4 0 0 1 0 -9a5 4.5 0 0 1 11 2h1a3.5 3.5 0 0 1 0 7h-1" />
                              <polyline points="9 15 12 12 15 15" />
                              <line x1="12" y1="12" x2="12" y2="21" />
                           </svg>
                        </span>
                        <span class="nav-link-title d-lg-none d-xl-inline-block">{{__('Upload')}}</span>
                     </a>
                  </li>
                  @else 
                  <li class="nav-item">
                     <a class="nav-link" href="{{ url('/') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <path d="M7 18a4.6 4.4 0 0 1 0 -9a5 4.5 0 0 1 11 2h1a3.5 3.5 0 0 1 0 7h-1" />
                              <polyline points="9 15 12 12 15 15" />
                              <line x1="12" y1="12" x2="12" y2="21" />
                           </svg>
                        </span>
                        <span class="nav-link-title">{{__('Upload')}}</span>
                     </a>
                  </li>
                  @endif
               </ul>
            </div>
         </div>
         @endif
      </div>
   </header>
   @endif
   @yield('content')
   @include('includes.footer')
   </body>
</html>