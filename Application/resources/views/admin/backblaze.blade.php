@extends('layouts.admin')
@section('title', 'Backblaze Settings')
@section('content')
<div class="backblaze_page">
  <div class="note note-danger print-error-msg mt-3" style="display:none"><span></span></div>
  <div class="note note-warning">
    {{__('If you are handling large files we recommend you to use Wasabi or Amazon S3, B2 storage is good for files less than 50MB')}}
  </div>
    <div class="card">
      <div class="card-header">
        <small class="text-muted">{{__('You can get your details from')}} 
        <a href="https://secure.backblaze.com/b2_buckets.htm" target="_blank">{{__('Backblaze console')}}</a></small>
        <span class="col-auto ms-auto d-print-none">
        <img src="{{ asset('images/sections/backblaze-logo.gif') }}" width="130">
        </span>
      </div>
        <div class="card-body">
            <form id="backblazeForm" method="POST">
              <div class="form-group">
                <label for="b2_bucket">{{__('Bucket Name :')}}</label>
                <input type="text" name="b2_bucket" id="b2_bucket" class="form-control" value="{{ $backblaze->b2_bucket ?? "" }}">
              </div>
              <div class="form-group">
                <label for="b2_account_id">{{__('Account ID :')}}</label>
                <input type="text" name="b2_account_id" id="b2_account_id" class="form-control" value="{{ $backblaze->b2_account_id ?? "" }}">
              </div>
              <div class="form-group">
                <label for="b2_application_key">{{__('Application key :')}}</label>
                <input type="text" name="b2_application_key" id="b2_application_key" class="form-control" value="{{ $backblaze->b2_application_key ?? "" }}">
              </div>
              <div class="form-group">
                <label for="b2_url">{{__('Backblaze  URL :')}}</label>
                <input type="text" name="b2_url" id="b2_url" class="form-control" value="{{ $backblaze->b2_url ?? "" }}">
                <small class="text-muted">{{__('Enter url without "/" in the end')}}</small>
              </div>
              <button id="backblazeSaveBtn" class="backblazeBtn btn btn-primary">{{__('Save changes')}}</button>
            </form>
        </div>
    </div>
</div>
@endsection