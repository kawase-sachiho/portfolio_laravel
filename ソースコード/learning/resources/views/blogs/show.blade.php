@extends('layouts.app')
@section('content')
<div class="m-3">
<h1 class="title-text text-center mb-3">BLOG</h1>
    <table class="table table-responsive table-borderless">
        <tr class="row">
            <th class="col-md-2 sub-title-text">タイトル</th>
            <td class="col-md-10 main-text">{{is_null($blog->title) ? "No title" : $blog->title}}</td>
        </tr>
        <tr class="row">
            <th class="col-md-2 sub-title-text">学習日</th>
            <td class="col-md-10 main-text">{{$blog->learning_date->format('Y年m月d日') }}</td>
        </tr>
        <tr class="row">
            <th class="col-md-2 sub-title-text">学習時間</th>
            <td class="col-md-10  main-text">{{$blog->study_time}}時間</td>
        </tr>
        <tr class="row">
            <th class="col-md-2 sub-title-text">本文</th>
            <td class="col-md-10 main-text">{!! nl2br($blog->content) !!}</td>
        </tr>
        <tr class="row">
            <th class="col-md-2 sub-title-text">コメント</th>
            <td class="col-md-10 main-text">{{$blog->comment}}</td>
        </tr>
    </table>
    <div class="text-end"><a href="{{route('blogs.index')}}" class="btn btn-lg btn-primary col-auto text-right">back</a></div>
</div>

@endsection