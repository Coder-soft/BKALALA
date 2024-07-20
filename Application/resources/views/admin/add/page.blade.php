@extends('layouts.admin')
@section('title', 'Add page')
@section('content')
<div class="note note-danger print-error-msg" style="display:none"><span></span></div>
<div class="alert alert-info">
    {{__('Contact US page was created by default you can add it to your website using')}} <strong>contact</strong> {{__(' slug.')}}
</div>
<div class="card">
    <div class="card-body">
        <form id="addPageForm" method="POST">
            <div class="form-group">
              <label for="title">{{__('Page Title :')}} <span class="fsgred">*</span></label>
              <input type="text" name="title" id="title" class="form-control" placeholder="Enter page title">
            </div>
            <div class="form-group">
                <label for="slug">{{__('Page Slug :')}} <span class="fsgred">*</span></label>
                <div class="input-group">
                   <span class="input-group-text">{{ url('page/') }}/</span>
                   <input type="text" name="slug" id="slug" class="remove-spaces form-control" placeholder="slug">
                </div>
            </div>
            <div class="form-group">
                <label for="content">{{__('Page Content :')}}</label>
                <textarea class="form-control" name="content" id="content" rows="10"></textarea>
            </div>
            <button class="addPageBtn btn btn-primary" id="addPageBtn">{{__('Add page')}}</button>
        </form>
    </div>
</div>
@endsection