@extends('layouts.admin')
@section('title', 'Settings')
@section('content')
<div class="note note-danger print-error-msg mt-3" style="display:none"><span></span></div>
<div class="ibob_settings">
   <div class="card">
      <ul class="nav nav-tabs" data-bs-toggle="tabs">
         <li class="nav-item">
            <a href="#info" class="p-3 nav-link active" data-bs-toggle="tab">
            {{__('Website information')}}</a>
         </li>
         <li class="nav-item">
            <a href="#ogofav" class="p-3 nav-link" data-bs-toggle="tab">
            {{__('Logo & Favicon')}}</a>
         </li>
         <li class="nav-item">
            <a href="#api" class="p-3 nav-link" data-bs-toggle="tab">
            {{__('Api')}}</a>
         </li>
         <li class="nav-item">
            <a href="#seo" class="p-3 nav-link" data-bs-toggle="tab">
            {{__('SEO')}}</a>
         </li>
      </ul>
      <div class="card-body">
         <div class="tab-content">
            <div class="tab-pane active show" id="info">
               <form method="POST">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="site_name">{{__('Website Name :')}}<span class="fsgred">*</span></label>
                           <input type="text" name="site_name" id="site_name" class="form-control" placeholder="Enter site name" required value="{{ $settings->site_name ?? ""  }}">
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="storage">{{__('Uploads storage :')}}<span class="fsgred">*</span></label>
                           <select name="storage" id="storage" class="form-select">
                           <option value="1" @if($settings->storage == 1) selected @endif>{{__('Local server')}}</option>
                           <option value="2" @if($settings->storage == 2) selected @endif>{{__('Amazon S3')}}</option>
                           <option value="3" @if($settings->storage == 3) selected @endif>{{__('Wasabi S3')}}</option>
                           <option value="4" @if($settings->storage == 4) selected @endif>{{__('Backblaze')}}</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="site_analytics">{{__('Google analytics :')}}</label>
                     <input type="text" name="site_analytics" id="site_analytics" class="form-control" placeholder="Enter google analytics code" required value="{{ $settings->site_analytics ?? "" }}">
                  </div>
                  <div class="form-group">
                     <label for="home_heading">{{__('Home page heading :')}}<span class="fsgred">*</span></label>
                     <input type="text" name="home_heading" id="home_heading" class="form-control" placeholder="Enter home page heading" required value="{{ $settings->home_heading ?? "" }}">
                  </div>
                  <div class="form-group">
                     <label for="home_descritption">{{__('Home page descritption :')}}<span class="fsgred">*</span></label>
                     <textarea name="home_descritption" id="home_descritption" class="form-control" rows="3" placeholder="Enter home page descritption" required>{{ $settings->home_descritption ?? "" }}</textarea>
                  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="max_filesize">{{__('Max file size (MB) :')}}<span class="fsgred">*</span></label>
                           <input type="number" name="max_filesize" id="max_filesize" class="form-control" placeholder="0" required value="{{ $settings->max_filesize ?? "0" }}">
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="onetime_uploads">{{__('One time uploads :')}}<span class="fsgred">*</span></label>
                           <input type="number" name="onetime_uploads" id="onetime_uploads" class="form-control" placeholder="0" required value="{{ $settings->onetime_uploads ?? "0" }}">
                        </div>
                     </div>
                  </div>
                  <button id="saveInfoBtn" class="infoBtn btn btn-primary">{{__('Save changes')}}</button>
               </form>
            </div>
            <div class="tab-pane" id="ogofav">
               <form method="POST" enctype="multipart/form-data">
                  <div class="image">
                     @if($settings != null)
                     <div class="text-center logobox @if($settings->logo == null) d-none @endif">
                        <img id="preview_logo" src="@if($settings->logo != null){{ asset('images/main/'.$settings->logo) }}@endif" width="110">
                     </div>
                     @endif
                     <div class="form-group">
                        <label for="logo">{{__('Logo :')}} <span class="fsgred">*</span></label>
                        <input type="file" name="logo" id="logo" class="form-control" required>
                        <small class="text-muted">{{__('You can upload any size but the size we recommend')}} (110x32)</small>
                     </div>
                  </div>
                  <div class="image">
                     @if($settings != null)
                     <div class="text-center favbox @if($settings->favicon == null) d-none @endif">
                        <img id="preview_favicon" src="@if($settings->favicon != null){{ asset('images/main/'.$settings->favicon) }}@endif" width="60">
                     </div>
                     @endif
                     <div class="form-group">
                        <label for="favicon">{{__('Favicon :')}} <span class="fsgred">*</span></label>
                        <input type="file" name="favicon" id="favicon" class="form-control" required>
                        <small class="text-muted">{{__('Recommend')}} (60x60)</small>
                     </div>
                  </div>
                  <button id="saveLogoFavBtn" class="btn btn-primary">{{__('Save changes')}}</button>
               </form>
            </div>
            <div class="tab-pane" id="api">
               <div>
                  <form method="POST">
                     <div class="row">
                        <div class="col-lg-6">
                           <div class="inte-box">
                              <h2>{{__('Facebook') }}</h2>
                              <div class="form-group">
                                 <label for="facebook_clientid">{{__('CLIENT ID :')}}</label>
                                 <input type="text" name="facebook_clientid" id="facebook_clientid" class="form-control" value="{{ $api->facebook_clientid ?? "" }}">
                              </div>
                              <div class="form-group">
                                 <label for="facebook_clientsecret">{{__('CLIENT SECRET :')}}</label>
                                 <input type="text" name="facebook_clientsecret" id="facebook_clientsecret" class="form-control" value="{{ $api->facebook_clientsecret ?? "" }}">
                              </div>
                              <div class="form-group">
                                 <label for="facebook_reurl">{{__('REDIRECT URL :')}}</label>
                                 <input type="text" name="facebook_reurl" id="facebook_reurl" class="form-control" value="{{ $api->facebook_reurl ?? "" }}">
                                 <small class="text-muted">{{__('Use this :')}} {{ url('/third-party/facebook/callback') }}</small>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="inte-box">
                              <h2>{{__('Google Captcha ')}}<small class="text-muted">{{__('Please use version V2 "Im not a robot"')}}</small></h2>
                              <div class="form-group">
                                 <label for="google_key">{{__('SITEKEY :')}}</label>
                                 <input type="text" name="google_key" id="google_key" class="form-control" value="{{ $api->google_key ?? "" }}">
                              </div>
                              <div class="form-group">
                                 <label for="google_secret">{{__('SECRET :')}}</label>
                                 <input type="text" name="google_secret" id="google_secret" class="form-control" value="{{ $api->google_secret ?? "" }}">
                              </div>
                           </div>
                        </div>
                     </div>
                     <button id="saveApiBtn" class="apiBtn btn btn-primary">{{__('Save changes')}}</button>
                  </form>
               </div>
            </div>
            <div class="tab-pane" id="seo">
               <form method="POST">
                  <div class="form-group">
                     <label for="seo_title">{{__('Home title :')}} <span class="fsgred">*</span></label>
                     <input type="text" name="seo_title" id="seo_title" class="form-control" placeholder="Enter home page title" value="{{ $seo->seo_title ?? "" }}">
                  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="seo_description">{{__('Description :')}}</label>
                           <textarea name="seo_description" id="seo_description" rows="6" class="form-control" placeholder="Enter description">{{ $seo->seo_description ?? "" }}</textarea>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="seo_keywords">{{__('Keywords :')}}</label>
                           <textarea name="seo_keywords" id="seo_keywords" rows="6" class="form-control" placeholder="tag, tag, tag">{{ $seo->seo_keywords ?? "" }}</textarea>
                        </div>
                     </div>
                  </div>
                  <button id="saveSeoBtn" class="seoBtn btn btn-primary">{{__('Save changes')}}</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection