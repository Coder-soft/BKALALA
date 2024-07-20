@extends('layouts.pages')
@section('title', 'Login')
@section('content')
<div class="flex-fill d-flex flex-column justify-content-center py-5">
   <div class="container-tight py-6">
      @if(session('error'))
      <div class="note note-danger">
         {{ session('error') }}
      </div>
      @endif
      <form class="card card-md" method="POST" action="{{ route('login') }}">
         @csrf
         <div class="card-body">
            <h2 class="card-title text-center mb-4">{{__('Login to your account')}}</h2>
            <div class="mb-3">
               <label class="form-label">{{__('Email address')}}</label>
               <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus  placeholder="Enter email">
               @error('email')
               <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
               </span>
               @enderror
            </div>
            <div class="mb-2">
               <label class="form-label">
               {{__('Password')}}
               <span class="form-label-description">
               @if (Route::has('password.request'))
               <a href="{{ route('password.request') }}">
               {{ __('Forgot Your Password?') }}
               </a>
               @endif
               </span>
               </label>
               <div class="mb-3">
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter password">
                  @error('password')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="mb-3">
               <label class="form-check">
               <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
               <span class="form-check-label">{{__('Remember me on this device')}}</span>
               </label>
            </div>
            <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
               {!! app('captcha')->display() !!}
               @if ($errors->has('g-recaptcha-response'))
                  <span class="help-block">
                     <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                  </span>
               @endif
             </div>
            <button type="submit" class="btn btn-primary w-100 btn-pd">{{__('Sign in')}}</button>
         </div>
         @if(env('FACEBOOK_CLIENT_ID') != null && env('FACEBOOK_CLIENT_SECRET') != null && env('FACEBOOK_REDIRECT_URL') != null )
         <div class="hr-text">{{__('or')}}</div>
         <div class="card-body">
            <div class="row">
               <div class="col">
                  <a href="{{ route('third-party.action', 'facebook') }}" class="btn btn-white w-100 btn-pd">
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon text-blue" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                     </svg>
                     {{__('Login with facebook')}}
                  </a>
               </div>
            </div>
         </div>
         @endif
      </form>
      <div class="text-center text-muted mt-3">
         {{__('Dont have account yet?')}} <a href="{{ url('/register') }}" tabindex="-1">{{__('Create one')}}</a>
      </div>
   </div>
</div>
@endsection