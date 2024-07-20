@extends('layouts.admin')
@section('title', 'Message #'.$message->id)
@section('content')
<div class="ibob_messages">
   <div class="row">
      <div class="col-lg-8 m-auto">
         <div class="card mb-3">
            <div class="card-body text-center">
               @if($message->user_id != null)
               <img class="rounded-circle mb-3" src="{{ asset('path/cdn/avatars/'. $message->user->avatar) }}" alt="" width="110" height="110">
               @else 
               <img class="rounded-circle mb-3" src="{{ asset('path/cdn/avatars/default.png') }}" alt="" width="110" height="110">
               @endif
               <h2>{{ $message->name }}</h2>
               <p>{{ $message->email }}</p>
               @if($message->user_id != null)
               <span class="badge bg-primary">{{__('User')}}</span>
               @else 
               <span class="badge bg-secondary">{{__('Not user')}}</span>
               @endif
            </div>
         </div>
         <div class="card">
            <div class="card-header">
               <h2 class="m-0">{{ $message->subject }}</h2>
               <span class="col-auto ms-auto d-print-none">
               {{ date("d/m/y  H:i A", strtotime($message->created_at))}}
               </span>
            </div>
            <div class="card-body">
               {{ $message->message }}
            </div>
         </div>
      </div>
   </div>
</div>
@endsection