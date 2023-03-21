@extends('pages/service_core/index')

@section('meta')
    <meta name="title" content="{{$page->meta->meta_title}}">
    <meta name="description" content="{{$page->meta->meta_description}}">
    <meta name="keywords" content="{{$page->meta->meta_keywords}}">
@endsection

@section('content')
    <div class="container">
        <div class="starter-template">
            <h1>{!! $page->title !!}</h1>
            <div>
                {!! $page->content !!}
            </div>
        </div>
    </div>
@endsection