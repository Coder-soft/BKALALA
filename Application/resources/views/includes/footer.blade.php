@if($__env->yieldContent('title') != "Page not found")
<footer class="footer footer-transparent d-print-none">
   <div class="@if(\Request::segment(1) == "ib") container-fluid @else container @endif">
      <div class="text-center">
         <ul class="list-inline list-inline-dots mb-0 ms-0">
            <li class="list-inline-item">
               {{__('Copyright ©')}} <script>document.write(new Date().getFullYear())</script>
               <a href="{{ url('/') }}" class="link-secondary">{{ $settings->site_name }}</a>.
               {{__('All rights reserved.')}}
            </li>
         </ul>
      </div>
   </div>
</footer>
@endif
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/sweetalert/sweetalert.min.js') }}"></script>
@if(Request::path()== "user/dashboard")
@if($uploads->count() > 0)
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
<script src="{{ asset('assets/libs/jqvmap/dist/jquery.vmap.min.js')}}"></script>
<script src="{{ asset('assets/js/user/charts.js')}}"></script>
@endif
@endif
<script src="{{ asset('assets/js/app.js') }}"></script>
@if(Request::path()== "/")
<script src="{{ asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/js/home/ibob.js') }}"></script>
@endif
@if(\Request::segment(1) == "user" or \Request::segment(1) == "admin")
<script src="{{ asset('assets/js/progressbar/progressbar.js') }}"></script>
@endif
@if(\Request::segment(1) == "download")
<script src="{{ asset('assets/js/download.js') }}"></script>
@endif
@if(\Request::segment(1) == "user")
<script src="{{ asset('assets/js/user/main.js') }}"></script>
@endif
{!! NoCaptcha::renderJs() !!}
@if($settings->site_analytics != null)
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings->site_analytics }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '{{ $settings->site_analytics }}');
</script>
@endif