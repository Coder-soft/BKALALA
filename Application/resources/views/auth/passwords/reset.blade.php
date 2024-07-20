@extends('layouts.pages')
@section('title', 'Reset password')
@section('content')
<div class="flex-fill d-flex flex-column justify-content-center py-5">
   <div class="container-tight py-6">
      <form class="card card-md" method="POST" action="{{ route('password.update') }}">
         @csrf
         <input type="hidden" name="token" value="{{ $token }}">
         <div class="card-body">
            <h2 class="card-title text-center mb-4">{{__('Reset Password')}}</h2>
            <div class="mb-3">
               <label class="form-label">{{__('Email address')}}</label>
               <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
               @error('email')
               <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
               </span>
               @enderror
            </div>
            <div class="mb-3">
               <label class="form-label">{{__('Password')}}</label>
               <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password" name="password" required autocomplete="new-password">
               @error('password')
               <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
               </span>
               @enderror
            </div>
            <div class="mb-3">
               <label class="form-label">{{__('Confirm password')}}</label>
               <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm password" required autocomplete="new-password">
            </div>
            <div class="form-footer">
               <button type="submit" class="btn btn-primary w-100 btn-pd">{{__('Reset Password')}}</button>
            </div>
         </div>
      </form>
   </div>
</div>
@endsection