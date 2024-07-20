@extends('layouts.user')
@section('title', 'File Manager')
@section('content') 
<div class="filebob_dash mt-3">
   @if($uploads->count() > 0)
   <form action="" method="GET">
      <div class="input-icon mb-3">
         <input type="text" class="form-control" name="q" placeholder="Search…">
         <span class="input-icon-addon">
           <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="10" cy="10" r="7"></circle><line x1="21" y1="21" x2="15" y2="15"></line></svg>
         </span>
       </div>
   </form>
   <div class="content">
      <div class="row">
         @foreach($uploads as $upload)
         <div class="col-lg-3 col-xl-2 thisFile{{ $upload->id }}">
            <div class="file-man-box">
               <a href="#" id="deleteFile" data-id="{{ $upload->id }}" class="file-close"><i class="fa fa-times-circle"></i></a>
               <a href="{{ route('download.file', $upload->file_id) }}" target="_blank"  class="file-view"><i class="fa fa-link"></i></a>
               <div class="file-img-box">
                  <img src="{{ fileIcon($upload->file_type) }}" alt="icon">
               </div>
               <a href="{{ route('download.action', $upload->file_id) }}" class="file-download">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                     <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                     <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                     <polyline points="7 11 12 16 17 11" />
                     <line x1="12" y1="4" x2="12" y2="16" />
                  </svg>
               </a>
               <div class="file-man-title">
                  <h5 class="mb-0 text-overflow">{{ $upload->main_filename }}</h5>
                  <p class="mb-0"><small>{{ formatBytes($upload->file_size) }}</small></p>
               </div>
            </div>
         </div>
         @endforeach
      </div>
   </div>
   @if(\Request::input('q') == null)
   {{$uploads->links()}}
   @endif
   @else 
   <div class="empty">
    <div class="empty-img"><img src="{{ asset('images/sections/empty.svg') }}" height="128" alt="">
    </div>
    <p class="empty-title">{{__('No files uploaded')}}</p>
    <p class="empty-subtitle text-muted">
       {{__('Start uploading files it will be visible here.')}}
    </p>
    <div class="empty-action">
       <a href="{{ url('/') }}" class="btn">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
             <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
             <path d="M7 18a4.6 4.4 0 0 1 0 -9a5 4.5 0 0 1 11 2h1a3.5 3.5 0 0 1 0 7h-1"></path>
             <polyline points="9 15 12 12 15 15"></polyline>
             <line x1="12" y1="12" x2="12" y2="21"></line>
         </svg>
         {{__('Start Uploading')}}
       </a>
     </div>
  </div>
   @endif
</div>
@endsection