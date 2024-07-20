@extends('layouts.pages')
@section('title', 'SetUp Password')
@section('content')
<div class="container py-4">
   <div class="row">
      <div class="col-lg-6 m-auto">
         <div class="alert alert-info">
            <p>{{__('It looks like your password is not set up yet, and out of an abundance of caution, we ask that you consider set up your password thats will make you log in next time without using any third party')}}</p>
         </div>
         <div class="card">
            <div class="card-body">
               <div class="text-center">
                  <img src="{{asset('/path/cdn/avatars/'.Auth::user()->avatar)}}" width="80" height="80" class="mb-3 rounded-circle">
                  <h4 class="card-title mb-2">{{__('Set account password')}}</h4>
                  <p class="text-muted">{{__('Please enter a password to login next time')}}</p>
               </div>
               <form action="{{ route('addition.password') }}" method="POST" class="my-login-validation" novalidate="">
                  @csrf
                  <div class="form-group">
                     <label for="password">{{__('Password :')}}<span class="fsgred">*</span></label>
                     <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password" name="password" required autocomplete="current-password">
                     @error('password')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="password">{{__('Confirm Password :')}} <span class="fsgred">*</span></label>
                     <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm password" required autocomplete="password_confirmation">
                  </div>
                  <div class="form-group m-0">
                     <button type="submit" name="SubBtn" class="btn btn-primary btn-block">{{__('Continue')}}</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection