
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/libs/jqvmap/dist/jquery.vmap.min.js')}}"></script>
<script src="{{ asset('assets/libs/datatables/datatables.min.js')}}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/js/progressbar/progressbar.js') }}"></script>
@if(Request::path() != "admin/dashboard")
<script src="{{ asset('assets/js/admin/main.js')}}"></script>
@endif
@if(Request::path() == "admin/dashboard")
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
<script src="{{ asset('assets/js/admin/charts.js')}}"></script>
@endif
@if(\Request::segment(2) == "pages")
<script src="{{ asset('assets/libs/ckeditor/ckeditor.js')}}"></script>
<script>
$(function($){
    'use strict';
    var $ckfield = CKEDITOR.replace( 'content' );
    $ckfield.on('change', function() {
      $ckfield.updateElement();         
    });
});
</script>
@endif

