@extends('layouts.admin')
@section('title', 'View user #'.$user->id)
@section('content')
<div class="card mb-3">
    <div class="card-header bg-primary text-white"><h2 class="m-0">{{__('User information')}}</h2>
        <span class="col-auto ms-auto d-print-none">
         {{__('Joined at :')}} {{ date("d/m/y  H:i A", strtotime($user->created_at))}}
         </span>
    </div>
    <div class="card-body text-center">
        <img class="rounded-circle mb-3" src="{{ asset('path/cdn/avatars/'. $user->avatar) }}" alt="" width="150" height="150">
        <h1>{{ $user->name }}
        </h1>
        <h3 class="text-muted">{{ $user->email }}</h3>
        <h3>
            @if($user->status == 2)
            <span class="badge bg-danger">{{__('Banned')}}</span>
            @elseif($user->status == 1)
            <span class="badge bg-success">{{__('Active')}}</span>
            @endif
            @if($user->permission == 2)
            <span class="badge bg-secondary">{{__('User')}}</span>
            @elseif($user->permission == 1)
            <span class="badge bg-primary">{{__('Admin')}}</span>
            @endif
        </h3>
    </div>
</div>
<div class="card">
   <div class="card-header bg-blue text-white">
      <h2 class="m-0">{{__('User uploads')}}</h2>
   </div>
   <div class="card-body">
      <table id="basic-datatables" class="display table table-striped table-bordered" >
         <thead>
            <tr>
               <th class="text-center">{{__('#')}}</th>
               <th class="text-center">{{__('File id')}}</th>
               <th class="text-center">{{__('User name')}}</th>
               <th class="text-center">{{__('File icon')}}</th>
               <th class="text-center">{{__('File name')}}</th>
               <th class="text-center">{{__('File Size')}}</th>
               <th class="text-center">{{__('Uploaded at')}}</th>
               <th class="text-center">{{__('View / Delete')}}</th>
            </tr>
         </thead>
         <tbody>
             @foreach ($uploads as $upload)
             <tr class="file-table{{ $upload->id }}">
                 <td class="text-center">{{ $upload->id }}</td>
                 <td class="text-center">{{ $upload->file_id }}</td>
                 <td class="text-center">
                     @if($upload->user_id != null)
                       <a href="{{ route('view.user', $upload->user->id) }}">{{ $upload->user->name }}</a>
                     @else 
                     {{__('Anonymous')}}
                     @endif
                 </td>
                 <td class="text-center">
                     <img src="{{ fileIcon($upload->file_type) }}" alt="{{ $upload->file_id }}" width="40" height="40">
                 </td>
                 <td class="text-center">{{ shortertext($upload->main_filename, 15) }}</td>
                 <td class="text-center">{{ formatBytes($upload->file_size) }}</td>
                 <td class="text-center">{{ date("d/m/y  H:i A", strtotime($upload->created_at))}}</td>
                 <td class="text-center">
                     <a href="{{ route('view.file', $upload->id) }}" class="btn btn-info btn-sm">
                         <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
                     </a>
                     <a href="#" data-id="{{ $upload->id }}" id="deleteUpload" class="btn btn-danger btn-sm">
                         <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                     </a>
                 </td>
             </tr>  
             @endforeach
         </tbody>
      </table>
         </div>
     </div>
   </div>
</div>
@endsection