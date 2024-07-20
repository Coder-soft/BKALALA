@extends('layouts.pages')
@section('title', $seo->seo_title)
@section('content')
<div class="filebob-drag-zone" id="filebob-drag-zone">
   <div class="ibobdrag filebob-drag-zone-place">
      <div class="filebob-home-modal">
         <div class="modal modal-blur fade" id="modal-full-width" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title">
                        <span class="d-none d-md-flex">{{__('JPEG JPG PNG GIF PDF DOC DOCX XLX XLSX CSV TXT MP4 M4V WMV MP3 M4A WAV APK ZIP RAR - ')}}{{__('Max '.$settings->max_filesize.' MB')}}</span>
                     </h5>
                     <span class="float-right filebob-reset-button d-none">
                        <div class="upload-more" id="filebob-upload-clickable">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <path d="M7 18a4.6 4.4 0 0 1 0 -9a5 4.5 0 0 1 11 2h1a3.5 3.5 0 0 1 0 7h-1" />
                              <polyline points="9 15 12 12 15 15" />
                              <line x1="12" y1="12" x2="12" y2="21" />
                           </svg>
                           {{__('Upload more')}}
                        </div>
                     </span>
                     <button type="button" class="btn-close btn-close-here" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                     <div class="filebob-main-upload-section">
                        <div id="upload-process">
                           <div id="filebob-uploader-box" class="filebob-uploader-box">
                              <div id="filebob-upload-clickable" class="filebob-uploder-place">
                                 <div class="filebob-upload-icon">
                                    <img class="img-responsivee" src="{{ asset('images/sections/upload.png') }}" alt="Upload">
                                 </div>
                                 <h3>{{__('Drag and drop or ')}}<span>{{__('browse')}}</span>{{__(' files here to upload')}}</h3>
                                 <p>{{__('You can upload '.$settings->onetime_uploads.' files in one time.')}}</p>
                                 <p><span>{{__('Max Filesize. '.$settings->max_filesize.' MB(s)')}}</span></p>
                              </div>
                           </div>
                           <div class="uploaded-success row" id="filebob-preview-uploads"></div>
                           <div>
                              <div id="filebob-drop-template" class="col-lg-4 mb-3 m-auto filebob-uploader-area d-none">
                                 <div class="filebob-card fade-in">
                                    <span class="success-icon-box d-none fade-in">
                                       <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                    </span>
                                    <span class="error-icon-box d-none fade-in">
                                       <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>
                                    </span>  
                                    <div class="remove-icon">
                                       <i data-dz-remove class="fa fa-remove"></i>
                                   </div>                                    
                                    <img class="filebob-upload-icon" src="{{ asset('images/sections/loading.gif') }}">
                                    <div class="filebob-files-upload">
                                       <div class="filebob-files-name text-overflow" data-dz-name></div>
                                       <div class="filebob-uploder-progress">
                                          <div class="alert alert-danger alert-error d-none" role="alert"></div>
                                          <div class="input-group mb-3">
                                             <input readonly id="" class="form-control success-input d-none" value="">
                                             <button id="copy" data-id="" class="btn btn-success success-button d-none">{{__('Copy')}}</button>
                                           </div>
                                          <a href="#" target="_blank" class="btn btn-primary btn-download d-none w-100">{{__('Go to download page')}}</a>
                                          <div class="progress upload-progress">
                                             <div data-dz-uploadprogress class="progress-bar bg-primary progress-bar-striped" role="progressbar" style="width: 0%"
                                                aria-valuemin="0" aria-valuemax="100">{{__('Uploading...')}}</div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @if($ads->home_ads_top != null)
      <div class="top-Ads container">
         <div class="filebob__top_ads text-center">
            {!! $ads->home_ads_top !!}
         </div>
      </div>
      @endif
      <div class="filebob-uploader-out" id="filebob-uploader-out">
         <div id="filebob-upload-clickable" class="filebob-home-page-content filebob-uploder-out-place">
            <div class="container-xl">
               <div class="row justify-content-center">
                  <div class="col-10">
                     <div class="filebob-home-text text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="faa-bounce animated icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 18a4.6 4.4 0 0 1 0 -9a5 4.5 0 0 1 11 2h1a3.5 3.5 0 0 1 0 7h-1" /><polyline points="9 15 12 12 15 15" /><line x1="12" y1="12" x2="12" y2="21" /></svg></span>
                        <h2 class="filebob-big-title">{{ $settings->home_heading }}</h2>
                        <p class="filebob-description d-mobile-none">
                           {{ $settings->home_descritption }}
                        </p>
                        <button id="filebob-upload-clickable" class="filebob-strat-uploading btn btn-primary">{{__('Start uploading')}}</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @if($ads->home_ads_bottom != null)
      <div class="bottom-Ads container">
         <div class="filebob__bottom_ads text-center">
            {!! $ads->home_ads_bottom !!}
         </div>
      </div>
      @endif
   </div>
</div>
@endsection