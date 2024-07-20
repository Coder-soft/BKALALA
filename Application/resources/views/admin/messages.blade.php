@extends('layouts.admin')
@section('title', 'Messages')
@section('content')
<div class="ibob_messages">
   @if($messages->count() > 0)
   <div class="card">
      <div class="card-body">
         <div class="divide-y-4">
            @foreach($messages as $message)
            <div class="deletemessage{{ $message->id }} @if($message->status == 1)viewmessage @endif new__message">
               <div class="row">
                  <div class="col-auto">
                     @if($message->user_id != null)
                     <span class="avatar" style="background-image: url({{ asset('path/cdn/avatars/'.$message->user->avatar) }})"></span>
                     @else 
                     <span class="avatar" style="background-image: url({{ asset('path/cdn/avatars/default.png') }})"></span>
                     @endif
                  </div>
                  <div class="col">
                     <div class="text-truncate">
                        <strong>{{ $message->name }}</strong> {{__('sent messages about')}} <strong><a class="text-dark" href="{{ route('view.message', $message->id) }}">"{{ $message->subject }}"</a></strong>.
                     </div>
                     <div class="text-muted">{{ $message->email }}</div>
                  </div>
                  @if($message->status == 1)
                  <div class="unread{{ $message->id }} col-auto align-self-center">
                     <div class="badge bg-primary"></div>
                  </div>
                  @endif
                  <div class="col-auto align-self-center">
                     <span class="text-muted">{{ Carbon\Carbon::parse($message->created_at)->diffForHumans()}}</span>
                     <a href="#" data-id="{{ $message->id }}" id="deleteMsg" class="btn btn-danger btn-sm ms-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                           <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                           <line x1="4" y1="7" x2="20" y2="7" />
                           <line x1="10" y1="11" x2="10" y2="17" />
                           <line x1="14" y1="11" x2="14" y2="17" />
                           <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                           <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                        </svg>
                     </a>
                  </div>
               </div>
            </div>
            @endforeach
         </div>
      </div>
   </div>
   {{$messages->links()}}
   @else 
   <div class="empty">
      <div class="empty-img">
         <img src="{{ asset('images/sections/empty.svg') }}" height="128" alt="">
      </div>
      <p class="empty-title">{{__('No data found')}}</p>
      <p class="empty-subtitle text-muted">
         {{__('This section is empty and has no content.')}}
      </p>
   </div>
   @endif
</div>
@endsection