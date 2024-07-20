@extends('layouts.admin')
@section('title', 'Update Profile')
@section('content')
<div class="admin__settings">
   <div class="card mb-3">
      <div class="card-body text-center">
         <div class="rounded-circle avatar avatar-xl mb-2">
            <img class="rounded-circle" id="preview_avatar" src="{{ asset('/path/cdn/avatars/'.Auth::user()->avatar) }}" width="100" height="100">
         </div>
         <h2>{{ Auth::user()->name }}</h2>
         <p class="text-muted">{{ Auth::user()->email }}</p>
      </div>
   </div>
   <div class="note note-danger print-error-msg" style="display:none"><span></span></div>
   <div class="row">
      <div class="col-lg-6">
         <div class="card mb-4">
            <div class="card-header">{{__('Admin information')}}</div>
            <form id="informationForm" method="POST" enctype="multipart/form-data">
               @csrf
               <div class="card-body">
                  <div class="form-group">
                     <label for="name">{{__('Profile picture : ')}}</label>
                     <input class="form-control" id="avatar" name="avatar" type="file" accept="image/png, image/jpeg, image/jpg">
                     <small class="text-muted">{{__('Allowed (PNG, JPG, JPEG)')}}</small>
                  </div>
                  <div class="form-group">
                     <label for="name">{{__('Name :')}} <span class="fsgred">*</span></label>
                     <input class="form-control" id="name" name="name" type="text" placeholder="Enter your name" value="{{ Auth::user()->name }}" required>
                  </div>
                  <div class="form-group">
                     <label for="name">{{__('Email :')}} <span class="fsgred">*</span></label>
                     <input class="form-control" id="email" name="email" type="text" placeholder="Enter your email" value="{{ Auth::user()->email }}" required>
                  </div>
                  <button type="submit" id="saveAdminInfoBtn" class="btninfo btn btn-primary">{{__('Save')}}</button>
               </div>
            </form>
         </div>
      </div>
      <div class="col-lg-6">
         <div class="card">
            <div class="card-header">{{__('Security information')}}</div>
            <form id="passwordForm" method="POST" class="mt-2">
               @csrf
               <div class="card-body">
                  <div class="form-group">
                     <label for="new-password" class="control-label">{{__('Current Password :')}} <span class="fsgred">*</span></label>
                     <input id="currentpassword" type="password" class="form-control" name="current-password">
                  </div>
                  <div class="form-group">
                     <label for="new-password" class="control-label">{{__('New Password :')}} <span class="fsgred">*</span></label>
                     <input id="newpassword" type="password" class="form-control" name="new-password" required>
                  </div>
                  <div class="form-group">
                     <label for="new-password-confirm" class="control-label">{{__('Confirm New Password :')}} <span class="fsgred">*</span></label>
                     <input id="newpasswordconfirm" type="password" class="form-control" name="new-password_confirmation" required>
                  </div>
                  <button id="saveAdminPassBtn" type="submit" class="btnpass btn btn-primary">{{__('Save')}}</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection