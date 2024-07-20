@extends('layouts.admin')
@section('title', 'Wasabi S3 Settings')
@section('content')
<div class="wasabi_page">
  <div class="note note-danger print-error-msg mt-3" style="display:none"><span></span></div>
    <div class="card">
      <div class="card-header">
        <small class="text-muted">{{__('You can get your details from')}} 
        <a href="https://console.wasabisys.com" target="_blank">{{__('Wasabi console')}}</a></small>
        <span class="col-auto ms-auto d-print-none">
        <img src="{{ asset('images/sections/wsb.png') }}" width="130">
        </span>
      </div>
        <div class="card-body">
            <form id="WasabiForm" method="POST">
              <div class="form-group">
                <label for="wasabi_access_key_id">{{__('Wasabi access key ID :')}}</label>
                <input type="text" name="wasabi_access_key_id" id="wasabi_access_key_id" class="form-control" value="{{ $wasabi->wasabi_access_key_id ?? "" }}">
              </div>
              <div class="form-group">
                <label for="wasabi_secret_access_key">{{__('Wasabi secret access key :')}}</label>
                <input type="text" name="wasabi_secret_access_key" id="wasabi_secret_access_key" class="form-control" value="{{ $wasabi->wasabi_secret_access_key ?? "" }}">
              </div>
              <div class="form-group">
                <label for="wasabi_default_region">{{__('Wasabi default region :')}}</label>
                <input type="text" name="wasabi_default_region" id="wasabi_default_region" class="form-control" placeholder="eu-central-1" value="{{ $wasabi->wasabi_default_region ?? "" }}">
              </div>
              <div class="form-group">
                <label for="wasabi_bucket">{{__('Wasabi bucket :')}}</label>
                <input type="text" name="wasabi_bucket" id="wasabi_bucket" class="form-control" value="{{ $wasabi->wasabi_bucket?? "" }}">
              </div>
              <div class="form-group">
                <label for="wasabi_root">{{__('Wasabi root (Optional) :')}}</label>
                <input type="text" name="wasabi_root" id="wasabi_root" class="form-control" value="{{ $wasabi->wasabi_root ?? "" }}">
              </div>
              <button id="wasabiSaveBtn" class="wasabis3Btn btn btn-primary">{{__('Save changes')}}</button>
            </form>
        </div>
    </div>
</div>
@endsection