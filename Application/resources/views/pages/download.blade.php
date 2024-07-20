@extends('layouts.pages')
@section('title', 'Download')
@section('content')
<div class="download_page my-2">
   <div class="container">
      @if($ads->download_top_ads != null)
      <div class="adsn-top d-none d-md-flex">
         {!! $ads->download_top_ads !!}
      </div>
      @endif
      <div class="do_height"></div>
      <div class="row">
        @if($ads->download_left_top_ads != null && $ads->download_left_bottom_ads != null)
         <div class="col-lg-4">
            <div class="desktop-adsn d-none d-md-block">
               @if($ads->download_left_top_ads != null)
               <div class="downoad_ads_top">
                  {!! $ads->download_left_top_ads !!}
               </div>
               @endif
               @if($ads->download_left_bottom_ads != null)
               <div class="do_height"></div>
               <div class="downoad_ads_bottom">
                  {!! $ads->download_left_bottom_ads !!}
               </div>
               @endif
            </div>
         </div>
         @endif
         <div class="col-lg-8  @if($ads->download_left_top_ads == null && $ads->download_left_bottom_ads == null) m-auto @endif">
            <div class="download_box">
                @if($ads->download_left_top_ads != null)
               <div class="mobile-ads-top d-block d-md-none mb-3">
                  <div class="downoad_ads_top">
                     {!! $ads->download_left_top_ads !!}
                  </div>
               </div>
               @endif
               <div class="box">
                  <div class="box-body">
                     <div class="page-header">
                        <div class="row align-items-center">
                           <div class="col-auto">
                              <img src="{{ fileIcon($file->file_type) }}" alt="{{ $file->main_filename }}" width="60" height="60">
                           </div>
                           <div class="col">
                              <h2 class="page-title">{{ shortertext($file->main_filename, 20) }}</h2>
                              <div class="page-subtitle">
                                 <div class="row">
                                    <div class="col-auto">
                                       <span class="text-reset">{{__('File Format : ')}}<span class="do-cap">{{ $file->file_type }}</span></span>
                                    </div>
                                    <div class="col-auto">
                                       <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                          <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                          <polyline points="7 11 12 16 17 11" />
                                          <line x1="12" y1="4" x2="12" y2="16" />
                                       </svg>
                                       <span class="text-reset">{{ $file->downloads }}</span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-auto d-none d-md-flex">
                              <a href="javascript:void(0)" id="downloadfile" class="downloadfile text-dark download_btn btn w-100"></a>
                              <span class="downloading_btn download_btn btn btn text-dark w-100 d-none">{{__('Downloading...')}}</span>
                           </div>
                        </div>
                     </div>
                     <div class="mobile-btn d-flex d-md-none mt-3">
                        <a href="javascript:void(0)" id="downloadfile2" class="downloadfile2 text-dark download_btn btn w-100"></a>
                        <span class="mobiledownloading_btn download_btn btn btn text-dark w-100 d-none">{{__('Downloading...')}}</span>
                     </div>
                  </div>
                  <div class="box-footer">
                     <div class="row">
                        <div class="col">
                           {{__('Upload and share files free and easy')}}
                        </div>
                        @guest
                        <div class="col-auto d-none d-md-flex">
                           <a href="{{ route('register') }}" class="btn btn btn-sm w-100">{{__('Join Now !!')}}</a>
                        </div>
                        @endguest
                     </div>
                  </div>
               </div>
            </div>
            <div class="information-box mt-3">
               <div class="row">
                  <div class="col-lg-6 d-none d-md-flex">
                     <img src="{{ asset('images/sections/download.svg') }}" width="100%">
                  </div>
                  <div class="col-lg-6">
                     <ul class="list-group bg-white no-rounded">
                        <li class="list-group-item do-cap"><strong>{{__('File name :')}}</strong><span class="pull-right">{{ shortertext($file->main_filename, 20) }}</span></li>
                        <li class="list-group-item do-cap"><strong>{{__('File format :')}}</strong><span class="pull-right">{{ $file->file_type }}</span></li>
                        <li class="list-group-item do-cap"><strong>{{__('Downloads :')}}</strong><span class="pull-right">{{ $file->downloads }}</span></li>
                        <li class="list-group-item do-cap"><strong>{{__('Upload date :')}}</strong><span class="pull-right">@datetime($file->created_at)</span></li>
                     </ul>
                  </div>
               </div>
            </div>
            @if($ads->download_left_bottom_ads != null)
            <div class="mobile-ads-bottom d-block d-md-none mb-3 mt-3">
               <div class="downoad_ads_bottom">
                  {!! $ads->download_left_bottom_ads !!}
               </div>
            </div>
            @endif
            <div class="file-description mt-3">
               <h2>{{__('About ')}}{{ shortertext($file->main_filename, 20) }}</h2>
               <p>{{__('The name of this file is ')}}{{ $file->main_filename }}{{__(', which is a ')}}{{ $file->file_type }}{{__(' format, and it is one of the files that can be downloaded and used easily. You can upload similar files without the need for an account, or you can create an account on the site and you will be able to manage your files easily. The site supports many file formats. You can upload your files. Share it anywhere and download it anytime.')}}</p>
               <div class="file-link">
                  <h2>{{__('Share link :')}}</h2>
                  <div class="input-group">
                     <input type="text" class="form-control sharelink" id="sharelink" value="{{ route('download.file', $file->file_id) }}" readonly>
                     <button class="btn" id="copy">{{__('Copy')}}</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection