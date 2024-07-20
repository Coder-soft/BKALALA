@extends('layouts.pages')
@section('title', 'Sign up')
@section('content')
<div class="flex-fill d-flex flex-column justify-content-center py-5">
   <div class="container-tight py-6">
      <form class="card card-md" method="POST" action="{{ route('register') }}">
         @csrf
         <div class="card-body">
            <h2 class="card-title text-center mb-4">{{__('Create new account')}}</h2>
            <div class="mb-3">
               <label class="form-label">{{__('Full Name')}}</label>
               <input id="name" type="fullname" class="form-control @error('name') is-invalid @enderror" placeholder="Enter your full name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
               @error('name')
               <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
               </span>
               @enderror
            </div>
            <div class="mb-3">
               <label class="form-label">{{__('Email address')}}</label>
               <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email address" name="email" value="{{ old('email') }}" required autocomplete="email">
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
            <div class="mb-3">
               <label class="form-check">
               <input type="checkbox" name="agree" class="form-check-input @error('agree') is-invalid @enderror" required {{ old('agree') ? 'checked' : '' }}/>
               <span class="form-check-label">{{__('I agree with terms and policy.')}}</span>
               </label>
               @error('agree')
               <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
               </span>
               @enderror
            </div>
            <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
               {!! app('captcha')->display() !!}
               @if ($errors->has('g-recaptcha-response'))
                  <span class="help-block">
                     <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                  </span>
               @endif
             </div>
            <button type="submit" class="btn btn-primary w-100 btn-pd">{{__('Create new account')}}</button>
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
                     {{__('SignUp with facebook')}}
                  </a>
               </div>
            </div>
         </div>
         @endif
      </form>
      <div class="text-center text-muted mt-3">
         {{__('Already have account?')}} <a href="{{ url('/login') }}" tabindex="-1">{{__('Login')}}</a>
      </div>
   </div>
</div>
@endsection