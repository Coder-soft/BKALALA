@extends('layouts.pages')
@section('title', 'Verify your email address')
@section('content')
<div class="flex-fill d-flex flex-column justify-content-center py-5">
   <div class="container">
      <div class="row">
         <div class="col-lg-5 m-auto">
            @if (session('resent'))
            <div class="alert alert-success" role="alert">
               {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
            @endif
            <div class="card">
               <div class="card-body text-center">
                  <h1 class="card-title mb-3">{{__('Verify Your Email Address')}}</h1>
                  <img src="{{ asset('images/sections/email.svg') }}" width="120" height="120"><br>
                  {{__('Before proceeding, please check your email for a verification link.')}}
                  {{__('If you did not receive the email click request another')}}
                  <form method="POST" action="{{ route('verification.resend') }}">
                     @csrf
                     <button type="submit" class="btn btn-primary w-100 mt-3 btn-pd">{{ __('Request another link') }}</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection