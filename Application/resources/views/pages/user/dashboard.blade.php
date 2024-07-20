@extends('layouts.user')
@section('title', 'Dashboard')
@section('content') 
<div class="filebob_dash mt-3">
   @if($uploads->count() > 0)
   <div class="card">
      <div class="card-header border-0">
         <div class="card-title">{{__('Uploads Activity')}}</div><br>
      </div>
      <div class="card-body">
         <div id="chart-uploads-activity"></div>
      </div>
      <div class="table-responsive mb-0">
         <table class="table card-table table-vcenter">
            <thead>
               <tr>
                  <th>{{__('File')}}</th>
                  <th>{{__('Commit')}}</th>
                  <th>{{__('Date')}}</th>
               </tr>
            </thead>
            <tbody>
               @foreach($uploads as $upload)
               <tr>
                  <td class="w-1">
                     <span><img src="{{ fileIcon($upload->file_type) }}"></span>
                  </td>
                  <td class="td-truncate">
                     <div class="text-truncate">
                        {{__('File uploaded')}} ( <a href="{{ route('download.file', $upload->file_id) }}" target="_blank">{{ route('download.file', $upload->file_id) }}</a> )
                     </div>
                  </td>
                  <td class="text-nowrap text-muted">@datetime($upload->created_at)</td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
   <div class="text-center mt-3">
   <a href="{{ url('user/files') }}" class="btn">{{__('View All uploads')}}</a>
   </div>
   @else 
   <div class="empty">
      <div class="empty-img"><img src="{{ asset('images/sections/empty.svg') }}" height="128" alt="">
      </div>
      <p class="empty-title">{{__('No activity found')}}</p>
      <p class="empty-subtitle text-muted">
         {{__('Start uploading files and your recent activities will be visible here.')}}
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