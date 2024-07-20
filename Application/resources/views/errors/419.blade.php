@extends('layouts.pages')
@section('title', 'Page not found')
@section('content')
<div class="error_pages">
    <div class="empty">
        <div class="empty-header">{{__('419')}}</div>
        <p class="empty-title">{{__('Oops… You just found an error page')}}</p>
        <p class="empty-subtitle text-muted">
          {{__('We are sorry but the page you are looking for was not found')}}
        </p>
        <div class="empty-action">
          <a href="{{ url('/') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><line x1="5" y1="12" x2="19" y2="12"></line><line x1="5" y1="12" x2="11" y2="18"></line><line x1="5" y1="12" x2="11" y2="6"></line></svg>
            {{__('back to home')}}
          </a>
        </div>
      </div>
</div>
@endsection