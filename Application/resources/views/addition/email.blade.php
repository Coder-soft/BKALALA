@extends('layouts.pages')
@section('title', 'Set Email Address')
@section('content')
<div class="flex-fill d-flex flex-column justify-content-center py-4">
   <div class="container-tight py-6">
      <div class="alert alert-info">
         <p>{{__('It looks like your email is not set up yet please enter your email.') }}</p>
      </div>
      <div class="card">
         <div class="card-body">
            <div class="text-center">
               <img src="{{asset('/path/cdn/avatars/'.Auth::user()->avatar)}}" width="80" height="80" class="mb-3 rounded-circle">
               <h4 class="card-title mb-2">{{__('Add email address')}}</h4>
               <p class="text-muted">{{__('Please enter your email address.')}}</p>
            </div>
            <form action="{{ route('addition.email') }}" method="POST" class="my-login-validation">
               @csrf
               <div class="form-group">
                  <label for="email">{{__('E-Mail Address :')}}<span class="fsgred">*</span></label>
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                  @error('email')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
               <div class="form-group m-0">
                  <button type="submit" name="SubBtn" class="btn btn-primary btn-block">{{__('Continue')}}</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection