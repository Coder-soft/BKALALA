@extends('layouts.install')
@section('title', 'Step 2')
@section('content')
<div class="card">
    <div class="card-body text-center">
        <h4 class="card-title mb-2">{{ __('Great Job :)') }} </h4>
        <p>{{ __('There is more few steps to make your website works') }}</p>
        <p class="text-muted">{{ __('Now lets get your website ready.') }}</p>
        <form action="{{route('install/step2/import_database')}}" method="POST" class="my-login-validation" novalidate="">
            @csrf
            <div class="form-group m-0">
                <button type="submit" name="logBtn" class="btn btn-primary btn-block btn-pd"> {{ __('Get Started') }}</button>
            </div>
        </form>
    </div>
</div>
@stop