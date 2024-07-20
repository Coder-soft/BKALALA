@extends('layouts.user')
@section('title', 'Settings')
@section('content')
<div class="filebob_dash py-4">
   <div class="row">
      <div class="col-lg-5">
         <div class="sec__title">
            <h1>{{__('Profile information')}}</h1>
            <p>{{__('Here you can update your profile information')}}</p>
         </div>
      </div>
      <div class="col-lg-7">
         <div class="alert alert-danger print-error-msg" style="display:none"><span></span></div>
         <div class="card">
            <form id="informationForm" method="POST" enctype="multipart/form-data">
               <div class="card-body">
                  <div class="rounded-circle avatar avatar-xl mb-3">
                     <img class="rounded-circle" id="preview_avatar" src="{{ asset('/path/cdn/avatars/'.Auth::user()->avatar) }}" width="100" height="100">
                  </div>
                  <div class="form-group mb-2">
                     <input id="avatar" type="file" name="avatar" hidden accept="image/png, image/jpeg, image/jpg"/>
                     <button id="uploadBtn" type="button" class="btn mb-2">{{__('Upload Avatar')}}</button>
                   </div>
                  <div class="form-group">
                     <label for="name">{{__('Name :')}}</label>
                     <input class="form-control" id="name" name="name" type="text" placeholder="Enter your name" value="{{ Auth::user()->name }}" required>
                  </div>
                  <div class="form-group">
                     <label for="name">{{__('Email :')}}</label>
                     <input class="form-control" id="email" name="email" type="text" placeholder="Enter your email" value="{{ Auth::user()->email }}" required>
                  </div>
               </div>
               <div class="card-footer text-right">
                  <button type="submit" id="saveInfoBtn" class="btninfo btn btn-primary">
                  <span class="spinner-border-info spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                  Save
                  </button>
               </div>
            </form>
         </div>
      </div>
   </div>
   <div class="row py-5">
      <div class="col-lg-5">
         <div class="sec__title">
            <h1>{{__('Security information')}}</h1>
            <p>{{__('Here you can change your password')}}</p>
         </div>
      </div>
      <div class="col-lg-7">
         <div class="alert alert-danger print-error-msg-sec" style="display:none"><span></span></div>
         <div class="card">
            <form id="passwordForm" method="POST" class="mt-2">
               <div class="card-body">
                  <div class="form-group">
                     <label for="new-password" class="control-label">{{__('Current Password :')}}</label>
                     <input id="currentpassword" type="password" class="form-control" name="current-password">
                  </div>
                  <div class="form-group">
                     <label for="new-password" class="control-label">{{__('New Password :')}}</label>
                     <input id="newpassword" type="password" class="form-control" name="new-password" required>
                  </div>
                  <div class="form-group">
                     <label for="new-password-confirm" class="control-label">{{__('Confirm New Password :')}}</label>
                     <input id="newpasswordconfirm" type="password" class="form-control" name="new-password_confirmation" required>
                  </div>
               </div>
               <div class="card-footer text-right">
                  <button id="savePassBtn" type="submit" class="btnpass btn btn-primary">
                  <span class="spinner-border-pass spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>{{__('Save')}}</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<script>
   // Upload btn click
   document.getElementById('uploadBtn').addEventListener('click', openDialog);
    // Upload avatar
   function openDialog() {
        document.getElementById('avatar').click();
   }
</script>
@endsection