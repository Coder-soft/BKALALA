@extends('layouts.admin')
@section('title', 'Manage users')
@section('content')
<div class="card">
   <div class="card-header">
      <h2 class="m-0">{{__('All users')}}</h2>
      <span class="col-auto ms-auto d-print-none">
         <button data-bs-toggle="modal" data-bs-target="#modal-simple" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 11h6m-3 -3v6" /></svg>
            {{__('Add Admin')}}
         </button>
      </span>
      <div class="modal modal-blur fade" id="modal-simple" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">{{__('Add new admin')}}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  <div class="note note-danger print-error-msg" style="display:none"><span></span></div>
                  <form id="addAdminForm" method="POST">
                     @csrf
                     <div class="form-group">
                        <label for="name">{{__('Name :')}}</label>
                        <input type="name" id="name" class="form-control fm40" placeholder="Admin name" name="name" required>
                     </div>
                     <div class="form-group">
                        <label for="email">{{__('Email :')}}</label>
                        <input type="email" id="email" class="form-control fm40" placeholder="Admin email" name="email" required>
                     </div>
                     <div class="form-group">
                        <label for="password">{{__('Password :')}}</label>
                        <input type="password" id="password" class="form-control fm40" placeholder="Admin password" name="password" required>
                     </div>
                     <div class="form-group">
                        <label for="confirm-password">{{__('Confirm password :')}}</label>
                        <input type="password" id="confirm-password" class="form-control fm40" placeholder="Confirm password" name="password_confirmation" required>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button id="addAdmin" type="type" class="btnadd btn btn-primary">{{__('Add')}}</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   <div class="card-body">
      <div class="table-responsive">
         <table id="basic-datatables" class="display table table-striped table-bordered" >
            <thead>
               <tr>
                  <th class="text-center">{{__('#ID')}}</th>
                  <th class="text-center">{{__('Avatar')}}</th>
                  <th class="text-center">{{__('Name')}}</th>
                  <th class="text-center">{{__('Email')}}</th>
                  <th class="text-center">{{__('Joined at')}}</th>
                  <th class="text-center">{{__('Permission')}}</th>
                  <th class="text-center">{{__('Status')}}</th>
                  <th class="text-center">{{__('View gallery / Ban & unban')}}</th>
               </tr>
            </thead>
            <tbody>
               @foreach($users as $user)
               <tr>
                  <td class="text-center">{{ $user->id }}</td>
                  <td class="text-center"><img  class="rounded-circle" src="{{ asset('path/cdn/avatars/'.$user->avatar) }}" alt="{{ $user->name}}" width="40" height="40"></td>
                  <td class="text-center">{{ $user->name }}</td>
                  <td class="text-center">{{ $user->email }}</td>
                  <td class="text-center">{{ date("d/m/y  H:i A", strtotime($user->created_at))}}</td>
                  <td class="text-center">
                     @if($user->permission == 2)
                     <span class="badge bg-secondary">{{__('User')}}</span>
                     @elseif($user->permission == 1)
                     <span class="badge bg-primary">{{__('Admin')}}</span>
                     @endif
                  </td>
                  <td class="text-center">
                     <span class="badgeban{{ $user->id }} badge bg-danger @if($user->status == 1) d-none  @endif">{{__('Banned')}}</span>
                     <span class="badgeactive{{ $user->id }} badge bg-success @if($user->status == 2) d-none @endif">{{__('Active')}}</span>
                  </td>
                  <td class="text-center">
                     <a href="{{ route('view.user', $user->id) }}" class="btn btn-secondary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
                        </svg>
                        {{__('View')}}
                     </a>
                     <a href="#" data-id="{{ $user->id }}" id="banuser" class="banuser{{ $user->id }} btn btn-danger btn-sm @if($user->status == 2) d-none @endif">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="5.7" y1="5.7" x2="18.3" y2="18.3" /></svg>
                        {{__('Ban')}}
                     </a>
                     <a href="#" data-id="{{ $user->id }}" id="activeuser" class="activeuser{{ $user->id }} btn btn-success btn-sm @if($user->status == 1) d-none @endif">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 11 12 14 20 6" /><path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" /></svg>
                        {{__('Unban')}}
                     </a>
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
</div>
@endsection