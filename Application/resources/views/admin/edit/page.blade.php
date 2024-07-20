@extends('layouts.admin')
@section('title', $page->title)
@section('content')
<div class="note note-danger print-error-msg" style="display:none"><span></span></div>
<div class="card">
    <div class="card-body">
        <form id="editPageForm" method="POST">
            <input type="hidden" name="page_id" id="page_id" value="{{ $page->id }}">
            <div class="form-group">
              <label for="title">{{__('Page Title :')}} <span class="fsgred">*</span></label>
              <input type="text" name="title" id="title" class="form-control" placeholder="Enter page title" value="{{ $page->title }}">
            </div>
            <div class="form-group">
                <label for="slug">{{__('Page Slug :')}} <span class="fsgred">*</span></label>
                <div class="input-group">
                   <span class="input-group-text">{{ url('page/') }}/</span>
                   <input type="text" name="slug" id="slug" class="remove-spaces form-control" placeholder="slug" value="{{ $page->slug }}">
                </div>
            </div>
            <div class="form-group">
                <label for="content">{{__('Page Content :')}}</label>
                <textarea class="form-control" name="content" id="content" rows="10">{{ $page->content }}</textarea>
            </div>
            <button class="editPageBtn btn btn-primary" id="editPageBtn">{{__('Save changes')}}</button>
        </form>
    </div>
</div>
@endsection